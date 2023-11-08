<div>
    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Caratteristiche</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Caratteristiche e proprietà dello pneumatico.
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
                                @if ($category == \App\Enums\TireCategory::NEW || $category == \App\Enums\TireCategory::NEW_AGED || $category == \App\Enums\TireCategory::NEW_EXTRA)
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="brand"
                                               class="block text-sm font-medium text-gray-700">Descrizione</label>
                                        <input type="text" name="description" id="description"
                                               value="{{ $description }}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                @endif
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="category"
                                           class="block text-sm font-medium text-gray-700">Categoria</label>
                                    <select id="category" name="category"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            wire:model="category"
                                    >
                                        @foreach(\App\Enums\TireCategory::getValues() as $value)
                                            <option
                                                value="{{ $value }}">{{ \App\Enums\TireCategory::getDescription($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($category == \App\Enums\TireCategory::NEW || $category == \App\Enums\TireCategory::NEW_AGED || $category == \App\Enums\TireCategory::NEW_EXTRA)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="brand" class="block text-sm font-medium text-gray-700">EAN</label>
                                        <input type="text" name="ean" id="ean"
                                               value="{{ $ean }}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                @else
                                    <div class="col-span-6 sm:col-span-3">
                                    </div>
                                @endif

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="width"
                                           class="block text-sm font-medium text-gray-700">Misure</label>
                                    <input type="number" name="width" id="width"
                                           value="{{ $width }}" min=1 step=1
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="profile"
                                           class="block text-sm font-medium text-gray-700">&nbsp</label>
                                    <input type="number" name="profile" id="profile"
                                           value="{{ $profile }}" min=0 step=1
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="diameter"
                                           class="block text-sm font-medium text-gray-700">&nbsp</label>
                                    <input type="number" name="diameter" id="diameter"
                                           wire:model="diameter" min=1 step=1
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-1">
                                    <label for="is_commercial" class="block text-sm font-medium text-gray-700">C
                                        (Carico)?</label>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-center">
                                            <input id="is_commercial" name="is_commercial" type="radio" value="1"
                                                   {{ $is_commercial ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="is_commercial"
                                                   class="ml-3 block text-sm font-medium text-gray-700 mr-4">
                                                Si
                                            </label>
                                            <input id="is_commercial" name="is_commercial" type="radio" value="0"
                                                   {{ !$is_commercial ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="is_commercial"
                                                   class="ml-3 block text-sm font-medium text-gray-700">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
                                    <input type="text" name="brand" id="brand"
                                           value="{{ $brand }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="model"
                                           class="block text-sm font-medium text-gray-700">Modello</label>
                                    <input type="text" name="model" id="model"
                                           value="{{ $model }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                @if ($category != \App\Enums\TireCategory::NEW && $category != \App\Enums\TireCategory::NEW_EXTRA)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="dot" class="block text-sm font-medium text-gray-700">DOT (Anno di
                                            costruzione)</label>
                                        <input type="text" name="dot" id="dot" value="{{ $dot }}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                @else
                                    <div class="col-span-6 sm:col-span-3">
                                    </div>
                                @endif

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="load_index" class="block text-sm font-medium text-gray-700">Indice di
                                        carico</label>
                                    <input type="text" name="load_index" id="load_index"
                                           value="{{ $load_index }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="speed_index"
                                           class="block text-sm font-medium text-gray-700">Velocità</label>
                                    <input type="text" name="speed_index" id="speed_index"
                                           value="{{ $speed_index }}" maxlength="10"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="type_id"
                                           class="block text-sm font-medium text-gray-700">Stagione</label>
                                    <select id="type_id" name="type_id"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    >
                                        @foreach (\App\Models\Type::get() as $type)
                                            <option
                                                {{ ($type->id == $type_id) ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($category != \App\Enums\TireCategory::NEW && $category != \App\Enums\TireCategory::NEW_AGED && $category != \App\Enums\TireCategory::NEW_EXTRA)
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="millimeters" class="block text-sm font-medium text-gray-700">Millimetri</label>
                                        <input type="number" min=0 step=0.01 name="millimeters" id="millimeters"
                                               value="{{ $millimeters }}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        >
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="millimeters_2" class="block text-sm font-medium text-gray-700">Millimetri
                                            2</label>
                                        <input type="number" min=0 step=0.01 name="millimeters_2" id="millimeters_2"
                                               value="{{ $millimeters_2 }}"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="millimeters_new_by_manufacturer"
                                               class="block text-sm font-medium text-gray-700">Millimetri di
                                            fabbrica</label>
                                        <select id="millimeters_new_by_manufacturer"
                                                name="millimeters_new_by_manufacturer"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                            <option
                                                {{ $millimeters_new_by_manufacturer== 8 ? 'selected' : ''}} value="8">
                                                8
                                            </option>
                                            <option
                                                {{ $millimeters_new_by_manufacturer == 8.5 ? 'selected' : ''}} value="8.5">
                                                8.5
                                            </option>
                                            <option
                                                {{ $millimeters_new_by_manufacturer == 9 ? 'selected' : ''}} value="9">
                                                9
                                            </option>
                                            <option
                                                {{ $millimeters_new_by_manufacturer == 9.5 ? 'selected' : ''}} value="9.5">
                                                9.5
                                            </option>
                                            <option
                                                {{ $millimeters_new_by_manufacturer == 10 ? 'selected' : ''}}  value="10">
                                                10
                                            </option>
                                            <option
                                                {{ $millimeters_new_by_manufacturer == 10.5 ? 'selected' : ''}} value="10.5">
                                                10.5
                                            </option>
                                            <option
                                                {{ $millimeters_new_by_manufacturer == 11 ? 'selected' : ''}} value="11">
                                                11
                                            </option>
                                        </select>
                                    </div>
                                @else
                                    <div class="col-span-6 sm:col-span-3">
                                        <input type="hidden" name="millimeters" id="millimeters"
                                               value="0"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        >
                                        <input type="hidden" name="millimeters_2" id="millimeters_2"
                                               value="0"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        >
                                        <input type="hidden" name="millimeters_new_by_manufacturer"
                                               id="millimeters_new_by_manufacturer"
                                               value="0"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        >
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if(!auth()->user()->lock_price_edit)
        <div class="mt-4">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Prezzo</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Prezzo di rieferimento e di vendita.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    @if ($category == \App\Enums\TireCategory::NEW || $category == \App\Enums\TireCategory::NEW_EXTRA)
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="price_new"
                                                   class="block text-sm font-medium text-gray-700">@if($category == 5)
                                                    Prezzo montate e spedite
                                                @else
                                                    Prezzo listino
                                                @endif </label>
                                            <input type="number" min=0 step=0.01 name="price_list" id="price_list"
                                                   wire:model="price_list"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        @if($category == \App\Enums\TireCategory::NEW_EXTRA)
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="price_new" class="block text-sm font-medium text-gray-700">PFU</label>
                                                <select id="pfu_contribution" name="pfu_contribution"
                                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                        wire:model="pfu_contribution"
                                                >
                                                    <option value="2.464">Estero 2,464 (2,02 netto)</option>
                                                    <option value="3.172">Italiano 3,172 (2,60 netto)</option>
                                                </select>
                                            </div>
                                        @else
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="price_new" class="block text-sm font-medium text-gray-700">PFU</label>
                                                <input type="number" min=0 step=0.01 name="pfu_contribution"
                                                       id="pfu_contribution"
                                                       wire:model="pfu_contribution"
                                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        @endif

                                        @if ($category == \App\Enums\TireCategory::NEW)
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="discount_immediate_payment"
                                                       class="block text-sm font-medium text-gray-700">Sconto pagamento
                                                    immediato</label>
                                                <input type="number" min=0 step=0.01 name="discount_immediate_payment"
                                                       id="discount_immediate_payment"
                                                       wire:model="discount_immediate_payment"
                                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="discount_supplier"
                                                       class="block text-sm font-medium text-gray-700">Sconto
                                                    fornitore</label>
                                                <input type="number" min=0 step=0.01 name="discount_supplier"
                                                       id="discount_supplier"
                                                       wire:model="discount_supplier"
                                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        @endif
                                    @endif
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price"
                                               class="block text-sm font-medium text-gray-700">Prezzo ritiro</label>
                                        <input type="number" min=0 step=0.01 name="price" id="price"
                                               wire:model="price"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price_ebay" class="block text-sm font-medium text-gray-700">Prezzo
                                            eBay</label>
                                        <input type="number" min=0 step=0.01 name="price_ebay" id="price_ebay"
                                               wire:model="price_ebay"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Quantità e posizione</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Informazioni di quantità e posizionamento su scaffali
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-1">
                                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Scaffale</label>
                                    <input type="text" name="rack_identifier" id="rack_identifier"
                                           value="{{ $rack_identifier }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-1">
                                    <label for="rack_position"
                                           class="block text-sm font-medium text-gray-700">Posizione</label>
                                    <input type="number" name="rack_position" id="rack_position"
                                           value="{{ $rack_position }}" min=1 step=1
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-1">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="amount"
                                           class="block text-sm font-medium text-gray-700">Quantità</label>
                                    @if ($category == \App\Enums\TireCategory::NEW || $category == \App\Enums\TireCategory::NEW_EXTRA)
                                        <input type="number" id="amount" name="amount" step="1" min="0"
                                               class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                               wire:model="amount"
                                        >
                                    @else
                                        <select id="amount" name="amount"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                wire:model="amount"
                                        >
                                            <option value="2">2</option>
                                            <option value="4">4</option>
                                            <option value="6">6</option>
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 sm:px-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <input type="checkbox" id="print" name="print" value="true"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="print"
                                           class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Stampa
                                        immediata</label>
                                </div>
                                <div class="col-span-6 sm:col-span-3 text-right">
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
        </div>
    </div>
</div>
