<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">
        Spedizioni
    </h3>

    @can('create', \App\Models\Shipment::class)
        <a href="{{ route('shipments.create') }}">
            <button
                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded">
                <i class="bi bi-plus-circle-fill"></i>
            </button>
        </a>
    @endcan
    @can('print', \App\Models\Shipment::class)
        @if(auth()->user()->isNotA('customer'))
            <a href="{{ route('shipments.print', ['type' => \App\Enums\Shipment\PrintType::INTERNAL_SHIPMENT]) }}">
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mb-2"
                    title="Stampa">
                    <i class="bi bi-truck"></i> Interne
                    (
                    {{ \App\Models\Shipment::where('status', \App\Enums\ShipmentStatus::Confirmed)->where('courier', \App\Enums\Couriers::PUA)->where('estimated_departure', \Carbon\Carbon::today())->count() }}
                    )
                </button>
            </a>
            <a href="{{ route('shipments.print', ['type' => \App\Enums\Shipment\PrintType::EXTERNAL_SHIPMENT]) }}">
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mb-2"
                    title="Stampa">
                    <i class="bi bi-truck"></i> Esterne
                    (
                    {{ \App\Models\Shipment::where('status', \App\Enums\ShipmentStatus::Confirmed)->where('courier', '!=', \App\Enums\Couriers::PUA)->where('estimated_departure', \Carbon\Carbon::today())->count() }}
                    )
                </button>
            </a>
            <a href="{{ route('shipments.reprint', ['type' => \App\Enums\Shipment\PrintType::INTERNAL_SHIPMENT]) }}">
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mb-2"
                    title="Ristampa">
                    <i class="bi bi-truck"></i>
                    <i class="bi bi-arrow-clockwise"></i> Interne
                </button>
            </a>
            <a href="{{ route('shipments.reprint', ['type' => \App\Enums\Shipment\PrintType::EXTERNAL_SHIPMENT]) }}">
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mb-2"
                    title="Ristampa">
                    <i class="bi bi-truck"></i>
                    <i class="bi bi-arrow-clockwise"></i> Esterne
                </button>
            </a>

            <a href="{{ route('shipments.import-easyfatt') }}">
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mb-2"
                    title="Ristampa">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i> DDT
                </button>
            </a>
        @endif
    @endcan

    <a href="{{ route('brt.report') }}">
        <button
            class="@if(\App\Models\Shipment::where('estimated_departure', \Carbon\Carbon::today())->has('brtParcels')->count() > 0) bg-green-500 hover:bg-green-700 border-green-700 @else bg-indigo-500 hover:bg-indigo-700 border-indigo-700 @endif text-white font-bold py-2 px-4 border rounded mb-2"
            title="{{ __("BRT report") }}">
            <i class="bi bi-file-earmark-arrow-up-fill"></i> BRT Borderò ({{ \App\Models\Shipment::where('estimated_departure', \Carbon\Carbon::today())->has('brtParcels')->count() }})
        </button>
    </a>

    <a href="{{ route('brt.labels') }}">
        <button
            class="@if(\App\Models\Shipment::where('estimated_departure', \Carbon\Carbon::today())->has('brtParcels')->count() > 0) bg-green-500 hover:bg-green-700 border-green-700 @else bg-indigo-500 hover:bg-indigo-700 border-indigo-700 @endif text-white font-bold py-2 px-4 border rounded mb-2"
            title="{{ __("BRT labels") }}">
            <i class="bi bi-file-earmark-arrow-up-fill"></i> {{ __("BRT labels") }} ({{ \App\Models\BrtParcel::whereIn('shipment_id', \App\Models\Shipment::where('estimated_departure', \Carbon\Carbon::today())->has('brtParcels')->pluck('id'))->count() }})
        </button>
    </a>

    <span x-data="{ showModalShip : false }">
        <!-- Button -->
        <button
            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded"
            @click="showModalShip = !showModalShip">
            <i class="bi bi-truck"></i> {{ __('Send to BRT') }}
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
                <span class="font-bold block text-2xl mb-3">Spedizioni giornaliere</span>
                <p>Sei sicuro di voler inviare tutte le spedizioni giornaliere?</p>

                <!-- Buttons -->
                <div class="text-right space-x-5 mt-5">
                    <button @click="showModalShip = !showModalShip" type="button"
                            class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                        {{ __('Cancel') }}
                    </button>
                    <a href="{{ route('brt.ship_daily') }}">
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                            {{ __('Ship') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </span>

    <livewire:tables.shipments/>
</x-app-layout>
