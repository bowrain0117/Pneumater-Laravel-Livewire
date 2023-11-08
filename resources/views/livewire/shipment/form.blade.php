<div>
    @if($registry)
        <livewire:registry.picker :registry="$registry" :shipment_mode="true"
                                  :edit_redirect_field_name="'redirectToShipmentEdit'"
                                  :edit_redirect_field_value="$shipment->id"/>
    @else
        <livewire:registry.picker :shipment_mode="true"
                                  :edit_redirect_field_name="'redirectToShipmentEdit'"
                                  :edit_redirect_field_value="$shipment->id"/>
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
                                           class="block text-sm font-medium text-gray-700">Data di partenza</label>
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
                                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                                    <input type="text" name="note" wire:model="note"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="source" class="block text-sm font-medium text-gray-700">Sorgente</label>
                                    <input type="text" name="source" wire:model="source"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="courier"
                                           class="block text-sm font-medium text-gray-700">Corriere</label>
                                    <select name="courier" id="courier" wire:model="courier"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    >
                                        @foreach(\App\Enums\Couriers::getInstances() as $courier)
                                            <option value="{{ $courier->value }}">{{ $courier->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($shipment->id)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="tracking_code" class="block text-sm font-medium text-gray-700">Codice
                                            di tracciamento</label>
                                        <input type="text" name="tracking_code" id="tracking_code"
                                               wire:model="tracking_code"
                                               value="{{ old('tracking_code', $shipment->tracking_code) }}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                @endif
                                <div class="col-span-6 sm:col-span-3">
                                    @if($shipment->id)
                                        <label for="price" class="block text-sm font-medium text-gray-700">Prezzo
                                            concordato</label>
                                        <input type="number" min="0" step="0.01" wire:model="price" name="price"
                                               id="price"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @else
                                        <input type="hidden" name="price" wire:model="price">
                                    @endif
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="deposit" class="block text-sm font-medium text-gray-700">Acconto</label>
                                    <input type="number" min="0" step="0.01" value="{{ old('deposit',0) }}"
                                           name="deposit" wire:model="deposit" value="{{ old('deposit') }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                @if($shipment->id)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price"
                                               class="block text-sm font-medium text-gray-700">{{ __('Packages') }}</label>
                                        <input type="number" min="0" step="1" wire:model="packages" name="packages"
                                               id="packages"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                @else
                                    <input type="hidden" name="price" wire:model="packages">
                                @endif
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
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            @if($payment_type !== null)
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Salva
                                </button>
                            @else
                                <div x-data="{ showWarning : false }" class="inline">
                                    <button type="button"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                            @click="showWarning = !showWarning">
                                        {{ __('Save') }}
                                    </button>

                                    <div x-show="showWarning"
                                         class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                         x-transition:enter="transition ease duration-300"
                                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease duration-300"
                                         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                        <div x-show="showWarning"
                                             class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
