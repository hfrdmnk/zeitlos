<?php

namespace App\Services;

use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Wireable;

class DayService
{
    // Creates a new Day instance for the given date
    public function createDay(Carbon $date): Day
    {
        return new Day(
            $this->calculateStreak($date),
            $date->startOfDay(),
            $this->loadEntry($date),
            $this->loadFlashbacks($date)
        );
    }

    // Calculates the current streak for the given date
    private function calculateStreak(Carbon $date): int
    {
        $streak = 0;
        $currentDate = $date->copy()->subDay();

        while ($this->loadEntry($currentDate)) {
            $streak++;
            $currentDate->subDay();
        }

        if ($this->loadEntry($date)) {
            $streak++;
        }

        return $streak;
    }

    // Loads the entry for the given date
    private function loadEntry(Carbon $date): ?Entry
    {
        return Entry::where('user_id', Auth::id())
            ->whereDate('date', $date)
            ->first();
    }

    // Loads the flashbacks for the given date
    private function loadFlashbacks(Carbon $date): Flashbacks
    {
        return new Flashbacks(
            $this->hasFlashbacks($date),
            $this->loadWeekAgo($date),
            $this->load30DaysAgo($date),
            $this->load100DaysAgo($date),
            $this->loadYearlyFlashbacks($date)
        );
    }

    private function hasFlashbacks(Carbon $date): bool
    {
        return $this->loadWeekAgo($date) !== null
            || $this->load30DaysAgo($date) !== null
            || $this->load100DaysAgo($date) !== null
            || $this->loadYearlyFlashbacks($date)->isNotEmpty();
    }

    private function loadWeekAgo(Carbon $date): ?Entry
    {
        return $this->loadEntryForDate($date->copy()->subWeek());
    }

    private function load30DaysAgo(Carbon $date): ?Entry
    {
        return $this->loadEntryForDate($date->copy()->subDays(30));
    }

    private function load100DaysAgo(Carbon $date): ?Entry
    {
        return $this->loadEntryForDate($date->copy()->subDays(100));
    }

    private function loadYearlyFlashbacks(Carbon $date): Collection
    {
        $entries = Entry::where('user_id', Auth::id())
            ->whereMonth('date', $date->month)
            ->whereDay('date', $date->day)
            ->where('date', '!=', $date)
            ->get();

        return $entries->mapWithKeys(function ($entry) use ($date) {
            $yearDiff = $entry->date->year - $date->year;
            return [$yearDiff => $entry];
        })->sortKeys();
    }

    private function loadEntryForDate(Carbon $date): ?Entry
    {
        return Entry::where('user_id', Auth::id())
            ->whereDate('date', $date)
            ->first();
    }
}

class Day implements Wireable
{
    public function __construct(
        public int $streak,
        public Carbon $date,
        public ?Entry $entry,
        public Flashbacks $flashbacks
    ) {}

    public function toLivewire()
    {
        return [
            'streak' => $this->streak,
            'date' => $this->date->toDateString(),
            'entry' => $this->entry?->toArray(),
            'flashbacks' => $this->flashbacks->toLivewire(),
        ];
    }

    public static function fromLivewire($value)
    {
        return new static(
            $value['streak'],
            Carbon::parse($value['date']),
            $value['entry'] ? Entry::make($value['entry']) : null,
            Flashbacks::fromLivewire($value['flashbacks'])
        );
    }
}

class Flashbacks implements Wireable
{
    public function __construct(
        public bool $hasFlashbacks,
        public ?Entry $weekAgo,
        public ?Entry $thirtyDaysAgo,
        public ?Entry $hundredDaysAgo,
        public Collection $yearlyFlashbacks
    ) {}

    public function toLivewire()
    {
        return [
            'hasFlashbacks' => $this->hasFlashbacks,
            'weekAgo' => $this->weekAgo?->toArray(),
            'thirtyDaysAgo' => $this->thirtyDaysAgo?->toArray(),
            'hundredDaysAgo' => $this->hundredDaysAgo?->toArray(),
            'yearlyFlashbacks' => $this->yearlyFlashbacks->map(function ($entry) {
                return $entry->toArray();
            })->all(),
        ];
    }

    public static function fromLivewire($value)
    {
        return new static(
            $value['hasFlashbacks'],
            $value['weekAgo'] ? Entry::make($value['weekAgo']) : null,
            $value['thirtyDaysAgo'] ? Entry::make($value['thirtyDaysAgo']) : null,
            $value['hundredDaysAgo'] ? Entry::make($value['hundredDaysAgo']) : null,
            collect($value['yearlyFlashbacks'])->map(fn($e) => Entry::make($e))
        );
    }
}
