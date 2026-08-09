<div>
    @can('create', App\Models\PlayerNote::class)
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">
            Agregar nota
        </h3>

        @if ($successMessage)
        <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
            {{ $successMessage }}
        </div>
        @endif

        <form wire:submit="save">
            <div>
                <label for="content" class="mb-2 block text-sm font-medium text-gray-700">
                    Nota
                </label>

                <textarea
                    id="content"
                    wire:model="content"
                    rows="4"
                    maxlength="1000"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    placeholder="Escribe una observación sobre el jugador..."></textarea>

                @error('content')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="mt-4 flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">
                        Agregar nota
                    </span>

                    <span wire:loading wire:target="save">
                        Guardando...
                    </span>
                </button>
            </div>
        </form>
    </div>
    @endcan
</div>