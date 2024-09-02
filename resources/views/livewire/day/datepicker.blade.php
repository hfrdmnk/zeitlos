<?php

use Carbon\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $date;
    public $maxDate;

    public function mount($date)
    {
        $this->date = $date->format('Y-m-d');
        $this->maxDate = now()->format('Y-m-d');
    }

    public function updatedDate($value)
    {
        $this->redirect(route('day', ['date' => $value]), navigate: true);
    }

    public function goToPreviousDay()
    {
        $previousDay = Carbon::parse($this->date)
            ->subDay()
            ->format('Y-m-d');
        $this->redirect(route('day', ['date' => $previousDay]), navigate: true);
    }

    public function goToNextDay()
    {
        $nextDay = Carbon::parse($this->date)
            ->addDay()
            ->format('Y-m-d');
        $this->redirect(route('day', ['date' => $nextDay]), navigate: true);
    }
}; ?>

<div class="flex items-center gap-2">
    <x-mary-button
        icon="solar.alt-arrow-left-line-duotone"
        class="btn-ghost text-base-muted hover:bg-base-200"
        wire:click="goToPreviousDay"
    />
    <x-mary-datetime
        wire:model.change="date"
        :max="$maxDate"
        class="border-base-300 focus-within:border-accent focus-within:outline-none focus:border-accent focus:outline-none"
    />
    <x-mary-button
        icon="solar.alt-arrow-right-line-duotone"
        class="btn-ghost text-base-muted hover:bg-base-200 disabled:bg-transparent disabled:opacity-50"
        wire:click="goToNextDay"
        :disabled="$date === $maxDate"
    />
</div>
