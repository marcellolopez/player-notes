<?php

namespace App\Repositories\Contracts;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface PlayerNoteRepositoryInterface
{
    public function getByPlayer(Player $player): Collection;

    public function create(
        Player $player,
        User $author,
        string $content
    ): PlayerNote;
}
