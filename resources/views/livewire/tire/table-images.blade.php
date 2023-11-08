<div>
    <div x-data="{ showPictures : false }">
        <!-- Button -->
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                @click="showPictures = !showPictures">
            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                      clip-rule="evenodd"/>
            </svg>
        </button>

        <!-- Modal Background -->
        <div x-show="showPictures"
             class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
             x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <!-- Modal -->
            <div x-show="showPictures" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                 @click.away="showPictures = false" x-transition:enter="transition ease duration-100 transform"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease duration-100 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    @foreach($tire->photos as $photo)
                        <div class="bg-gray-100 flex items-center">
                            @if($photo->customPhotos()->where('user_id', auth()->id())->first())
                                <img class="object-scale-down h-50 w-full"
                                     src="{{ Storage::url($photo->customPhotos()->where('user_id', auth()->id())->first()->path) }}">
                            @else
                                <img class="object-scale-down h-50 w-full"
                                     src="{{ Storage::url($photo->path) }}">
                            @endif
                        </div>
                    @endforeach
                </div>

                @if(auth()->user()->isNotA('customer'))
                    <form action="{{ route('tire-photos.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="px-4 py-3 text-right sm:px-6">
                            @csrf
                            <b>Aggiungi foto:</b>
                            <input type="hidden" name="tire_id" value="{{ $tire->id }} ">
                            <input type="file" name="tire_photo[]" id="tire_photo" multiple>
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Aggiungi
                            </button>
                        </div>
                    </form>
                @endif

                <!-- Buttons -->
                <div class="text-right space-x-5 mt-5">
                    <button @click="showPictures = !showPictures" type="button"
                            class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-blue-50 focus:text-blue">
                        Chiudi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
