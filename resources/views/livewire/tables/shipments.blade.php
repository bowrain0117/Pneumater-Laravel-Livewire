<div>
    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        @if($warning_confirmation)
            <div x-data="{ showWarningModal : true }" class="inline">
                <div x-show="showCityModal"
                     class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                     x-transition:enter="transition ease duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div x-show="showCityModal"
                         class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                         @click.away="showCityModal = false"
                         x-transition:enter="transition ease duration-100 transform"
                         x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease duration-100 transform"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                        <div>
                            <b>Attenzione!</b> Hai selezionato spedizione che devono essere confermate. Verificale prima
                            di procedere!
                        </div>
                        <div>
                            <button type="button"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                    wire:click="$set('select_all', false)">
                                {{ __('Chiudi') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    ({{ count($shipment_selected)  }})
                </th>
                <th wire:click="$set('order_by', 'id')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    #
                    @if($order_by == 'id')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'ddt_number')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        DDT
                        @if($order_by == 'ddt_number')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'name')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Nominativo
                        @if($order_by == 'name')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'phone')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Telefono
                        @if($order_by == 'phone')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'email')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        E-mail
                        @if($order_by == 'email')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                <th wire:click="$set('order_by', 'status')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Stato
                    @if($order_by == 'status')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'payment_type')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Tipologia di pagamento
                        @if($order_by == 'payment_type')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                <th wire:click="$set('order_by', 'estimated_departure')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Prevista spedizione
                    @if($order_by == 'estimated_departure')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'note')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Note
                    @if($order_by == 'note')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'price')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                        Prezzo
                    @else
                        Prezzo netto
                    @endif
                    @if($order_by == 'price')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'deposit')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Acconto
                        @if($order_by == 'deposit')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'packages')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Colli
                        @if($order_by == 'packages')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                <th wire:click="$set('order_by', 'courier')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Corriere
                    @if($order_by == 'courier')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Special flags') }}
                </th>
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'created_by')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Creata da
                        @if($order_by == 'created_by')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <th wire:click="$set('order_by', 'source')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Sorgente
                        @if($order_by == 'source')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                <th wire:click="$set('order_by', 'created_at')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Data inserimento
                    @if($order_by == 'created_at')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100 text-center">
                    @can('print', \App\Models\Shipment::class)
                        @if(auth()->user()->isNotA('customer'))
                            <a href="{{ route('shipments.ddt', ['shipments' => $shipment_selected]) }}" target="_blank">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    {{ __('DDT') }}
                                </button>
                            </a>
                        @elseif(auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                            <a href="{{ route('shipments.invoice', ['shipments' => $shipment_selected]) }}"
                               target="_blank">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    {{ __('Invoice') }}
                                </button>
                            </a>
                        @endif
                    @endcan
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100 text-center">
                    <input type="checkbox" wire:model="select_all" value="1"/><br/>
                    @if($some_shipments_need_confirmation)
                        <button
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded mt-2"
                            wire:click="confirmAll">
                            <i class="bi bi-journal-check"></i>
                        </button>
                    @endif
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="identifier"
                           wire:keydown.enter="storeIdentifier"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                    @foreach($storedIdentifiers as $storedIdentifier)
                        <span wire:click="removeIdentifier({{ $storedIdentifier }})"
                              class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $storedIdentifier }}</span>
                    @endforeach
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="ddt_number"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                </td>
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="name"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </td>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="phone"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </td>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="email"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <select
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        wire:model="status"
                    >
                        <option></option>
                        @foreach(\App\Enums\ShipmentStatus::getValues() as $status_key)
                            <option
                                value="{{ $status_key }}">{{ \App\Enums\ShipmentStatus::getDescription($status_key) }}</option>
                        @endforeach
                    </select>
                </td>
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="date"
                           wire:model="estimated_departure_from"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <input type="date"
                           wire:model="estimated_departure_to"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                @endif
                @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="source"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="date"
                           wire:model="created_at_from"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <input type="date"
                           wire:model="created_at_to"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
            </tr>
            @foreach($shipments as $shipment)
                <livewire:tables.shipment-row :shipment="$shipment" :key="$shipment->id"/>
            @endforeach
        </table>

        <div class="pr-4 pl-4">
            {{ $shipments->links() }}
        </div>
    </div>
</div>
