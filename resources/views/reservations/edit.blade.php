@php
    use App\Enums\ReservationType;
@endphp

<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Prenotazione - Modifica</h3>

    <form action="{{ route('reservations.update', ['reservation' => $reservation ]) }}" method="POST">
        <input name="_method" type="hidden" value="PUT">
        <input type="hidden" name="id" value="{{ $reservation->id }}">
        @csrf

        <livewire:reservation.form :reservation="$reservation"/>
    </form>
    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Pneumatici</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Pneumatici collegati alla prenotazione.
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
                        <div class="bg-white overflow-auto">
                            <table class="w-full divide-y divide-gray-200 p-2">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        EAN
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Categoria
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Misura
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Carico - Velocità
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stagione
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descrizione
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Anno
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prezzo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ore necessarie
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Q.ta
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Posizione
                                    </th>
                                    <th scope="col" class="relative px-6 py-3 text-right">
                                        <a href="{{ route('reservations.tire.create', ['reservation' => $reservation]) }}" class="text-indigo-600 hover:text-indigo-900">Aggiungi</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reservation->tires as $tire)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tire->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tire->ean }}
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($tire->pivot->price_override)
                                                    {{ $tire->pivot->price_override }} €
                                                @else
                                                    {{ $tire->price }} €
                                                @endif
                                                @if($tire->pfu_contribution != 0)
                                                    <br/>
                                                    (PFU: {{ $tire->pfu_contribution }} €)
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @switch($tire->calculateLabourTimeSlot())
                                                    @case(0)
                                                        0m
                                                        @break
                                                    @case(1)
                                                        30m
                                                        @break
                                                    @case(2)
                                                        1h
                                                        @break
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tire->amount }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tire->rack_identifier }}  {{ $tire->rack_position }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('reservations.tire.edit', ['reservation' => $reservation, 'tire' => $tire]) }}">
                                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal : false }">
                                                    <!-- Button -->
                                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="showModal = !showModal">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal" class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione pneumatici</span>
                                                            <p>Sei sicuro di voler eliminare gli pneumatici? L'operazione è irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form action="{{ route('reservations.tire.destroy', ['reservation' => $reservation, 'tire' => $tire]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal" type="button" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Prodotti</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Prodotti aggiuntivi alla prenotazione.
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
                        <div class="bg-white overflow-auto">
                            <table class="w-full divide-y divide-gray-200 p-2">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            EAN
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descrizione
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tipologia
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Prezzo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Q.ta
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Posizione
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-right">
                                            <a href="{{ action('\App\Http\Controllers\ProductController@create',['reservation' => $reservation->id]) }}" class="text-indigo-600 hover:text-indigo-900">Aggiungi</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reservation->products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $product->code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $product->description }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \App\Enums\ProductType::getDescription($product->type) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $product->price }} €
                                                @if($product->pfu_contribution != 0)
                                                    <br/>
                                                    (PFU: {{ $product->pfu_contribution }} €)
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->amount }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->rack_identifier }}  {{ $product->rack_position }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ action('\App\Http\Controllers\ProductController@edit',['product' => $product->id]) }}">
                                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" type="button">
                                                        <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal : false }">
                                                    <!-- Button -->
                                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded mt-1" @click="showModal = !showModal">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal" class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione prodotto</span>
                                                            <p>Sei sicuro di voler eliminare il prodotto? L'operazione è irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form action="{{ route('products.destroy', ['product' => $product]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal" type="button" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Servizi</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Servizi aggiuntivi alla prenotazione.
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
                        <div class="bg-white overflow-auto">
                            <table class="w-full divide-y divide-gray-200 p-2">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Codice
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nome
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Prezzo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ore necessarie
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Q.ta
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-right">
                                            <a href=" {{ route('reservations.service.create', ['reservation' => $reservation]) }}" class="text-indigo-600 hover:text-indigo-900">Aggiungi</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reservation->services as $service)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $service->code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $service->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($service->pivot->price_override)
                                                    {{ $service->pivot->price_override }} €
                                                @else
                                                    {{ $service->price }} €
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @switch($service->amount_of_time_slot)
                                                    @case(0)
                                                        0m
                                                        @break
                                                    @case(1)
                                                        30m
                                                        @break
                                                    @case(2)
                                                        1h
                                                        @break
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $service->pivot->amount }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('reservations.service.edit', ['reservation' => $reservation, 'service' => $service]) }}">
                                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal : false }">
                                                    <!-- Button -->
                                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="showModal = !showModal">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal" class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione servizio</span>
                                                            <p>Sei sicuro di voler eliminare il servizio? L'operazione è irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form action="{{ route('reservations.service.destroy', ['reservation' => $reservation, 'service' => $service]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal" type="button" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
