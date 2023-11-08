<div>
    <form wire:submit.prevent="submit">
        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Details') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Proprietà dell'listino.
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
                                    <label for="name"
                                           class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                    <input type="text" name="name" wire:model="name"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        @if(!$priceList->id)
                            <div class="px-4 py-3 bg-gray-50 sm:px-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3"></div>
                                    <div class="col-span-6 sm:col-span-3 text-right">
                                        <button
                                            type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($priceList->id)
                        <div class="shadow sm:rounded-md sm:overflow-hidden mt-3">

                            <table class="w-full divide-y divide-gray-200 p-2">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Field') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Operator') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Value') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                                        <select wire:model="field"
                                                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @foreach(\DB::getSchemaBuilder()->getColumnListing('tires') as $field_db)
                                                <option value="{{ $field_db }}">{{ $field_db }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                                        <select wire:model="operator"
                                                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="=">=</option>
                                            <option value="!=">=</option>
                                            <option value=">">></option>
                                            <option value=">=">>=</option>
                                            <option value="<"><</option>
                                            <option value="<="><=</option>
                                        </select>
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                                        @switch($field)
                                            @case('category')
                                                <select wire:model="value"
                                                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                    <option value="">-</option>
                                                    @foreach(\App\Enums\TireCategory::getInstances() as $category)
                                                        <option
                                                            value="{{ $category->value }}">{{ $category->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @break
                                            @case('type_id')
                                                <select wire:model="value"
                                                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                    <option value="">-</option>
                                                    @foreach(\App\Models\Type::all() as $type)
                                                        <option
                                                            value="{{ $type->id }}">{{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @break
                                            @default
                                                <input type="text"
                                                       wire:model="value"
                                                       class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        @endswitch
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                                        <button
                                            type="button"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            wire:click="addRule"
                                        >
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @foreach($pricelist_rules as $rule)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $rule->field }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $rule->operator }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $rule->value }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <button
                                                type="button"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                                wire:click="removeRule({{ $rule->id }})"
                                            >
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <div class="px-4 py-3 bg-gray-50 sm:px-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3"></div>
                                    <div class="col-span-6 sm:col-span-3 text-right">
                                        <button
                                            type="button"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            wire:click="saveAndClose"
                                        >
                                            {{ __('Save and close') }}
                                        </button>
                                        <button
                                            type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </form>
</div>
