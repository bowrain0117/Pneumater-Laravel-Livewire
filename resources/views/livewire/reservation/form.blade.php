<div>
    @if($registry)
        <livewire:registry.picker :registry="$registry"
                                  :edit_redirect_field_name="'redirectToReservationEdit'"
                                  :edit_redirect_field_value="$reservation->id"/>
    @else
        <livewire:registry.picker :edit_redirect_field_name="'redirectToReservationEdit'"
                                  :edit_redirect_field_value="$reservation->id"/>
    @endif
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
                                    <fieldset>
                                        <div>
                                            <legend class="text-base font-medium text-gray-900">Tipologia</legend>
                                        </div>
                                        <div class="grid grid-cols-3 gap-2 mt-2">
                                            @foreach(\App\Enums\ReservationType::getValues() as $type_id)
                                                <div class="col-span-1 flex">
                                                    <input
                                                        type="radio"
                                                        name="type"
                                                        value="{{ $type_id }}"
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                        wire:model="type"
                                                    >
                                                    <label for="status"
                                                           class="ml-3 block text-sm font-medium text-gray-700">
                                                        {{ \App\Enums\ReservationType::getDescription($type_id) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="appointment" class="block text-sm font-medium text-gray-700">Appuntamento</label>
                                    <livewire:reservation.time-slots :lift_id="$lift_id"
                                                                     :appointment_date="$appointment_date"
                                                                     :appointment_time="$appointment_time"
                                                                     :amount_of_time_slot="$amount_of_time_slot"/>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="source" class="block text-sm font-medium text-gray-700">Sorgente</label>
                                    <input type="text" name="source" id="source" wire:model="source"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                                    <input type="text" name="note" id="note" wire:model="note"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    @if($reservation->id)
                                        <label for="price" class="block text-sm font-medium text-gray-700">Prezzo
                                            concordato</label>
                                        <input type="number" min="0" step="0.01" wire:model="price" name="price"
                                               id="price"
                                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @else
                                        <input type="hidden" name="price" wire:model="price">
                                    @endif
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="deposit" class="block text-sm font-medium text-gray-700">Acconto</label>
                                    <input type="number" min="0" step="0.01" wire:model="deposit" name="deposit"
                                           id="deposit"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
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
