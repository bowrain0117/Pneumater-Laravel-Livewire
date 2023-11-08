<x-app-layout>
    <div class="grid grid-cols-12 gap-6 mb-2">
        <div class="col-span-4">
            <a href="{{ route('shops.kijiji.show',['kijiji' => $next_tire]) }}">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </a>
        </div>
        <div class="col-span-8">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-6 mt-4">
        <div class="col-span-1">
            <p class="font-extrabold text-2xl">Titolo</p>
            {{ $tire->getKijijiTitle() }}
        </div>
        <div class="col-span-1">
            <p class="font-extrabold text-2xl">Prezzo</p>
            {{ $tire->getKijijiPrice() }}
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
                        @foreach ($tire->photos as $index => $photo)
                            <div class="bg-gray-100 flex items-center">
                                <a href="{{ Storage::url($photo->path) }}" download="{{ $index + 1 }}">
                                    <img class="object-scale-down h-50 w-full" src="{{ Storage::url($photo->path) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
