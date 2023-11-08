<div>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white p-4 text-center">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">ID</label>
                    <input type="number" step="1" wire:model="identifier"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">EAN</label>
                    <input type="text" wire:model="ean"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Modello</label>
                    <input type="text" wire:model="model"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Categoria</label>
                    <select wire:model="category"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="">-</option>
                        @foreach (\App\Enums\TireCategory::getValues() as $value)
                            <option value="{{ $value }}">{{ \App\Enums\TireCategory::getDescription($value) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Tipologia</label>
                    <select wire:model="type"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="">-</option>
                        @foreach (\App\Models\Type::get() as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Larghezza</label>
                    <input type="number" step="1" wire:model="width"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Profilo</label>
                    <input type="number" step="1" wire:model="profile"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Diametro</label>
                    <input type="number" step="1" wire:model="diameter"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label class="flex items-center mt-7">
                        <input type="checkbox" class="form-checkbox" value="1" wire:model="commercial">
                        <span class="ml-2">C</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <table class="min-w-full divide-y divide-gray-200 mt-2">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    #
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    EAN
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Misura
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Descrizione
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Categoria
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tipologia
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Q.ta
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Posizione
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Prezzo
                </th>
                <th scope="col"
                    class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aggiungi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($tires as $tire)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->ean }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->width }} {{ $tire->profile }} {{ $tire->diameter }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->brand }} {{ $tire->model }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ \App\Enums\TireCategory::getDescription($tire->category) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->type->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $tire->amount }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $tire->rack_identifier }} {{ $tire->rack_position }}
                    </td>

                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <livewire:reservation.tire-add-amount :reservation="$reservation" :tire="$tire" :key="time() . $tire->id" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pr-4 pl-4 bg-white">
        {{ $tires->links() }}
    </div>
</div>
