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
    <main class="w-full min-h-screen bg-gradient-to-t from-base-200 to-base-100">
        <div class="container pb-16 pt-36">
            <div class="flex flex-col gap-2 mb-8">
                <div class="text-base-muted">{{ $greeting }}, {{ auth()->user()->name }}</div>
                <h2 class="text-4xl font-display text-base-headings">{{ $heading }}</h2>
            </div>
            <livewire:day.form :entry="$day->entry" :date="$day->date" />
        </div>
    </main>
</x-app-layout>
