<?php


namespace App\Livewire\PlayerNotes;


use App\Models\Player;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;


class PlayerNotesHistory extends Component
{
    public Player $player;

    protected PlayerNoteRepositoryInterface $repository;


    public function boot(PlayerNoteRepositoryInterface $repository): void
    {
        $this->repository = $repository;
    }


    public function mount(Player $player): void
    {
        $this->player = $player;
    }


    #[On('player-note-created')]
    public function refreshNotes(int $playerId): void
    {
        if ($playerId !== $this->player->id) {
            return;
        }
    }


    public function render(): View
    {
        return view('livewire.player-notes.player-notes-history', [
            'notes' => $this->repository->getByPlayer($this->player),
        ]);
    }
}
