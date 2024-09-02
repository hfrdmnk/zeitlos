<?php

use App\Models\Entry;
use Livewire\Volt\Component;

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
        if ($this->story === '') {
            $this->story = null;
        }

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

<div class="p-8 rounded shadow-md bg-base-front">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-base-muted">{{ $date->format('d.m.Y') }}</h1>
            <div class="text-2xl font-medium">{{ $date->format('l') }}</div>
        </div>
        <x-mary-button
            type="submit"
            class="btn-accent"
            icon="solar.diskette-line-duotone"
            form="edit-entry"
            wire:dirty.attr.remove="disabled"
            disabled
        >
            Save entry
        </x-mary-button>
    </div>
    <form wire:submit="save" id="edit-entry" class="flex flex-col gap-8 mt-8">
        <x-mary-textarea label="Story" wire:model="story" placeholder="Your story of the day…" rows="5" />
        <div class="flex items-center justify-between">
            @foreach ($moodOptions as $option)
                <label class="cursor-pointer">
                    <input type="radio" wire:model="mood" value="{{ $option['id'] }}" class="hidden peer" />
                    <span
                        class="flex items-center justify-center text-2xl transition-colors duration-200 rounded-full h-14 w-14 bg-accent-content peer-checked:bg-accent"
                    >
                        {{ $option['label'] }}
                    </span>
                </label>
            @endforeach
        </div>
        @error('mood')
            <p class="p-1 text-red-500 label-text-alt">{{ $message }}</p>
        @enderror
    </form>
</div>

{{--
    <div class="flex flex-col gap-8 p-8">
    <div class="flex flex-col items-center gap-2">
    <h1>{{ $date->format('d.m.Y') }}</h1>
    <h2 class="font-serif text-4xl italic font-semibold">{{ $date->format('l') }}</h2>
    </div>
    <form wire:submit="save" class="flex flex-col gap-4">
    <x-mary-button type="button" class="btn-accent" wire:click="dispatch('entry-deleted', date: $date)">
    Delete
    </x-mary-button>
    <x-mary-textarea label="Story" wire:model="story" placeholder="Your story of today…" rows="5" />
    <x-mary-radio label="Mood" wire:model="mood" :options="$moodOptions" option-label="label" />
    <x-mary-button type="submit" class="btn-primary" wire:dirty>Save</x-mary-button>
    </form>
    </div>
--}}
