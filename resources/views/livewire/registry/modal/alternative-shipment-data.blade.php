<div>
    @if($registry->is_shipment_on_different_location)
        <!-- Button -->
        <div x-data="{ showShipmentData : false }" class="inline">
            <!-- Button -->
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded" @click="showShipmentData = !showShipmentData">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </button>

            <!-- Modal Background -->
            <div x-show="showShipmentData" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <!-- Modal -->
                <div x-show="showShipmentData" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showShipmentData = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                    <span class="font-bold block text-2xl mb-3">{{ __('Registry shipment data') }}</span>
                    <p class="text-center text-lg">
                        <b>{{ __('Denomination') }}</b>: {{ $registry->denomination_shipment }} <br />
                        <b>{{ __('Address') }}</b>: {{ $registry->address_shipment }} <br />
                        <b>{{ __('Postal code') }}</b>: {{ $registry->postal_code_shipment }} <br />
                        <b>{{ __('City') }}</b>: {{ $registry->city_shipment }} <br />
                        <b>{{ __('Province') }}</b>: {{ $registry->province_shipment }} <br />
                        <b>{{ __('Region') }}</b>: {{ $registry->region_shipment }} <br />
                        <b>{{ __('Nation') }}</b>: {{ $registry->nation_shipment }} <br />
                    </p>

                    <!-- Buttons -->
                    <div class="text-right space-x-5 mt-5">
                        <button
                            @click="showShipmentData = !showShipmentData" type="button"
                            class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" disabled>
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
   @endif
</div>
