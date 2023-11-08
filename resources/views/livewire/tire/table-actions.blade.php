<div>
    @if($tire->category == 3)
        <a href="https://tyre24.alzura.com/it/it/redex?search=ean{{ $tire->ean }}&manufacturerName=&sort=price:asc&area=&category=&page=0&rating=good&stock=4"
           target="_blank">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path
                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2h-1.528A6 6 0 004 9.528V4z"/>
                    <path fill-rule="evenodd"
                          d="M8 10a4 4 0 00-3.446 6.032l-1.261 1.26a1 1 0 101.414 1.415l1.261-1.261A4 4 0 108 10zm-2 4a2 2 0 114 0 2 2 0 01-4 0z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
        </a>
    @else
        <a href="https://www.google.it/search?q={{ $tire->searchString() }}" target="_blank">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path
                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2h-1.528A6 6 0 004 9.528V4z"/>
                    <path fill-rule="evenodd"
                          d="M8 10a4 4 0 00-3.446 6.032l-1.261 1.26a1 1 0 101.414 1.415l1.261-1.261A4 4 0 108 10zm-2 4a2 2 0 114 0 2 2 0 01-4 0z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
        </a>
    @endif
    @if(auth()->user()->isNotA('customer'))
        <a href="{{ route('tires.show', ['tire' => $tire]) }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd"
                          d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
        </a>
    @endif
    @if(auth()->user()->isNotA('customer'))
        <a href="{{ route('tires.edit', ['tire' => $tire]) }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </button>
        </a>
    @endif
    @if($tire->status == \App\Enums\TireStatus::Sold && auth()->user()->isNotA('customer'))
        <div x-data="{ showModalRestore : false }" class="inline">
            <!-- Button -->
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                    @click="showModalRestore = !showModalRestore">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                          clip-rule="evenodd"/>
                </svg>
            </button>

            <!-- Modal Background -->
            <div x-show="showModalRestore"
                 class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                 x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <!-- Modal -->
                <div x-show="showModalRestore" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                     @click.away="showModalRestore = false" x-transition:enter="transition ease duration-100 transform"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease duration-100 transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                    <span
                        class="font-bold block text-2xl mb-3">Ripristino "{{ $tire->brand }} {{ $tire->model }}"</span>
                    <p>Sei sicuro di voler ripristinare lo pneumatico "{{ $tire->brand }} {{ $tire->model }}"?
                        L'operazione è irreversibile</p>

                    <!-- Buttons -->
                    <div class="text-right space-x-5 mt-5">
                        <button @click="showModalRestore = !showModalRestore" type="button"
                                class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                            Cancel
                        </button>
                        <a href="{{ route('tires.restore', ['tire' => $tire]) }}">
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                Ripristina
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(auth()->user()->isNotA('customer'))
        <div x-data="{ showModal : false }" class="inline">
            <!-- Button -->
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                    @click="showModal = !showModal">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd"/>
                </svg>
            </button>

            <!-- Modal Background -->
            <div x-show="showModal"
                 class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                 x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <!-- Modal -->
                <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                     @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease duration-100 transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                    <span
                        class="font-bold block text-2xl mb-3">Eliminazione "{{ $tire->brand }} {{ $tire->model }}"</span>
                    <p>Sei sicuro di voler eliminare lo pneumatico "{{ $tire->brand }} {{ $tire->model }}"? L'operazione
                        è
                        irreversibile</p>

                    <!-- Buttons -->
                    <div class="text-right space-x-5 mt-5">
                        <form action="{{ route('tires.destroy', ['tire' => $tire]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button @click="showModal = !showModal" type="button"
                                    class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                Cancel
                            </button>
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                Elimina
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
