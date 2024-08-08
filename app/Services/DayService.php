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
            $date->startOfDay(),
            $this->loadEntry($date),
            $this->loadFlashbacks($date)
        );
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
            $this->loadWeekAgo($date),
            $this->load30DaysAgo($date),
            $this->load100DaysAgo($date),
            $this->loadYearlyFlashbacks($date)
        );
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
        public Carbon $date,
        public ?Entry $entry,
        public Flashbacks $flashbacks
    ) {}

    public function toLivewire()
    {
        return [
            'date' => $this->date->toDateString(),
            'entry' => $this->entry?->toArray(),
            'flashbacks' => $this->flashbacks->toLivewire(),
        ];
    }

    public static function fromLivewire($value)
    {
        return new static(
            Carbon::parse($value['date']),
            $value['entry'] ? Entry::make($value['entry']) : null,
            Flashbacks::fromLivewire($value['flashbacks'])
        );
    }
}

class Flashbacks implements Wireable
{
    public function __construct(
        public ?Entry $weekAgo,
        public ?Entry $thirtyDaysAgo,
        public ?Entry $hundredDaysAgo,
        public Collection $yearlyFlashbacks
    ) {}

    public function toLivewire()
    {
        return [
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
            $value['weekAgo'] ? Entry::make($value['weekAgo']) : null,
            $value['thirtyDaysAgo'] ? Entry::make($value['thirtyDaysAgo']) : null,
            $value['hundredDaysAgo'] ? Entry::make($value['hundredDaysAgo']) : null,
            collect($value['yearlyFlashbacks'])->map(fn($e) => Entry::make($e))
        );
    }
}
