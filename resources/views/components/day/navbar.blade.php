<nav class="fixed left-0 top-0 flex w-full items-center justify-between p-4">
    {{-- <x-mary-button icon="solar.sort-by-time-line-duotone" class="btn-ghost" tooltip-right="Open Timeline" /> --}}
    <div class="w-[100px]"></div>
    <livewire:day.datepicker :date="$day->date" />
    <div class="flex gap-2">
        <livewire:day.streak :streak="$day->streak" :entry="isset($day->entry)" />
        <livewire:layout.logout-button />
        {{-- <x-mary-button icon="solar.rewind-back-line-duotone" class="btn-ghost" tooltip-left="Show Flashbacks" /> --}}
    </div>
</nav>
