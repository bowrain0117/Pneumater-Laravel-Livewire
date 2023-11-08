<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Prodotto - Modifica</h3>

    <form action="{{ route('products.update', ['product' => $product]) }}" method="POST">
        <input name="_method" type="hidden" value="PUT">
        <input type="hidden" name="id" value="{{ $product->id }}">
        @csrf

        <div class="mt-4">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Prodotto</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Dettagli prodotto corrente.
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
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700">Descrizione</label>
                                        <input type="text" name="description" id="description"
                                            value="{{ old('description', $product->description) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700">EAN</label>
                                        <input type="text" name="code" id="code"
                                            value="{{ old('code', $product->code) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price"
                                            class="block text-sm font-medium text-gray-700">Prezzo</label>
                                        <input type="number" min=0 step=0.01
                                            value="{{ old('price', $product->price) }}" name="price" id="price"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="pfu_contribution"
                                            class="block text-sm font-medium text-gray-700">PFU</label>
                                        <select id="pfu_contribution" name="pfu_contribution"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option @if (old('price', $product->pfu_contribution) == 0) selected @endif value="0">-
                                            </option>
                                            <option @if (old('price', $product->pfu_contribution) == 2.464) selected @endif value="2.464">
                                                Estero 2,464 (2,02 netto)</option>
                                            <option @if (old('price', $product->pfu_contribution) == 3.172) selected @endif value="3.172">
                                                Italiano 3,172 (2,60 netto)</option>
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="type"
                                            class="block text-sm font-medium text-gray-700">Tipologia</label>
                                        <select name="type" id="type"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @foreach (\App\Enums\ProductType::getValues() as $type_id)
                                                <option value="{{ $type_id }}"
                                                    {{ old('type', $product->type) == $type_id ? 'selected' : '' }}>
                                                    {{ \App\Enums\ProductType::getDescription($type_id) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="amount"
                                            class="block text-sm font-medium text-gray-700">Quantità</label>
                                        <input type="number" id="amount" name="amount" step="1"
                                            min="0" value="{{ old('amount', $product->amount) }}"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>

                                    <div class="col-span-6 sm:col-span-1">
                                        <label for="rack_identifier"
                                            class="block text-sm font-medium text-gray-700">Scaffale</label>
                                        <input type="text" name="rack_identifier" id="rack_identifier"
                                            value="{{ old('rack_identifier', $product->rack_identifier) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-1">
                                        <label for="rack_position"
                                            class="block text-sm font-medium text-gray-700">Posizione</label>
                                        <input type="number" name="rack_position" id="rack_position"
                                            value="{{ old('rack_position', $product->rack_position) }}" min=1 step=1
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-1">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                @if (request()->has('redirectToBill'))
                                    <input type="hidden" name="redirectToBill" value="1">
                                @endif
                                @if ($product->reservation_id && !request()->input('redirectToBill'))
                                    <a
                                        href="{{ route('reservations.edit', ['reservation' => $product->reservation_id]) }}">
                                        <button type="button"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @elseif($product->reservation_id && request()->input('redirectToBill'))
                                    <a
                                        href="{{ route('reservations.bill', ['reservation' => $product->reservation_id]) }}">
                                        <button type="button"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @endif
                                @if ($product->shipment_id && !request()->input('redirectToBill'))
                                    <a href="{{ route('shipments.edit', ['shipment' => $product->shipment_id]) }}">
                                        <button type="button"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @elseif($product->shipment_id && request()->input('redirectToBill'))
                                    <a href="{{ route('shipments.bill', ['shipment' => $product->shipment_id]) }}">
                                        <button type="button"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @endif
                                <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Salva
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
