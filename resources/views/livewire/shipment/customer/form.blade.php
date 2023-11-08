<div>
    <form wire:submit.prevent="submit">
        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Spedizione</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Dettagli spedizione.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md overflow-auto">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="appointment_not_defined"
                                           class="block text-sm font-medium text-gray-700">Data di partenza</label>
                                    <livewire:component.nullable-date :name="'estimated_departure'"
                                                                      :value="$estimated_departure"/>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                                    <input type="text" name="note" wire:model="note"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-50 sm:px-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3"></div>
                                <div class="col-span-6 sm:col-span-3 text-right">
                                    <a href="{{ route('tires.index') }}">
                                        <button
                                            type="button"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            {{ __('Cancel') }}
                                        </button>
                                    </a>
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        {{ __('Save and close') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        window.addEventListener('updatedNullableDate', event => {
        @this.estimated_departure
            = document.getElementById("estimated_departure").value;
        })
    </script>
</div>
