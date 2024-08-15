<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Services\DayService;
use Carbon\Carbon;

new class extends Component {
    public $entry;
    public $streak;

    #[On('entry-updated')]
    public function updateStreakCount($date)
    {
        $dayService = new DayService();
        $day = $dayService->createDay(Carbon::parse($date));
        $this->streak = $day->streak;
        $this->entry = isset($day->entry);
    }
}; ?>

<div class="flex items-center gap-2">
    <x-mary-icon name="solar.flame-bold-duotone" @class([
        'text-amber-400' => $entry,
    ]) />
    <span>{{ $streak }}</span>
</div>
