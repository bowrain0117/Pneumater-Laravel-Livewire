<x-app-layout>
    @if ($reservation->services()->where('code', 'CONV')->where('reservation_service.price_override', 0)->count() > 0)
        <div x-data="{ showModal: true }">
            <!-- Modal Background -->
            <div x-show="showModal"
                class="text-center fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
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
                    <span class="font-bold block text-2xl mb-3">{{ __('Warning') }}!
                        {{ __('Convergence without price') }}!</span>
                    <p>{{ __('On this reservation there is a convergence added without price. Please check it before proceeding') }}
                        .</p>
                </div>
            </div>
        </div>
    @endif

    <h3 class="text-gray-700 text-3xl font-medium">Prenotazione - {{ __('Bill') }}</h3>

    <div class="mt-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Cliente</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Cliente prenotazione corrente.
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
                    @if ($reservation->registry != null)
                        <input type="hidden" name="registry_id" value="{{ $reservation->registry->id }}">
                        <table class="w-full divide-y divide-gray-200 text-left p-2">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Code') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Denomination') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Fiscal code') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('VAT number') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Phone') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('E-mail') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $reservation->registry->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($reservation->registry->type == \App\Enums\RegistryType::COMPANY)
                                            {{ $reservation->registry->denomination }}
                                        @else
                                            {{ $reservation->registry->name }} {{ $reservation->registry->surname }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $reservation->registry->fiscal_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $reservation->registry->vat_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $reservation->registry->phone }}
                                        @if ($reservation->registry->phone && $reservation->registry->cellular)
                                            <br />
                                        @endif
                                        {{ $reservation->registry->cellular }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $reservation->registry->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <a
                                            href="{{ route('registries.edit', ['registry' => $reservation->registry, 'redirectToReservationBill' => $reservation->id]) }}">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <b>{{ __('Missing customer data') }}</b>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
                            <table class="min-w-full divide-y divide-gray-200">
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
                                            Prezzo
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ore necessarie
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Q.ta
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Posizione
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-right">
                                            <a href="{{ route('reservations.tire.create', ['reservation' => $reservation, 'redirectToBill' => true]) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Aggiungi</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reservation->tires as $tire)
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
                                                {{ $tire->width . ($tire->profile != 0 ? ' ' . $tire->profile : '') . ' ' . $tire->diameter . ($tire->is_commercial == 1 ? 'C' : '') }}
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
                                                @if ($tire->pivot->price_override)
                                                    {{ $tire->pivot->price_override }} €
                                                @else
                                                    {{ $tire->price }} €
                                                @endif
                                                @if ($tire->pfu_contribution != 0)
                                                    <br />
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
                                                {{ $tire->rack_identifier }} {{ $tire->rack_position }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a
                                                    href="{{ route('reservations.tire.edit', ['reservation' => $reservation, 'tire' => $tire, 'redirectToBill' => true]) }}">
                                                    <button
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal: false }">
                                                    <!-- Button -->
                                                    <button
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                                        @click="showModal = !showModal">
                                                        <svg class="fill-current w-4 h-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal"
                                                        class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                        x-transition:enter="transition ease duration-300"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease duration-300"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal"
                                                            class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                            @click.away="showModal = false"
                                                            x-transition:enter="transition ease duration-100 transform"
                                                            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave="transition ease duration-100 transform"
                                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione
                                                                pneumatici</span>
                                                            <p>Sei sicuro di voler eliminare gli pneumatici?
                                                                L'operazione è
                                                                irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form
                                                                    action="{{ route('reservations.tire.destroy', ['reservation' => $reservation, 'tire' => $tire, 'redirectToBill' => true]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal"
                                                                        type="button"
                                                                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                                                        Cancel
                                                                    </button>
                                                                    <button
                                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
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
                        <div class="bg-white">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            EAN
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descrizione
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tipologia
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Prezzo
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Q.ta
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Posizione
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-right">
                                            <a href="{{ action('\App\Http\Controllers\ProductController@create', ['reservation' => $reservation->id, 'redirectToBill' => true]) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Aggiungi</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reservation->products as $product)
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
                                                @if ($product->pfu_contribution != 0)
                                                    <br />
                                                    (PFU: {{ $product->pfu_contribution }} €)
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->amount }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->rack_identifier }} {{ $product->rack_position }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a
                                                    href="{{ action('\App\Http\Controllers\ProductController@edit', ['product' => $product->id, 'redirectToBill' => true]) }}">
                                                    <button
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                                        type="button">
                                                        <svg class="fill-current w-4 h-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal: false }">
                                                    <!-- Button -->
                                                    <button
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded mt-1"
                                                        @click="showModal = !showModal">
                                                        <svg class="fill-current w-4 h-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal"
                                                        class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                        x-transition:enter="transition ease duration-300"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease duration-300"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal"
                                                            class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                            @click.away="showModal = false"
                                                            x-transition:enter="transition ease duration-100 transform"
                                                            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave="transition ease duration-100 transform"
                                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione
                                                                prodotto</span>
                                                            <p>Sei sicuro di voler eliminare il prodotto? L'operazione è
                                                                irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form
                                                                    action="{{ route('products.destroy', ['product' => $product, 'redirectToBill' => true]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal"
                                                                        type="button"
                                                                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                                                        Cancel
                                                                    </button>
                                                                    <button
                                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
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
                        <div class="bg-white">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Codice
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nome
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Prezzo
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ore necessarie
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Q.ta
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-right">
                                            <a href=" {{ route('reservations.service.create', ['reservation' => $reservation, 'redirectToBill' => true]) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Aggiungi</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reservation->services as $service)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $service->code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $service->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($service->pivot->price_override)
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
                                                <a
                                                    href="{{ route('reservations.service.edit', ['reservation' => $reservation, 'service' => $service, 'redirectToBill' => true]) }}">
                                                    <button
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal: false }">
                                                    <!-- Button -->
                                                    <button
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                                        @click="showModal = !showModal">
                                                        <svg class="fill-current w-4 h-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal"
                                                        class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                        x-transition:enter="transition ease duration-300"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease duration-300"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal"
                                                            class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                            @click.away="showModal = false"
                                                            x-transition:enter="transition ease duration-100 transform"
                                                            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave="transition ease duration-100 transform"
                                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione
                                                                servizio</span>
                                                            <p>Sei sicuro di voler eliminare il servizio? L'operazione è
                                                                irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form
                                                                    action="{{ route('reservations.service.destroy', ['reservation' => $reservation, 'service' => $service, 'redirectToBill' => true]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal"
                                                                        type="button"
                                                                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                                                        Cancel
                                                                    </button>
                                                                    <button
                                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
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
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Deposito</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Depositi aggiuntivi alla prenotazione.
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
                        <div class="bg-white">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Car Model
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Plate
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Note
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            State
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-right">
                                            <a href=" {{ route('reservations.deposit.create', ['reservation' => $reservation, 'redirectToBill' => true]) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Add</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reservation->deposits as $deposit)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $deposit->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $deposit->car_model }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $deposit->license_plate }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $deposit->note }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($deposit->status == 1)
                                                    Available
                                                @elseif ($deposit->status == 2)
                                                    Mounted
                                                @elseif ($deposit->status == 3)
                                                    Picked up
                                                @elseif ($deposit->status == 4)
                                                    Scraped
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a
                                                    href="{{ action('\App\Http\Controllers\DepositController@edit', ['deposit' => $deposit->id, 'reservation' => $reservation->id, 'redirectToBill' => true]) }}">
                                                    <button
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal: false }">
                                                    <!-- Button -->
                                                    <button
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                                        @click="showModal = !showModal">
                                                        <svg class="fill-current w-4 h-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal"
                                                        class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                        x-transition:enter="transition ease duration-300"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease duration-300"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal"
                                                            class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                            @click.away="showModal = false"
                                                            x-transition:enter="transition ease duration-100 transform"
                                                            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave="transition ease duration-100 transform"
                                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione
                                                                deposito</span>
                                                            <p>Sei sicuro di voler eliminare il depositio? L'operazione
                                                                è
                                                                irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form
                                                                    action="{{ route('reservations.deposit.destroy', ['reservation' => $reservation, 'deposit' => $deposit, 'redirectToBill' => true]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal"
                                                                        type="button"
                                                                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                                                        Cancel
                                                                    </button>
                                                                    <button
                                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
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
    <livewire:reservation.bill-form :reservation="$reservation" />
</x-app-layout>
