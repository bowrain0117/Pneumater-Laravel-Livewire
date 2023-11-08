<div>
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
                    @if($registry->id != null)
                        <input type="hidden" name="registry_id" value="{{ $registry->id }}">
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
                                    {{ __('Note') }}
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
                                    {{ __('Fiscal code') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    {{ __('VAT number') }}
                                </th>
                                @if($shipment_mode)
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Address') }}
                                    </th>
                                @endif
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry->code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($registry->type == \App\Enums\RegistryType::COMPANY)
                                        {{ $registry->denomination }}
                                    @else
                                        {{ $registry->name }} {{ $registry->surname }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                    x-data="{ showNote : false }">
                                    @if($registry->note)
                                        <button type="button" @click="showNote = !showNote"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            <i class="bi bi-journal-text"></i>
                                        </button>

                                        <div x-show="showNote"
                                             class="fixed text-black flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                             x-transition:enter="transition ease duration-300"
                                             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition ease duration-300"
                                             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                            <!-- Modal -->
                                            <div x-show="showNote"
                                                 class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                 @click.away="showNote = false"
                                                 x-transition:enter="transition ease duration-100 transform"
                                                 x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                 x-transition:leave="transition ease duration-100 transform"
                                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                 x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                <span class="font-bold block text-2xl mb-3">Note</span>
                                                <p>{{ $registry->note }}</p>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $registry->phone }}
                                    @if($registry->phone && $registry->cellular)
                                        <br/>
                                    @endif
                                    {{ $registry->cellular }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry->fiscal_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry->vat_number }}</td>
                                @if($shipment_mode)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <!-- Button -->
                                        <div x-data="{ showShipmentData : false }" class="inline">
                                            <!-- Button -->
                                            <button
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                type=button @click="showShipmentData = !showShipmentData">
                                                <i class="bi bi-signpost-2-fill"></i>
                                            </button>

                                            <!-- Modal Background -->
                                            <div x-show="showShipmentData"
                                                 class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                 x-transition:enter="transition ease duration-300"
                                                 x-transition:enter-start="opacity-0"
                                                 x-transition:enter-end="opacity-100"
                                                 x-transition:leave="transition ease duration-300"
                                                 x-transition:leave-start="opacity-100"
                                                 x-transition:leave-end="opacity-0">
                                                <!-- Modal -->
                                                <div x-show="showShipmentData"
                                                     class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                     @click.away="showShipmentData = false"
                                                     x-transition:enter="transition ease duration-100 transform"
                                                     x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                     x-transition:leave="transition ease duration-100 transform"
                                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                     x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                    <span
                                                        class="font-bold block text-2xl mb-3">{{ __('Registry shipment data') }}</span>
                                                    <p class="text-center text-lg">
                                                        <b>{{ __('Address') }}</b>: {{ $registry->address }} <br/>
                                                        <b>{{ __('Postal code') }}</b>: {{ $registry->postal_code }}
                                                        <br/>
                                                        <b>{{ __('City') }}</b>: {{ $registry->city }} <br/>
                                                        <b>{{ __('Province') }}</b>: {{ $registry->province }} <br/>
                                                        <b>{{ __('Region') }}</b>: {{ $registry->region }} <br/>
                                                        <b>{{ __('Nation') }}</b>: {{ $registry->nation }} <br/>
                                                    </p>
                                                    @if($registry->is_shipment_on_different_location)
                                                        <span
                                                            class="font-bold block text-2xl mb-3">{{ __('Alternate shipping address') }}</span>
                                                        <p class="text-center text-lg">
                                                            <b>{{ __('Denomination') }}</b>: {{ $registry->denomination_shipment }}
                                                            <br/>
                                                            <b>{{ __('Address') }}</b>: {{ $registry->address_shipment }}
                                                            <br/>
                                                            <b>{{ __('Postal code') }}</b>: {{ $registry->postal_code_shipment }}
                                                            <br/>
                                                            <b>{{ __('City') }}</b>: {{ $registry->city_shipment }}
                                                            <br/>
                                                            <b>{{ __('Province') }}</b>: {{ $registry->province_shipment }}
                                                            <br/>
                                                            <b>{{ __('Region') }}</b>: {{ $registry->region_shipment }}
                                                            <br/>
                                                            <b>{{ __('Nation') }}</b>: {{ $registry->nation_shipment }}
                                                            <br/>
                                                        </p>
                                                    @endif

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
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <a href="{{ route('registries.edit', ['registry' => $registry, $edit_redirect_field_name => $edit_redirect_field_value]) }}">
                                        <button type="button"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                    </a>
                                    <button wire:click="enterSearchMode()" type="button"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <b>{{ __('Select a customer') }}</b>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($this->search_mode)
        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Identification') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Registry identification data') }}.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="type"
                                           class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                                    <select id="type" name="type"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            wire:model="type"
                                    >
                                        @foreach(\App\Enums\RegistryType::getValues() as $value)
                                            <option
                                                value="{{ $value }}">{{ \App\Enums\RegistryType::getDescription($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="code"
                                           class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
                                    <input type="text" name="code" id="code" wire:model="code"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                @if($type == \App\Enums\RegistryType::COMPANY)
                                    <div class="col-span-6">
                                        <label for="denomination"
                                               class="block text-sm font-medium text-gray-700">{{ __('Denomination') }}</label>
                                        <input type="text" name="denomination" id="denomination"
                                               wire:model="denomination"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                @else
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name"
                                               class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="name" wire:model="name"
                                               class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="surname"
                                               class="block text-sm font-medium text-gray-700">{{ __('Surname') }}</label>
                                        <input type="text" name="surname" id="surname" wire:model="surname"
                                               class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                @endif

                                @if($type == \App\Enums\RegistryType::COMPANY)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="sdi"
                                               class="block text-sm font-medium text-gray-700">{{ __('SDI') }}</label>
                                        <input type="text" name="sdi" id="sdi" wire:model="sdi"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                @endif

                                @if($type == \App\Enums\RegistryType::COMPANY || auth()->user()->isA('customer'))
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="fiscal_code"
                                               class="block text-sm font-medium text-gray-700">{{ __('Fiscal code') }}</label>
                                        <input type="text" name="fiscal_code" id="fiscal_code" wire:model="fiscal_code"
                                               class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                @endif

                                @if($type == \App\Enums\RegistryType::COMPANY)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="vat_number"
                                               class="block text-sm font-medium text-gray-700">{{ __('VAT code') }}</label>
                                        <input type="text" name="vat_number" id="vat_code" wire:model="vat_number"
                                               class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Contacts') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Registry contact data') }}.
                        </p>
                        <div class="flex items-center mt-3">
                            <input value="1" wire:model="show_all_fields" type="checkbox"
                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <div class="ml-3 text-sm">
                                <label for="show_all_fields"
                                       class="font-medium text-gray-700">{{ __('Show all contact fields') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                            <div class="grid grid-cols-6 gap-6">
                                @if($show_all_fields)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="phone"
                                               class="block text-sm font-medium text-gray-700">{{ __('Phone') }}</label>
                                        <input type="text" name="phone" id="phone" wire:model="phone"
                                               class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                @endif

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="cellular"
                                           class="block text-sm font-medium text-gray-700">{{ __('Cellular') }}</label>
                                    <input type="text" name="cellular" id="cellular" wire:model="cellular"
                                           class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                </div>

                                @if($show_all_fields)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email"
                                               class="block text-sm font-medium text-gray-700">{{ __('E-mail') }}</label>
                                        <input type="text" name="email" id="email" wire:model="email"
                                               class="mt-1 block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                @endif

                                @if($allow_create && !$shipment_mode)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">&nbsp</label>
                                        <button
                                            wire:click="createRegistry" type="button"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >{{ __('Create registry') }}</button>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Notes') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Registry notes') }}.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label for="note"
                                           class="block text-sm font-medium text-gray-700">{{ __('Note') }}</label>
                                    <textarea type="text" name="note" id="note" wire:model="note" rows="1"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if($registries_found->count() > 0)
            <div class="mt-4">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Duplicates') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Duplicates found') }}.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white overflow-auto">
                                <table class="min-w-full divide-y divide-gray-200">
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
                                            {{ __('Note') }}
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
                                            {{ __('Fiscal code') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                            {{ __('VAT number') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($registries_found as $registry_found)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry_found->code }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($registry_found->type == \App\Enums\RegistryType::COMPANY)
                                                    {{ $registry_found->denomination }}
                                                @else
                                                    {{ $registry_found->name }} {{ $registry_found->surname }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                                x-data="{ showNote : false }">
                                                @if($registry->note)
                                                    <button type="button" @click="showNote = !showNote"
                                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                    >
                                                        <i class="bi bi-journal-text"></i>
                                                    </button>

                                                    <div x-show="showNote"
                                                         class="fixed text-black flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                         x-transition:enter="transition ease duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition ease duration-300"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showNote"
                                                             class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                             @click.away="showNote = false"
                                                             x-transition:enter="transition ease duration-100 transform"
                                                             x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                             x-transition:leave="transition ease duration-100 transform"
                                                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                             x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span
                                                                class="font-bold block text-2xl mb-3">{{ __('Note') }}</span>
                                                            <p>{{ $registry->note }}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $registry_found->phone }}
                                                @if($registry_found->phone && $registry_found->cellular)
                                                    <br/>
                                                @endif
                                                {{ $registry_found->cellular }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry_found->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry_found->fiscal_code }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registry_found->vat_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a href="{{ route('registries.edit', ['registry' => $registry_found]) }}"
                                                   target="_blank">
                                                    <button type="button"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </a>
                                                <button wire:click="selectRegistry({{ $registry_found->id }})" type="button"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <i class="bi bi-check-lg"></i>
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
        @endif

        @if($shipment_mode)
            <div class="mt-4">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Location') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Registry location data') }}.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="address"
                                               class="block text-sm font-medium text-gray-700">{{ __('Address') }}</label>
                                        <input type="text" name="address" id="address" wire:model="address"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="postal_code"
                                               class="block text-sm font-medium text-gray-700">{{ __('Postal code') }}</label>
                                        <input type="text" name="postal_code" id="postal_code" wire:model="postal_code"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        @if(count($cities_found) > 0)
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700">&nbsp</label>
                                            <div x-data="{ showCityModal : false }" class="inline">
                                                <button type="button"
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                                        @click="showCityModal = !showCityModal">
                                                    {{ __('Select city') }}
                                                </button>

                                                <div x-show="showCityModal"
                                                     class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                     x-transition:enter="transition ease duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="transition ease duration-300"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0">
                                                    <div x-show="showCityModal"
                                                         class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                         @click.away="showCityModal = false"
                                                         x-transition:enter="transition ease duration-100 transform"
                                                         x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                         x-transition:leave="transition ease duration-100 transform"
                                                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                         x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                        <table class="w-full divide-y divide-gray-200 p-2">
                                                            <thead class="bg-gray-50">
                                                            <tr>
                                                                <th scope="col"
                                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                    {{ __('City') }}
                                                                </th>
                                                                <th scope="col"
                                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                    {{ __('Province') }}
                                                                </th>
                                                                <th scope="col"
                                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                    {{ __('Region') }}
                                                                </th>
                                                                <th scope="col"
                                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                    {{ __('Actions') }}
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="bg-white divide-y divide-gray-200">
                                                            @foreach($cities_found as $key => $city)
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $city->comune }}</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $city->provincia }}</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $city->regione }}</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                        <button type="button"
                                                                                wire:click="selectCity({{$key}})"
                                                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                                                                            {{ __('Select') }}
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="city"
                                               class="block text-sm font-medium text-gray-700">{{ __('City') }}</label>
                                        <input type="text" name="city" id="city" wire:model="city"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="province"
                                               class="block text-sm font-medium text-gray-700">{{ __('Province') }}</label>
                                        <input type="text" name="province" id="province" wire:model="province"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="region"
                                               class="block text-sm font-medium text-gray-700">{{ __('Region') }}</label>
                                        <input type="text" name="region" id="region" wire:model="region"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="nation"
                                               class="block text-sm font-medium text-gray-700">{{ __('Nation') }}</label>
                                        <input type="text" name="nation" id="nation" wire:model="nation"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Shipments') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Registry shipment data') }}.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3 flex items-center">
                                        <input name="is_shipment_on_different_location" value="1"
                                               wire:model="is_shipment_on_different_location" type="checkbox"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        <div class="ml-3 text-sm">
                                            <label for="redirecToEdit"
                                                   class="font-medium text-gray-700">{{ __('Ship to different address') }}</label>
                                        </div>
                                    </div>

                                    @if($allow_create && $shipment_mode)
                                        <div class="col-span-6 sm:col-span-3">
                                            <button
                                                wire:click="createRegistry" type="button"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >{{ __('Create registry') }}</button>
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6">
                                            <label for="denomination_shipment"
                                                   class="block text-sm font-medium text-gray-700">{{ __('Denomination') }}</label>
                                            <input type="text" name="denomination_shipment" id="denomination_shipment"
                                                   wire:model="denomination_shipment"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6">
                                            <label for="address_shipment"
                                                   class="block text-sm font-medium text-gray-700">{{ __('Address') }}</label>
                                            <input type="text" name="address_shipment" id="address_shipment"
                                                   wire:model="address_shipment"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="postal_code_shipment"
                                                   class="block text-sm font-medium text-gray-700">{{ __('Postal code') }}</label>
                                            <input type="text" name="postal_code_shipment" id="postal_code_shipment"
                                                   wire:model="postal_code_shipment"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6 sm:col-span-3">
                                            @if(count($cities_found_shipment) > 0)
                                                <label for="postal_code"
                                                       class="block text-sm font-medium text-gray-700">&nbsp</label>
                                                <div x-data="{ showModal : false }" class="inline">
                                                    <button type="button"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                                            @click="showModal = !showModal">
                                                        {{ __('Select city') }}
                                                    </button>

                                                    <div x-show="showModal"
                                                         class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                         x-transition:enter="transition ease duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition ease duration-300"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0">
                                                        <div x-show="showModal"
                                                             class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                             @click.away="showModal = false"
                                                             x-transition:enter="transition ease duration-100 transform"
                                                             x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                             x-transition:leave="transition ease duration-100 transform"
                                                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                             x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <table class="w-full divide-y divide-gray-200 p-2">
                                                                <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                        {{ __('City') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                        {{ __('Province') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                        {{ __('Region') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                                                        {{ __('Actions') }}
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="bg-white divide-y divide-gray-200">
                                                                @foreach($cities_found_shipment as $key => $city)
                                                                    <tr>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $city->comune }}</td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $city->provincia }}</td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $city->regione }}</td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                            <button type="button"
                                                                                    wire:click="selectCityShipment({{$key}})"
                                                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                                                                                {{ __('Select') }}
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="city_shipment"
                                                   class="block text-sm font-medium text-gray-700">{{ __('City') }}</label>
                                            <input type="text" name="city_shipment" id="city_shipment"
                                                   wire:model="city_shipment"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="province_shipment"
                                                   class="block text-sm font-medium text-gray-700">{{ __('Province') }}</label>
                                            <input type="text" name="province_shipment" id="province_shipment"
                                                   wire:model="province_shipment"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="region_shipment"
                                                   class="block text-sm font-medium text-gray-700">{{ __('Region') }}</label>
                                            <input type="text" name="region_shipment" id="region_shipment"
                                                   wire:model="region_shipment"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    @endif

                                    @if($is_shipment_on_different_location)
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="nation_shipment"
                                                   class="block text-sm font-medium text-gray-700">{{ __('Nation') }}</label>
                                            <input type="text" name="nation_shipment" id="nation_shipment"
                                                   wire:model="nation_shipment"
                                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
