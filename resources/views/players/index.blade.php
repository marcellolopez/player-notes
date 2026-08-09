<x-layouts::app.sidebar title="Jugadores">
    <flux:main>
        <div class="mx-auto max-w-7xl space-y-6">

            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Jugadores
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Selecciona un jugador para revisar su historial de notas.
                </p>
            </div>


            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-medium text-gray-900">
                            Lista de jugadores
                        </h2>

                        <span class="text-sm text-gray-500">
                            {{ $players->count() }} jugadores
                        </span>
                    </div>
                </div>


                @if ($players->isEmpty())
                <div class="p-8 text-center text-sm text-gray-500">
                    No hay jugadores registrados.
                </div>
                @else
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Jugador
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Usuario
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Email
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>


                        <tbody class="divide-y divide-gray-200 bg-white">

                            @foreach ($players as $player)
                            <tr class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ $player->name }}
                                    </div>
                                </td>


                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ '@'.$player->username }}
                                </td>


                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $player->email ?? 'Sin email' }}
                                </td>


                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <a
                                        href="{{ route('players.show', $player) }}"
                                        class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                                        Ver notas
                                    </a>

                                </td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
                @endif

            </div>

        </div>
    </flux:main>

</x-layouts::app.sidebar>