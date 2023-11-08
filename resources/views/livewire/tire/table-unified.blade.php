<div>
    @if($tire->unified)
        <div x-data="{ showUnificationNote : false }">
            <!-- Button -->
            <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 border border-yellow-700 rounded" @click="showUnificationNote = !showUnificationNote">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <g fill="currentColor" transform="rotate(0, 12, 12) translate(0, 0) scale(1, 1)"><path d="M17 20.41L18.41 19 15 15.59 13.59 17 17 20.41zM7.5 8H11v5.59L5.59 19 7 20.41l6-6V8h3.5L12 3.5 7.5 8z"/></g>
                </svg>
            </button>

            <!-- Modal Background -->
            <div x-show="showUnificationNote" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <!-- Modal -->
                <div x-show="showUnificationNote" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showUnificationNote = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                    <span class="font-bold block text-2xl mb-3">Note unificazione</span>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                        {{ $tire->unification_note }}
                    </div>

                    <!-- Buttons -->
                    <div class="text-right space-x-5 mt-5">
                        <button @click="showUnificationNote = !showUnificationNote" type="button" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-blue-50 focus:text-blue">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
    @elseif($tire->getSimilar()->count() > 0)
        <a href="{{ route('tire-merge.create', ['tire' => $tire]) }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <g fill="currentColor" transform="rotate(0, 12, 12) translate(0, 0) scale(1, 1)"><path d="M17 20.41L18.41 19 15 15.59 13.59 17 17 20.41zM7.5 8H11v5.59L5.59 19 7 20.41l6-6V8h3.5L12 3.5 7.5 8z"/></g>
                </svg>
            </button>
        </a>
    @else
        -
    @endif
</div>
