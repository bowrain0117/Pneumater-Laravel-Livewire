<div>
    <table class="min-w-full divide-y divide-gray-200 mt-4">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Codice
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nome
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Prezzo
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Ore necessarie
            </th>
            <th scope="col" class="relative px-6 py-3 text-right">
                <a href="{{ route('services.create') }}" class="text-indigo-600 hover:text-indigo-900">Aggiungi</a>
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{-- Filters --}}
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="text" name="code" wire:model="code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <input type="text" name="name"  wire:model="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <input type="text" disabled class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                </td>
            </tr>
            {{-- Data --}}
            @foreach($services as $service)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $service->code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $service->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $service->price }} €
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @switch($service->amount_of_time_slot)
                            @case(0)
                                0m
                                @break
                            @case(1)
                                30m
                                @break
                            @case(2)
                                1h
                                @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div>
                            <a href="{{ route('services.edit', ['service' => $service]) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" type="button">
                                    <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </a>
                            <div x-data="{ showModal : false }">
                                <!-- Button -->
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="showModal = !showModal">
                                    <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Modal Background -->
                                <div x-show="showModal" class="fixed text-left text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                    <!-- Modal -->
                                    <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                        <span class="font-bold block text-2xl mb-3">Eliminazione "{{ $service->name }}"</span>
                                        <p>Sei sicuro di voler eliminare il servizio "{{ $service->name }}"? L'operazione è irreversibile</p>

                                        <!-- Buttons -->
                                        <div class="text-right space-x-5 mt-5">
                                            <form action="{{ route('services.destroy', ['service' => $service]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button @click="showModal = !showModal" type="button" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                                    Elimina
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
