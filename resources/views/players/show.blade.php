<x-layouts::app.sidebar :title="'Jugador - '.$player->name">

    <flux:main>
        <div class="mx-auto max-w-7xl space-y-6">

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            {{ $player->name }}
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ '@'.$player->username }}
                        </p>

                        @if ($player->email)
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $player->email }}
                        </p>
                        @endif
                    </div>

                    <div class="rounded-md bg-gray-100 px-3 py-1 text-sm text-gray-600">
                        Jugador #{{ $player->id }}
                    </div>
                </div>
            </div>


            <livewire:player-notes.create-player-note :player="$player" />


            <livewire:player-notes.player-notes-history :player="$player" />

        </div>
    </flux:main>

</x-layouts::app.sidebar>