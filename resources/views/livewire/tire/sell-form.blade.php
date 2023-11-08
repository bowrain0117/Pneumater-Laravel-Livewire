@php
    use App\Enums\ReservationType;
    use App\Enums\PaymentType;
@endphp

<div>
    {{ $amount_of_time_slot }}
    @if($tire_sell_warning)
        <div role="alert" class="mh-4">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Pneumatico già venuto
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <p>Attenzione! Hai selezionato uno pneumatico che è già stato venduto su ebay. Per favore controlla
                    prima di procedere.</p>
            </div>
        </div>
    @else
        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Tipologia vendita</h3>
                        <p class="mt-1 text-sm text-gray-600">

                        </p>
                        @if ($errors->any())
                            <div class="mt-2a">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <label for="sellType" class="block text-sm font-medium text-gray-700">Tipologia</label>
                            <select wire:model="sellType" name="sellType"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @if(auth()->user()->isNotA('customer'))
                                    <option value="1">Vendita diretta</option>
                                    <option value="2">Prenotazione</option>
                                @endif
                                <option value="3">Spedizione</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($sellType == 2)
            @if($registry)
                <livewire:registry.picker :registry="$registry"/>
            @else
                <livewire:registry.picker/>
            @endif

            <div class="mt-4">
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Prentazione</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Dettagli prenotazione corrente.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-6">
                                            <fieldset>
                                                <div>
                                                    <legend class="text-base font-medium text-gray-900">Tipologia
                                                    </legend>
                                                </div>
                                                <div class="grid grid-cols-3 gap-2 mt-2">
                                                    @foreach(\App\Enums\ReservationType::getValues() as $key => $type_id)
                                                        <div class="col-span-1 flex">
                                                            <input
                                                                type="radio"
                                                                name="type"
                                                                value="{{ $type_id }}"
                                                                wire:model="type"
                                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                            >
                                                            <label for="status"
                                                                   class="ml-3 block text-sm font-medium text-gray-700">
                                                                {{ \App\Enums\ReservationType::getDescription($type_id) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="appointment" class="block text-sm font-medium text-gray-700">Appuntamento</label>
                                            <livewire:reservation.time-slots :lift_id="$lift_id"
                                                                             :appointment_date="$appointment_date"
                                                                             :appointment_time="$appointment_time"
                                                                             :amount_of_time_slot="$amount_of_time_slot"/>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="source"
                                                   class="block text-sm font-medium text-gray-700">Sorgente</label>
                                            <input type="text" name="source" id="source" wire:model="source"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="col-span-6 sm:col-span-6">
                                            <label for="note"
                                                   class="block text-sm font-medium text-gray-700">Note</label>
                                            <input type="text" name="note" id="note" wire:model="note"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <input type="hidden" value=0 name="price" id="price">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="deposit"
                                                   class="block text-sm font-medium text-gray-700">Acconto</label>
                                            <input type="number" min="0" step="0.01" name="deposit" id="deposit"
                                                   wire:model="deposit"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3 flex items-center">
                                            <input name="redirecToEdit" value="1" type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            <div class="ml-3 text-sm">
                                                <label for="redirecToEdit" class="font-medium text-gray-700">Aggiungi
                                                    prodotti o servizi</label>
                                            </div>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3 flex items-center">
                                            <input name="redirecToPrint" value="1" type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            <div class="ml-3 text-sm">
                                                <label for="redirecToPrint" class="font-medium text-gray-700">Stampa
                                                    direttamente</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($sellType == 3)
            @if($registry)
                <livewire:registry.picker :registry="$registry" :shipment_mode="true"/>
            @else
                <livewire:registry.picker :shipment_mode="true"/>
            @endif

            <div class="mt-4">
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Shipment') }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Current shipment details') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="appointment_not_defined"
                                                   class="block text-sm font-medium text-gray-700">Data di
                                                partenza</label>
                                            <livewire:component.nullable-date :name="'estimated_departure'"
                                                                              :value="$estimated_departure"/>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="payment_type"
                                                   class="block text-sm font-medium text-gray-700">{{ __('Payment type') }}</label>
                                            <select name="payment_type" wire:model="payment_type"
                                                    class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <option value="">-</option>
                                                @foreach(\App\Enums\PaymentType::getShipmentInstances() as $paymentType)
                                                    <option
                                                        value="{{ $paymentType->value }}">{{ $paymentType->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="note"
                                                   class="block text-sm font-medium text-gray-700">Note</label>
                                            <input type="text" name="note" wire:model="note"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="source"
                                                   class="block text-sm font-medium text-gray-700">Sorgente</label>
                                            <input type="text" name="source" wire:model="source"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <input type="hidden" name="price" wire:model="price">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="courier"
                                                   class="block text-sm font-medium text-gray-700">Corriere</label>
                                            <select name="courier" id="courier" wire:model="courier"
                                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            >
                                                @foreach(\App\Enums\Couriers::getInstances() as $courier)
                                                    <option
                                                        value="{{ $courier->value }}">{{ $courier->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="deposit"
                                                   class="block text-sm font-medium text-gray-700">Acconto</label>
                                            <input type="number" min="0" step="0.01" name="deposit" wire:model="deposit"
                                                   value="{{ old('deposit') }}"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-2 flex items-center">
                                            <input name="contextual_pickup" value="1" wire:model="contextual_pickup"
                                                   type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            <div class="ml-3 text-sm">
                                                <label for="contextual_pickup"
                                                       class="font-medium text-gray-700">{{ __('Contextual pickup') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-span-6 sm:col-span-2 flex items-center">
                                            <input name="stationary_storage" value="1" wire:model="stationary_storage"
                                                   type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            <div class="ml-3 text-sm">
                                                <label for="stationary_storage"
                                                       class="font-medium text-gray-700">{{ __('Stationary storage') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-span-6 sm:col-span-2 flex items-center">
                                            <input name="to_invoice" value="1" wire:model="to_invoice" type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            <div class="ml-3 text-sm">
                                                <label for="to_invoice"
                                                       class="font-medium text-gray-700">{{ __('To invoice') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3 flex items-center">
                                            <input name="redirecToEdit" value="1" type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            <div class="ml-3 text-sm">
                                                <label for="redirecToEdit" class="font-medium text-gray-700">Aggiungi
                                                    prodotti o servizi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="text-right mt-5">
            @if($sellType == 3 && $payment_type === null)
                <div x-data="{ showWarning : false }" class="inline">
                    <button type="button"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                            @click="showWarning = !showWarning">
                        {{ __('Save') }}
                    </button>

                    <div x-show="showWarning"
                         class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                         x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div x-show="showWarning" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                             @click.away="showWarning = false"
                             x-transition:enter="transition ease duration-100 transform"
                             x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease duration-100 transform"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                            <div class="text-black text-center text-xl mb-2">
                                {{ __('Payment method not inserted. Are you sure you want to save?') }}
                            </div>
                            <div class="px-4 py-3 bg-gray-50 sm:px-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 text-right">
                                        <button type="button" @click="showWarning = !showWarning"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            {{ __('Close') }}
                                        </button>
                                        <button type="submit"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <input type="submit" value="Conferma"
                       class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded">
            @endif
        </div>
    @endif

    <div class="mt-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Pneumatici selezionati</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Pneumatici correntemente selezionati.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow sm:rounded-md overflow-auto">
                    <table class="w-full divide-y divide-gray-200 text-left p-2">
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
                                Venduto su eBay
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoria
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Misura
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Carico - Velocità
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stagione
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descrizione
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Anno
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Posizione
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantità
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prezzo spedite e montate
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tires as $tire)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tire->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tire->ean }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($tire_sell_status[$tire->id])
                                        <i class="bi bi-check-circle" style="color: green"></i>
                                    @else
                                        <i class="bi bi-x-circle" style="color: red"></i>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \App\Enums\TireCategory::getDescription($tire->category) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tire->width.(($tire->profile != 0 ) ? " ".$tire->profile : "")." ".$tire->diameter . ($tire->is_commercial == 1  ? 'C' : '') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tire->load_index }} {{ $tire->speed_index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tire->type->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tire->brand }} {{ $tire->model }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tire->dot }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tire->rack_identifier }}  {{ $tire->rack_position }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input name="amounts[{{ $tire->id }}]" type="number"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                           min="1" max="{{ $tire->amount }}"
                                           value="{{ old('amounts.' . $tire->id, $tire->amount) }}" required/>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if(auth()->user()->lock_price_edit)
                                        <input type="hidden" name="prices[{{ $tire->id }}]"
                                               value="{{ $tire->category == \App\Enums\TireCategory::NEW ? $tire->getKijijiPrice() * $tire->amount : $tire->getKijijiPrice() }}"/>

                                        {{ $tire->category == \App\Enums\TireCategory::NEW ? $tire->getKijijiPrice() * $tire->amount : $tire->getKijijiPrice() }}
                                        €
                                    @else
                                        <input name="prices[{{ $tire->id }}]" type="number"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                               min="1" step="0.01"
                                               value="{{ old('prices.' . $tire->id, ($tire->category == \App\Enums\TireCategory::NEW) ? $tire->getKijijiPrice() * $tire->amount : $tire->getKijijiPrice()) }}"
                                               required/>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="hidden" name="tires[]" value="{{ $tire->id }}">
                                    <button wire:click="removeTire({{ $tire->id }})" type="button"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">
                                        <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
