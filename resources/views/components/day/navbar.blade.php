<nav class="fixed left-0 top-0 flex w-full items-center justify-between p-4">
    {{-- <x-mary-button icon="solar.sort-by-time-line-duotone" class="btn-ghost" tooltip-right="Open Timeline" /> --}}
    <div class="w-[38px]"></div>
    <livewire:day.datepicker :date="$day->date" />
    <div class="flex gap-2">
        <livewire:day.streak :streak="$day->streak" :entry="isset($day->entry)" />
        {{-- <x-mary-button icon="solar.rewind-back-line-duotone" class="btn-ghost" tooltip-left="Show Flashbacks" /> --}}
    </div>
</nav>
