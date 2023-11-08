<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Prenotazione - Aggiungi servizio</h3>

    <form action="{{ route('reservations.service.store',['reservation' => $reservation]) }}" method="POST">
        <input type="hidden" name="id" value="{{ $reservation->id }}" />
        @csrf

        <div class="mt-4">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Servizio</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Selezione servizio.
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
                                <livewire:reservation.service-add />
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                @if(request()->has('redirectToBill'))
                                    <input type="hidden" name="redirectToBill" value="1">
                                @endif
                                @if(request()->has('redirectToBill'))
                                    <a href="{{ route('reservations.bill', ['reservation' => $reservation]) }}">
                                        <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('reservations.edit', ['reservation' => $reservation]) }}">
                                        <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annulla
                                        </button>
                                    </a>
                                @endif
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Aggiungi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
