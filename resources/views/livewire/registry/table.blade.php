<div>
    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
            <tr>
                <th wire:click="$set('order_by', 'code')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Code') }}
                    @if($order_by == 'code')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'denomination')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Denomination') }}
                    @if($order_by == 'denomination')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'phone')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Phone') }}
                    @if($order_by == 'phone')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'email')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Email') }}
                    @if($order_by == 'rack_identifier')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'fiscal_code')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Fiscal code') }}
                    @if($order_by == 'fiscal_code')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'vat_number')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('VAT number') }}
                    @if($order_by == 'vat_number')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'address')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Address') }}
                    @if($order_by == 'address')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'city')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('City') }}
                    @if($order_by == 'city')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'postal_code')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Postal code') }}
                    @if($order_by == 'postal_code')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'province')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Province') }}
                    @if($order_by == 'province')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'region')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Region') }}
                    @if($order_by == 'region')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'nation')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Nation') }}
                    @if($order_by == 'nation')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Last operation') }}
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Different shipping data') }}?
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="code"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="denomination"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="phone"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="email"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="fiscal_code"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="vat_number"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="address"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="city"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="postal_code"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="province"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="region"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="nation"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100"></td>
            </tr>
            @foreach($registries as $registry)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($registry->type == \App\Enums\RegistryType::COMPANY)
                            {{ $registry->denomination }}
                        @else
                            {{ $registry->name }} {{ $registry->surname }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->phone }}
                        @if($registry->phone && $registry->cellular)
                            <br />
                        @endif
                        {{ $registry->cellular }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->fiscal_code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->vat_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->address }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->city }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->postal_code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->province }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->region }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $registry->nation }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($registry->last_operation != null && get_class($registry->last_operation) == "App\Models\Shipment")
                            {{ __('Shipment') }}
                        @elseif($registry->last_operation != null && get_class($registry->last_operation) == "App\Models\Reservation")
                            {{ __('Reservation') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <livewire:registry.modal.alternative-shipment-data :registry="$registry" :key="time().'-im-rg-'.$registry->id"/>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <a href="{{ route('registries.edit', ['registry' => $registry]) }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </a>
                        <div x-data="{ showDeleteModal : false }" class="inline">
                            <!-- Button -->
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="showDeleteModal = !showDeleteModal">
                                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Modal Background -->
                            <div x-show="showDeleteModal" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <!-- Modal -->
                                <div x-show="showDeleteModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showDuplicates = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                    <span class="font-bold block text-2xl mb-3">Eliminazione "{{ $registry->denomination }}"</span>
                                    <p>Sei sicuro di voler eliminare l'anagrafica "{{ $registry->denomination }}"? L'operazione è irreversibile</p>

                                    <!-- Buttons -->
                                    <div class="text-right space-x-5 mt-5">
                                        <form action="{{ route('registries.destroy', ['registry' => $registry]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button @click="showDeleteModal = !showDeleteModal" type="button" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                                Elimina
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pr-4 pl-4">
            {{ $registries->links() }}
        </div>
    </div>
</div>
