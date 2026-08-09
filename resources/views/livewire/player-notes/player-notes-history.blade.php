<div>
    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-900">
                Historial de notas
            </h3>
        </div>

        @if ($notes->isEmpty())
        <div class="p-6 text-center text-sm text-gray-500">
            Este jugador todavía no tiene notas.
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Fecha
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Autor
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Nota
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($notes as $note)
                    <tr wire:key="player-note-{{ $note->id }}">
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            {{ $note->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $note->author->name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $note->content }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>