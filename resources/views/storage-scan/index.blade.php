<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium mb-3">
        Inventario
        <a href="{{ route('storage-scan.create') }}">
            <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
            </button>
        </a>

        <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
            <table class="w-full divide-y divide-gray-200 p-2">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                            Nome
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                            Eseguita il
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                            Azioni
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                            &nbsp
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                        </td>
                        <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                        </td>
                    </tr>
                    @foreach($storageScans as $storageScan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $storageScan->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $storageScan->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $storageScan->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <a href="{{ route('storage-scan.show',['storage_scan' => $storageScan]) }}">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Stampa">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </a>
                                <div x-data="{ showModal : false }" class="inline">
                                    <!-- Button -->
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="showModal = !showModal">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <!-- Modal Background -->
                                    <div x-show="showModal" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                        <!-- Modal -->
                                        <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                            <span class="font-bold block text-2xl mb-3">Eliminazione scansione</span>
                                            <p>Sei sicuro di voler eliminare questa scansione? L'operazione è irreversibile</p>

                                            <!-- Buttons -->
                                            <div class="text-right space-x-5 mt-5">
                                                <form action="{{ route('storage-scan.destroy', ['storage_scan' => $storageScan]) }}" method="POST">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </h3>
</x-app-layout>
