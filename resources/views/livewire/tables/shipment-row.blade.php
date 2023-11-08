<tr>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
        @if($edit_lock)
            <i class="bi bi-lock-fill" wire:click="alternateLockStatus"></i>
        @else
            <i class="bi bi-unlock-fill" wire:click="alternateLockStatus"></i>
        @endif
    </td>
    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 @if($shipment->is_confirmation_needed) bg-red-200 @elseif($shipment->ddt_number) bg-yellow-200 @endif">
        <input type="checkbox" wire:model="checked" value="1" @if($shipment->is_confirmation_needed) disabled @endif />
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $shipment->id }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if($shipment->ddt_number)
            {{ $shipment->ddt_number }}<br/>
            {{ $shipment->ddt_date ? $shipment->ddt_date->format('d/m/Y') : '' }}
        @else
            -
        @endif
    </td>
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            @if($shipment->registry && $shipment->registry->type == \App\Enums\RegistryType::PRIVATE)
                {{ $shipment->registry->name }} {{ $shipment->registry->surname }}
            @elseif($shipment->registry && $shipment->registry->type == \App\Enums\RegistryType::COMPANY)
                {{ $shipment->registry->denomination }}
            @else
                {{ $shipment->name }}
            @endif
        </td>
    @endif
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            @if($shipment->registry)
                {{ $shipment->registry->phone }}
                @if($shipment->registry->phone && $shipment->registry->cellular)
                    <br/>
                @endif
                {{ $shipment->registry->cellular }}
            @else
                {{ $shipment->phone }}
            @endif
        </td>
    @endif
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            @if($shipment->registry)
                {{ $shipment->registry->email }}
            @else
                {{ $shipment->email }}
            @endif
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ \App\Enums\ShipmentStatus::getDescription($shipment->status) }}
    </td>
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $shipment->payment_type !== null ? \App\Enums\PaymentType::getDescription($shipment->payment_type) : '-' }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'estimated_departure')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="date"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'estimated_departure')"
            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $shipment->estimated_departure ? $shipment->estimated_departure->format('d/m/Y') : '-' }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'note')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="text"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'note')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $shipment->note }}
        </td>
    @endif
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $shipment->price . ' €' }}
            @if($shipment->deposit > 0)
                <br/>(Rimanenti: {{ $shipment->price - $shipment->deposit }} €)
            @endif
        </td>
    @else
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" title="{{ $shipment->price }} € (ivato)">
            {{ round(($shipment->price * 100) / 122, 2) }} €<br/>
        </td>
    @endif
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        @if(!$edit_lock && $field_in_edit == 'deposit' && auth()->user()->isNotA('customer'))
            <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
                <input
                    type="number"
                    min="0"
                    wire:model="field_in_edit_value"
                    class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                />
            </td>
        @else
            <td wire:click="$set('field_in_edit', 'deposit')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $shipment->deposit . ' €' }}
            </td>
        @endif
    @endif
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $shipment->packages }}
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $shipment->courier ? \App\Enums\Couriers::getDescription($shipment->courier) : '' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if($shipment->contextual_pickup)
            {{ __('Contextual pickup') }}<br/>
        @endif
        @if($shipment->stationary_storage)
            {{ __('Stationary storage') }}<br/>
        @endif
        @if($shipment->to_invoice)
            {{ __('To invoice') }}
        @endif
    </td>
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $shipment->createdBy->name }}
        </td>
    @endif
    @if(auth()->user()->isNotA('customer') || auth()->user()->customer_type == \App\Enums\User\CustomerType::Dropshipping)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $shipment->source }}
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $shipment->created_at->format('d/m/Y') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <x-shipment.modal-info :shipment="$shipment"/>
        @if($shipment->is_confirmation_needed)
            <button
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded"
                wire:click="confirm">
                <i class="bi bi-journal-check"></i>
            </button>
        @endif
        @can('update', $shipment)
            <a href="{{ route('shipments.edit', ['shipment' => $shipment]) }}">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    <i class="bi bi-pencil-fill"></i>
                </button>
            </a>
        @endcan
        @can('print', $shipment)
            <a href="{{ route('shipments.bill', ['shipment' => $shipment]) }}">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                </button>
            </a>
        @endcan
        @if($shipment->brtParcels()->count() > 0)
            <a href="{{ route('shipments.track', ['shipment' => $shipment]) }}">
                <button
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                    <i class="bi bi-truck"></i>
                </button>
            </a>
        @else
            @if($shipment->estimated_departure == \Carbon\Carbon::today() && $shipment->status == \App\Enums\ShipmentStatus::PartiallyProcessed)
                <span x-data="{ showModalShip : false }">
                    <!-- Button -->
                    <button
                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 border border-yellow-700 rounded"
                        @click="showModalShip = !showModalShip">
                        <i class="bi bi-truck"></i>
                    </button>

                    <!-- Modal Background -->
                    <div x-show="showModalShip"
                         class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                         x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <!-- Modal -->
                        <div x-show="showModalShip" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                             @click.away="showModalShip = false" x-transition:enter="transition ease duration-100 transform"
                             x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease duration-100 transform"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                            <span class="font-bold block text-2xl mb-3">Spedizione #{{ $shipment->id }}</span>
                            <p>Sei sicuro di voler inviare la spedizione #{{ $shipment->id }}?</p>

                            <!-- Buttons -->
                            <div class="text-right space-x-5 mt-5">
                                <form action="{{ route('shipments.ship', ['shipment' => $shipment]) }}"
                                      method="POST">
                                    @csrf
                                    <button @click="showModalShip = !showModalShip" type="button"
                                            class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                        {{ __('Cancel') }}
                                    </button>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                        {{ __('Ship') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </span>
            @endif
        @endif
        @can('delete', $shipment)
            <span x-data="{ showModal : false }">
                <!-- Button -->
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                        @click="showModal = !showModal">
                    <i class="bi bi-trash-fill"></i>
                </button>

                <!-- Modal Background -->
                <div x-show="showModal"
                     class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                     x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <!-- Modal -->
                    <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                         @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                         x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease duration-100 transform"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                        <span class="font-bold block text-2xl mb-3">Eliminazione #{{ $shipment->id }}</span>
                        <p>Sei sicuro di voler eliminare la spedizione #{{ $shipment->id }}? L'operazione è
                            irreversibile</p>

                        <!-- Buttons -->
                        <div class="text-right space-x-5 mt-5">
                            <form action="{{ route('shipments.destroy', ['shipment' => $shipment->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button @click="showModal = !showModal" type="button"
                                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                    Cancel
                                </button>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                    Elimina
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </span>
        @endcan
    </td>
</tr>
