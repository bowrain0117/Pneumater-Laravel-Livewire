<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Spedizione - Modifica pneumatico</h3>

    <form action="{{ route('shipments.tire.update',['shipment' => $shipment, 'tire' => $tire]) }}" method="POST">
        <input name="_method" type="hidden" value="PUT">
        @csrf

        <div class="mt-4">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Pneumatico</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Selezione pneumatico.
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
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Pneumatico</label>
                                        <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" disabled value="#{{ $tire->id }} - {{ $tire->brand }} {{ $tire->model }}" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="amount"
                                               class="block text-sm font-medium text-gray-700">Quantità</label>
                                        <input type="number" id="amount" name="amount" step="1" min="1" value="{{ $tire->amount }}" disabled
                                               class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price_override"
                                               class="block text-sm font-medium text-gray-700">{{ __('Price override') }}</label>
                                        <input type="number" id="price_override" name="price_override" step="0.01" value="{{ $pivot->price_override }}"
                                               class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                @if(request()->has('redirectToBill'))
                                    <input type="hidden" name="redirectToBill" value="1">
                                @endif
                                @if(request()->has('redirectToBill'))
                                    <a href="{{ route('shipments.bill', ['shipment' => $shipment]) }}">
                                        <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('shipments.edit', ['shipment' => $shipment]) }}">
                                        <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @endif
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
