<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NbaDraftController;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    // NBA Draft CRUD Routes (non-shortcut)
    Route::get('nba', [NbaDraftController::class, 'index'])->name('nba.index'); // Show all draft picks
    Route::get('nba/create', [NbaDraftController::class, 'create'])->name('nba.create'); // Form to add new pick
    Route::post('nba', [NbaDraftController::class, 'store'])->name('nba.store'); // Save new pick
    Route::get('nba/{nbaDraft}', [NbaDraftController::class, 'show'])->name('nba.show'); // Show single pick
    Route::get('nba/{nbaDraft}/edit', [NbaDraftController::class, 'edit'])->name('nba.edit'); // Form to edit
    Route::put('nba/{nbaDraft}', [NbaDraftController::class, 'update'])->name('nba.update'); // Update pick
    Route::delete('nba/{nbaDraft}', [NbaDraftController::class, 'destroy'])->name('nba.destroy'); // Delete pick
});

require __DIR__.'/auth.php';
