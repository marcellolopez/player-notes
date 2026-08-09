<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Agente de Soporte',
            'email' => 'soporte@example.com',
            'can_create_player_notes' => true,
        ]);

        User::factory()->create([
            'name' => 'Usuario Consulta',
            'email' => 'consulta@example.com',
            'can_create_player_notes' => false,
        ]);

        $this->call([
            PlayerSeeder::class,
        ]);
    }
}
