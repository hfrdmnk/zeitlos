@php
    $hour = now()->hour;
    $greeting = '';
    $heading = "How's your day going?";
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = 'Good Afternoon';
    } else {
        $greeting = 'Good Evening';
        $heading = 'How was your day?';
    }
@endphp

<x-app-layout>
    <x-day.navbar :day="$day" />
    <main class="min-h-screen w-full bg-gradient-to-t from-base-200 to-base-100">
        <div class="container pb-16 pt-36">
            <div class="mb-8 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <div class="text-base-muted">{{ $greeting }}, {{ auth()->user()->name }}</div>
                    <a href="{{ route('entries.export') }}" class="btn btn-outline btn-sm">
                        <x-mary-icon name="solar.download-line-duotone" class="h-4 w-4" />
                        Export Entries
                    </a>
                </div>
                <h2 class="font-display text-4xl text-base-headings">{{ $heading }}</h2>
            </div>
            <livewire:day.form :entry="$day->entry" :date="$day->date" />
        </div>
    </main>
</x-app-layout>
