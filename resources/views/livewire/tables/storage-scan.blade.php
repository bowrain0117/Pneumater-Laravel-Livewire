<div>
    <div class="form-check">
        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" wire:model="onlyError" id="onlyError">
        <label class="form-check-label inline-block text-gray-800" for="onlyError">
            Mostra solo errori
        </label>
    </div>
    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    #
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Marca Modello
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Posizione<br />
                    (scansione)
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Posizione<br />
                    (database)
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                </td>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Stato
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($scanTires as $scanTire)
                    @if($scanTire->isWrong() || !$onlyError)
                        <livewire:tables.row.scan-tire :scanTire="$scanTire" :wire:key="$scanTire->id" />
                    @endif
                @endforeach
            </tbody>
        </table>
        @if($scanTires->total() >= 30)
            <div class="p-2">
                {{ $scanTires->links() }}
            </div>
        @endif
    </div>
</div>
