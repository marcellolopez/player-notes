<?php

use App\Models\Player;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('players.index')
        : redirect()->route('login');
})->name('home');

Route::redirect('/dashboard', '/players')
    ->middleware('auth')
    ->name('dashboard');

Route::get('/players', function () {
    $players = Player::orderBy('name')->get();

    return view('players.index', compact('players'));
})->middleware('auth')->name('players.index');

Route::get('/players/{player}', function (Player $player) {
    return view('players.show', compact('player'));
})->middleware('auth')->name('players.show');

require __DIR__.'/settings.php';
