<?php

use Illuminate\Support\Facades\Route;
use App\Models\Player;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/players/{player}', function (Player $player) {
    return view('players.show', compact('player'));
})->middleware('auth')->name('players.show');

require __DIR__ . '/settings.php';
