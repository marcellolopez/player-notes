<?php

namespace Database\Factories;

use App\Models\PlayerNote;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;
use App\Models\User;

/**
 * @extends Factory<PlayerNote>
 */
class PlayerNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'author_id' => User::factory(),
            'content' => $this->faker->paragraphs(),
        ];
    }
}
