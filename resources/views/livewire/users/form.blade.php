<div>
    <div class="mt-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Details') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Proprietà dell'utente.
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

                            <div class="col-span-6 sm:col-span-6">
                                <label for="brand"
                                       class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                                <input type="text" name="email" wire:model="email" @if($isEdit) disabled @endif
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="role"
                                       class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                                <select id="role" name="role"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        wire:model="roles"
                                >
                                    @foreach(\Silber\Bouncer\Database\Role::all() as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if($roles == \Silber\Bouncer\Database\Role::where('name', 'customer')->first()->id)
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="customer_type"
                                           class="block text-sm font-medium text-gray-700">{{ __('Customer type') }}</label>
                                    <select id="customer_type" name="customer_type"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            wire:model="customer_type"
                                    >
                                        @foreach(\App\Enums\User\CustomerType::getInstances() as $customerType)
                                            <option
                                                value="{{ $customerType->value }}">{{ $customerType->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="price_list_id"
                                           class="block text-sm font-medium text-gray-700">{{ __('Price list') }}</label>
                                    <select id="price_list_id" name="price_list_id"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            wire:model="price_list_id"
                                    >
                                        <option value="">-</option>
                                        @foreach(\App\Models\PriceList::all() as $priceList)
                                            <option value="{{ $priceList->id }}">{{ $priceList->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-span-6 sm:col-span-3">
                                <label for="lock_price_edit"
                                       class="block text-sm font-medium text-gray-700">{{ __('Lock price edit') }}</label>
                                <select id="lock_price_edit" name="lock_price_edit"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        wire:model="lock_price_edit"
                                >
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>

                            @if($roles == \Silber\Bouncer\Database\Role::where('name', 'customer')->first()->id)
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="default_courier"
                                           class="block text-sm font-medium text-gray-700">{{ __('Default courirer') }}</label>
                                    <select id="default_courier" name="default_courier"
                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            wire:model="default_courier"
                                    >
                                        <option value="">-</option>
                                        @foreach(\App\Enums\Couriers::getInstances() as $courier)
                                            <option value="{{ $courier->value }}">{{ $courier->description }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6">
                                    <label for="ebay_auth_token"
                                           class="block text-sm font-medium text-gray-700">{{ __('Ebay auth token') }}</label>
                                    <input type="text" id="ebay_auth_token" name="ebay_auth_token"
                                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                           wire:model="ebay_auth_token"
                                    >
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="watermark"
                                           class="block text-sm font-medium text-gray-700">{{ __('Watermark') }}</label>
                                    <input type="file" name="watermark" id="watermark">
                                </div>

                                @if($watermark_path)
                                    <div class="col-span-6 sm:col-span-3">
                                        <img class="object-scale-down h-20 w-full"
                                             src="{{ Storage::url($watermark_path) }}">
                                    </div>
                                @endif
                            @endif


                            @if(!$isEdit)
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="brand"
                                           class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                    <input type="password" name="password"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="brand"
                                           class="block text-sm font-medium text-gray-700">{{ __('Password confirmation') }}</label>
                                    <input type="password" name="password_confirmation"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 sm:px-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3"></div>
                            <div class="col-span-6 sm:col-span-3 text-right">
                                <button
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
