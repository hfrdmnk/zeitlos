<?php

use Livewire\Volt\Component;
use App\Models\Entry;

new class extends Component {
    public $entry;
    public $date;

    public $story;
    public $mood;
    public $moodOptions = [
        [
            'id' => 1,
            'label' => '😞',
        ],
        [
            'id' => 2,
            'label' => '🙁',
        ],
        [
            'id' => 3,
            'label' => '😐',
        ],
        [
            'id' => 4,
            'label' => '😊',
        ],

        [
            'id' => 5,
            'label' => '😁',
        ],
    ];

    public function mount($entry)
    {
        $this->story = $entry?->story;
        $this->mood = $entry?->mood;
    }

    public function save()
    {
        $validated = $this->validate([
            'date' => ['required', 'date', 'before_or_equal:today'],
            'story' => ['nullable', 'string', 'max:65535'],
            'mood' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        if (is_null($validated['story']) && is_null($validated['mood'])) {
            $this->addError('story', 'You must at least enter a story or rate your day to create an entry.');
            return;
        }

        $date = $validated['date'];
        $entry = $this->entry ?? new Entry();
        $entry->story = $validated['story'];
        $entry->mood = $validated['mood'];
        $entry->date = $date;
        $entry->user_id = Auth::id();
        $entry->save();

        $this->dispatch('entry-updated', date: $date);
    }
}; ?>

<div class="flex flex-col gap-8 p-8">
    <div class="flex flex-col items-center gap-2">
        <h1>{{ $date->format('d.m.Y') }}</h1>
        <h2 class="font-serif text-4xl italic font-semibold">{{ $date->format('l') }}</h2>
    </div>
    <form wire:submit="save" class="flex flex-col gap-4">
        <x-mary-textarea label="Story" wire:model="story" placeholder="Your story of today…" rows="5" />
        <x-mary-radio label="Mood" wire:model="mood" :options="$moodOptions" option-label="label" />
        <x-mary-button type="submit" class="btn-primary" wire:dirty>Save</x-mary-button>
    </form>
</div>
