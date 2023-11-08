<div>
    @if ($registry)
        <livewire:registry.picker :registry="$registry" />
    @else
        <livewire:registry.picker />
    @endif

    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Deposit</h3>
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
                                    <label for="car_model"
                                        class="block text-sm font-medium text-gray-700">{{ __('Car model') }}</label>
                                    <input type="text" name="car_model" id="car_model" wire:model="car_model"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="license_plate"
                                        class="block text-sm font-medium text-gray-700">{{ __('License plate') }}</label>
                                    <input type="text" name="license_plate" id="license_plate"
                                        wire:model="license_plate"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        required>
                                </div>

                                <!--
                            <div class="col-span-6 sm:col-span-3">
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                <select id="status" name="status" wire:model="status"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach (\App\Enums\DepositStatus::getValues() as $value)
<option value="{{ $value }}">
                                            {{ \App\Enums\DepositStatus::getDescription($value) }}</option>
@endforeach
                                </select>
                            </div>
                            -->

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                                    <textarea name="note" id="note" wire:model="note"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('note') }}</textarea>
                                </div>

                                <div class="col-span-6 sm:col-span-3"></div>

                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            @if ($redirectToBill)
                                <input type="hidden" name="redirectToBill" value="1">
                            @endif
                            @if ($reservation && !$redirectToBill)
                                <a href="{{ route('reservations.edit', ['reservation' => $reservation]) }}">
                                    <button type="button"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Annulla
                                    </button>
                                </a>
                            @elseif($reservation && $redirectToBill)
                                <a href="{{ route('reservations.bill', ['reservation' => $reservation]) }}">
                                    <button type="button"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Annulla
                                    </button>
                                </a>
                            @endif
                            <button type="submit"
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
