<?php

namespace App\Repositories\Eloquent;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentPlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    /**
     * @return Collection<int, PlayerNote>
     */
    public function getByPlayer(Player $player): Collection
    {
        return $player->notes()
            ->with('author')
            ->latest('created_at')
            ->get();
    }

    public function create(
        Player $player,
        User $author,
        string $content
    ): PlayerNote {
        return $player->notes()->create([
            'author_id' => $author->id,
            'content' => $content,
        ]);
    }
}
