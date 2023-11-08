<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">
        Sconti
    </h3>

    <form action="{{ route('tires.discountSubmit') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 md:col-span-1 mt-2">
                <h3 class="text-gray-600 text-2xl font-medium">
                    Pneumatici selezionati:
                </h3>
                @foreach($tires as $tire)
                    <input type="hidden" name="tires[]" value="{{ $tire->id }}">
                    <div class="shadow sm:rounded-md sm:overflow-hidden mt-2">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-5 gap-2">
                                <div class="col-span-5 sm:col-span-1">
                                    #{{ $tire->id }}
                                </div>
                                <div class="col-span-5 sm:col-span-1">
                                    {{ \App\Enums\TireCategory::getDescription($tire->category) }} <br />
                                    {{ $tire->type->name }}
                                </div>
                                <div class="col-span-5 sm:col-span-1">
                                    {{ $tire->width }} {{ $tire->profile }} {{ $tire->diameter }}
                                </div>
                                <div class="col-span-5 sm:col-span-1">
                                    {{ $tire->brand }} {{ $tire->model }}
                                </div>
                                <div class="col-span-5 sm:col-span-1 text-center">
                                    {{ $tire->price }}€ <br />
                                    <button onClick="remove(event)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">
                                        <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-span-2 md:col-span-1 mt-2">
                <h3 class="text-gray-600 text-2xl font-medium">
                    Sconto:
                </h3>
                <div class="shadow sm:rounded-md sm:overflow-hidden mt-2">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div>
                            <label for="discount" class="block text-sm font-medium text-gray-700">Sconto</label>
                            <input type="number" name="discount" id="discount" value="{{ old('discount') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="percentage" class="block text-sm font-medium text-gray-700">Percentuale</label>
                            <input type="number" name="percentage" id="percentage" min=-100 max=100 value="{{ old('discount') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <input type="submit" value="Applica" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function remove(e){
            target = e.currentTarget;
            elementToRemove = target.parentElement.parentElement.parentElement.parentElement;

            if (confirm("Sei sicuro di volerlo rimuovere?")) {
                elementToRemove.remove();
            }

            e.preventDefault();
        }
    </script>
</x-app-layout>
