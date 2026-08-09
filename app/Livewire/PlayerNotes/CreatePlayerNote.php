<?php

namespace App\Livewire\PlayerNotes;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreatePlayerNote extends Component
{
    public Player $player;

    public string $content = '';

    public string $successMessage = '';

    public function mount(Player $player): void
    {
        $this->player = $player;
    }

    protected function rules(): array
    {
        return [
            'content' => 'required|string|max:1000',
        ];
    }

    public function save(PlayerNoteRepositoryInterface $repository): void
    {
        Gate::authorize('create', PlayerNote::class);

        $validated = $this->validate();

        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        $repository->create(
            $this->player,
            $user,
            $validated['content']
        );

        $this->reset('content');

        $this->successMessage = 'Nota agregada correctamente.';

        $this->dispatch(
            'player-note-created',
            playerId: $this->player->id
        );
    }

    public function render(): View
    {
        return view('livewire.player-notes.create-player-note');
    }
}
