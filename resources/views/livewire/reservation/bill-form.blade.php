<div>
    <form wire:submit.prevent="submit">
        <div class="mt-4">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Prentazione</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Dettagli prenotazione corrente.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                                        <input type="text" name="note" id="note" wire:model="note" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Prezzo concordato</label>
                                        <input type="number" min="0" step="0.01" wire:model="price" name="price" id="price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="deposit" class="block text-sm font-medium text-gray-700">Acconto</label>
                                        <input type="number" min="0" step="0.01" wire:model="deposit" name="deposit" id="deposit" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="payment_type" class="block text-sm font-medium text-gray-700">{{ __('Payment type') }}</label>
                                        <select name="payment_type" wire:model="payment_type" class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option>-</option>
                                            @foreach(\App\Enums\PaymentType::getReservationInstances() as $paymentType)
                                                <option value="{{ $paymentType->value }}">{{ $paymentType->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="payed" class="block text-sm font-medium text-gray-700">{{ __('Payed') }}?</label>
                                        <input type="checkbox" name="payed" wire:model="payed" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-3 text-left">
                                        @if($show_saved_message)
                                            {{ __('Changes saved') }}
                                        @endif
                                    </div>
                                    <div class="col-span-3">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
    </form>

    @if($reservation->registry != null)
        <div class="shadow sm:rounded-md sm:overflow-hidden mt-5">
            <div class="bg-white p-5">
                <div class="grid grid-cols-10 gap-6 text-center">
                    <div class="col-span-2">
                        @if($reservation->registry->sdi != '' && $reservation->registry->vat_number != '' && $reservation->registry->fiscal_code != '' && $reservation->payment_type !== null)
                            <a href="{{ route('reservations.invoice', ['reservation' => $reservation]) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    {{ __('Generate invoice') }}
                                </button>
                            </a>
                        @else
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" disabled>
                                {{ __('Generate invoice') }}
                            </button>
                            <div class="text-red-500 mt-2">
                                @if($reservation->registry->sdi == '')
                                    {{ __('Missing SDI') }} <br />
                                @endif
                                @if($reservation->registry->vat_number == '')
                                    {{ __('Missing vat number') }} <br />
                                @endif
                                @if($reservation->registry->fiscal_code == '')
                                    {{ __('Missing fiscal code') }} <br />
                                @endif
                                @if(!$reservation->payment_type === null)
                                    {{ __('Missing payment type') }} <br />
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-span-2">
                        @if($reservation->deposit > 0 && $reservation->payment_type !== null)
                            <a href="{{ route('reservations.counter-sale-deposit', ['reservation' => $reservation]) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    {{ __('Generate counter sale - Deposit') }}
                                </button>
                            </a>
                            @if($reservation->deposit_received_at)
                                <div class="mt-2">
                                    <b>{{ __('Deposit received at') }}:</b> {{ $reservation->deposit_received_at->format('d/m/Y') }}
                                </div>
                            @endif
                        @else
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" disabled>
                                {{ __('Generate counter sale - Deposit') }}
                            </button>
                            <div class="text-red-500 mt-2">
                                @if($reservation->deposit <= 0)
                                    {{ __('Missing deposit value') }} <br />
                                @endif
                                @if(!$reservation->payment_type === null)
                                    {{ __('Missing payment type') }} <br />
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-span-2">
                        @if($reservation->deposit > 0 && $reservation->payment_type !== null)
                            <a href="{{ route('reservations.deposit', ['reservation' => $reservation]) }}" target="_blank">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    {{ __('Generate deposit receipt') }}
                                </button>
                            </a>
                        @else
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" disabled>
                                {{ __('Generate deposit receipt') }}
                            </button>
                            <div class="text-red-500 mt-2">
                                @if($reservation->deposit <= 0)
                                    {{ __('Missing deposit value') }} <br />
                                @endif
                                @if(!$reservation->payment_type === null)
                                    {{ __('Missing payment type') }} <br />
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-span-2">
                        @if($reservation->payment_type !== null)
                            <a href="{{ route('reservations.counter-sale', ['reservation' => $reservation]) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    {{ __('Generate counter sale') }}
                                </button>
                            </a>
                        @else
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" disabled>
                                {{ __('Generate counter sale') }}
                            </button>
                            <div class="text-red-500 mt-2">
                                @if(!$reservation->payment_type === null)
                                    {{ __('Missing payment type') }} <br />
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-span-2">
                        <a href="{{ route('reservations.warranty', ['reservation' => $reservation]) }}" target="_blank">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                {{ __('Generate warranty') }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
