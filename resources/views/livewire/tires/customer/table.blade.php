<div>
    <div class="w-full">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3 inline-flex">
                <div class="shadow sm:rounded-md sm:overflow-hidden px-4 py-5 bg-white">
                    <b>Azioni (su selezione):</b> <br/>
                    @if(auth()->user()->registry_id)
                        <a href="{{ route('tires.buy', ['tires' => $tires_selected]) }}">
                            <button
                                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded ml-2 mx-1">
                                <i class="bi bi-bag-fill"></i> {{ __('Buy') }}
                            </button>
                        </a>
                    @else
                        <i>
                            Anagrafica venditore assente. Non è permesso inserire ordini. Contattare Pneumatici
                            Adriatica!
                        </i>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    ({{ count($tires_selected)  }})
                </th>
                <th wire:click="$set('order_by', 'id')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    #
                    @if($order_by == 'id')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'category')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Categoria
                    @if($order_by == 'category')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'width')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Larghezza
                    @if($order_by == 'width')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'profile')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Profilo
                    @if($order_by == 'profile')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'diameter')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Diametro
                    @if($order_by == 'diameter')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    C
                </th>
                <th wire:click="$set('order_by', 'brand')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Marca
                    @if($order_by == 'brand')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'model')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Modello
                    @if($order_by == 'model')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Millimetri
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Stagione
                </th>
                <th wire:click="$set('order_by', 'load_index')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Indice carico
                    @if($order_by == 'load_index')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'speed_index')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Indice velocità
                    @if($order_by == 'speed_index')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'dot')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Anno costruzione
                    @if($order_by == 'dot')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'amount')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Q.ta
                    @if($order_by == 'amount')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Prezzo netto (al singolo)
                </th>
                <th scope="col"
                    class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Immagini
                </th>
                <th scope="col" class="relative px-6 py-3 text-right bg-gray-100">
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="checkbox" wire:model="tires_selected_all" value="1"/><br/>
                    Tutto
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="identifier"
                           wire:keydown.enter="storeIdentifier"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @foreach($storedIdentifiers as $storedIdentifier)
                        <span wire:click="removeIdentifier({{ $storedIdentifier }})"
                              class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $storedIdentifier }}</span>
                    @endforeach
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <select
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        wire:model="category"
                    >
                        <option></option>
                        @foreach(\App\Enums\TireCategory::getValues() as $value)
                            <option value="{{ $value }}">{{ \App\Enums\TireCategory::getDescription($value) }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="width_from"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="profile_from"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="diameter_from"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="checkbox"
                           wire:model="is_commercial_yes"
                           value="1"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="is_commercial_yes"
                           class="ml-3 block text-sm font-medium text-gray-700 mr-4">
                        Si
                    </label>

                    <input type="checkbox"
                           wire:model="is_commercial_no"
                           value="1"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="is_commercial_no"
                           class="ml-3 block text-sm font-medium text-gray-700 mr-4">
                        No
                    </label>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="brand"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="model"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <select
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        wire:model="type"
                    >
                        <option></option>
                        @foreach(\App\Models\Type::get() as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="load_index"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                    <input type="text"
                           wire:model="speed_index"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                    <input type="text"
                           wire:model="dot"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                    <input type="number"
                           wire:model="amount"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <select
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        wire:model="photo"
                    >
                        <option value="1">-</option>
                        <option value="2">Si</option>
                        <option value="3">No</option>
                    </select>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100 text-center">

                </td>
            </tr>
            @foreach($tires as $tire)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(in_array($tire->id, $tires_selected))
                            <input type="checkbox" value="{{ $tire->id }}" wire:click="unselect({{ $tire->id }})"
                                   checked/>
                        @else
                            <input type="checkbox" value="{{ $tire->id }}" wire:click="select({{ $tire->id }})"/>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ \App\Enums\TireCategory::getDescription($tire->category) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->width }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->profile }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->diameter }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($tire->is_commercial)
                            <i class="bi bi-check-circle text-green-600"></i>
                        @else
                            <i class="bi bi-x-circle text-red-600"></i>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->brand }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->model }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($tire->millimeters != 0)
                            @if ($tire->millimeters_2 != 0)
                                {{ $tire->millimeters }} / {{ $tire->millimeters_2 }}
                            @else
                                {{ $tire->millimeters }}
                            @endif
                            ({{ $tire->calculateMillimeterPercentage() }}%)
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->type->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->load_index }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->speed_index }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $tire->dot }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $tire->amount }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm"
                        title="{{ $tire->price_mounted_and_shipped }} € (ivato)">
                        {{ round(($tire->price_mounted_and_shipped * 100) / 122, 2) }} €<br/>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <livewire:tire.table-images :tire="$tire" :key="time().'-im-'.$tire->id"/>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pr-4 pl-4">
            {{ $tires->links() }}
        </div>
    </div>
</div>
