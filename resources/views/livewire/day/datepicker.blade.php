<?php

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
}; ?>

<div>
    <x-mary-datetime wire:model.change="date" :max="$maxDate" />
</div>
