<?php

use App\Livewire\PlayerNotes\CreatePlayerNote;
use App\Models\Player;
use App\Models\User;
use Livewire\Livewire;

test('usuario autorizado puede crear una nota', function () {
    $user = User::factory()->canCreatePlayerNotes()->create();
    $player = Player::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePlayerNote::class, ['player' => $player])
        ->set('content', 'Nota creada desde el test.')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('player_notes', [
        'player_id' => $player->id,
        'author_id' => $user->id,
        'content' => 'Nota creada desde el test.',
    ]);
});

test('usuario sin permiso no puede crear una nota', function () {
    $user = User::factory()->create();
    $player = Player::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePlayerNote::class, ['player' => $player])
        ->set('content', 'Nota que no debería guardarse.')
        ->call('save')
        ->assertForbidden();

    $this->assertDatabaseMissing('player_notes', [
        'content' => 'Nota que no debería guardarse.',
    ]);
});

test('la nota es obligatoria', function () {
    $user = User::factory()->canCreatePlayerNotes()->create();
    $player = Player::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePlayerNote::class, ['player' => $player])
        ->set('content', '')
        ->call('save')
        ->assertHasErrors(['content' => 'required']);
});

test('la nota no puede superar los 1000 caracteres', function () {
    $user = User::factory()->canCreatePlayerNotes()->create();
    $player = Player::factory()->create();

    Livewire::actingAs($user)
        ->test(CreatePlayerNote::class, ['player' => $player])
        ->set('content', str_repeat('a', 1001))
        ->call('save')
        ->assertHasErrors(['content' => 'max']);
});
