<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Pneumatici - Modifica</h3>

    <form action="{{ route('tires.update', ['tire' => $tire ]) }}" method="POST">
        <input name="_method" type="hidden" value="PUT">
        <input type="hidden" name="id" value="{{ $tire->id }}">
        @csrf

        <livewire:tire.form :tire="$tire"/>
    </form>

    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Foto</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Immagini per pubblicazione annunci.
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                                @foreach ($tire->photos as $photo)
                                    <div class="bg-gray-100 flex items-center">
                                        @if($photo->customPhotos()->where('user_id', auth()->id())->first())
                                            <img class="object-scale-down h-50 w-full"
                                                 src="{{ Storage::url($photo->customPhotos()->where('user_id', auth()->id())->first()->path) }}">
                                        @else
                                            <img class="object-scale-down h-50 w-full"
                                                 src="{{ Storage::url($photo->path) }}">
                                        @endif
                                        <form action="{{ route('tire-photos.destroy', ['tire_photo' => $photo]) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="border border-transparent shadow-sm text-sm font-medium rounded-r-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg class="h-20 w-3 md:w-4" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <form action="{{ route('tire-photos.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                @csrf
                                <input type="hidden" name="tire_id" value="{{ $tire->id }} ">
                                <input type="file" name="tire_photo[]" id="tire_photo" multiple>
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Aggiungi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
