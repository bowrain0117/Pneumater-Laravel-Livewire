<x-app-layout>
    <div class="grid grid-cols-12 gap-6 mb-2">
        <div class="col-span-4">
            <a href="{{ route('tires.index') }}">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                </button>
            </a>
        </div>
        <div class="col-span-8">
        </div>
    </div>
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-1">
            <p class="font-extrabold text-2xl">eBay - Titolo</p>
            {{ $tire->getEbayTitle() }}
        </div>
        <div class="col-span-1">
            <p class="font-extrabold text-2xl">Subito - Titolo</p>
            {{ $tire->getSubitoTitle() }}
        </div>
        <div class="col-span-1">
            <p class="font-extrabold text-2xl">Kijiji - Titolo</p>
            {{ $tire->getKijijiTitle() }}
        </div>
    </div>
    <div class="grid grid-cols-2 gap-6 mt-4">
        <div class="col-span-1">
            <p class="font-extrabold text-2xl">Descrizione universale</p>
            <p>
                {!! $tire->getUniversalDescription() !!}
            </p>
        </div>
        <div class="col-span-1">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                        @foreach ($tire->photos as $photo)
                            <div class="bg-gray-100 flex items-center">
                                <img class="object-scale-down h-50 w-full" src="{{ Storage::url($photo->path) }}">
                                <form action="{{ route('tire-photos.destroy', ['tire_photo' => $photo]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border border-transparent shadow-sm text-sm font-medium rounded-r-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="h-20 w-3 md:w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Aggiungi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
