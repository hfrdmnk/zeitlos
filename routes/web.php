<?php

use App\Services\DayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::view('/', 'welcome')
    ->middleware(['guest']);

Route::get('day', function (Request $request): View {
    try {
        $dateInput = $request->input('date', now()->toDateString());
        $date = Carbon::createFromFormat('Y-m-d', $dateInput);
    } catch (\Exception $e) {
        $date = now()->startOfDay();
        dd($date);
    }
    $dayService = new DayService();
    $day = $dayService->createDay($date);

    return view('day', compact('day'));
})
    ->middleware(['auth', 'verified'])
    ->name('day');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
