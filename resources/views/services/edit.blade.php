<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Servizio - Modifica</h3>

    <form action="{{ route('services.update',['service' => $service ]) }}" method="POST">
        <input name="_method" type="hidden" value="PUT">
        <input type="hidden" name="id" value="{{ $service->id }}">
        @csrf

        <div class="mt-4">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Servizio</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Dettagli servizio corrente.
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
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                        <input
                                            type="text"
                                            name="name" id="name"
                                            value="{{ old('name', $service->name) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required
                                        >
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Codice</label>
                                        <input
                                            type="text"
                                            name="code" id="code"
                                            value="{{ old('code', $service->code) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        >
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Ore necessarie</label>
                                        <select name="amount_of_time_slot" id="amount_of_time_slot" class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="0" {{ $service->amount_of_time_slot == 0 ? 'selected' : '' }}>0m</option>
                                            <option value="1" {{ $service->amount_of_time_slot == 1 ? 'selected' : '' }}>30m</option>
                                            <option value="2" {{ $service->amount_of_time_slot == 2 ? 'selected' : '' }}>1h</option>
                                        </select>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Prezzo</label>
                                        <input type="number" min=0 step=0.01 value="{{ old('price', $service->price) }}" name="price" id="price"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Descrizione</label>
                                        <textarea
                                            name="description" id="description"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        >{{ old('descriprion',$service->description) }}</textarea>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3"></div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <a href="{{ route('services.index') }}">
                                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Annulla
                                    </button>
                                </a>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
