
<x-app-layout>
    <button onclick="reprint()" style="display: none" type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mb-2" id="print-button">
        <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
        </svg>
    </button>
    @foreach($reservations as $reservation)
        <div class="grid grid-cols-5 gap-6 divide-black">
            <div class="col-span-2">
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-1">
                        <b>#{{ $reservation->id }}</b>
                    </div>
                    <div class="col-span-1">
                        @if($reservation->registry && $reservation->registry->type == \App\Enums\RegistryType::PRIVATE)
                            {{ $reservation->registry->name }} {{ $reservation->registry->surname }}
                        @elseif($reservation->registry && $reservation->registry->type == \App\Enums\RegistryType::COMPANY)
                            {{ $reservation->registry->denomination }}
                        @else
                            {{ $reservation->name }}
                        @endif
                    </div>
                    <div class="col-span-1">
                        @if($reservation->registry)
                            {{ $reservation->registry->phone }}
                            @if($reservation->registry->phone && $reservation->registry->cellular)
                                <br />
                            @endif
                            {{ $reservation->registry->cellular }}
                        @else
                            {{ $reservation->phone }}
                        @endif
                    </div>
                </div>
                @if($reservation->note)
                    <b>Note:</b> {{ $reservation->note }}
                @endif
            </div>
            <div class="col-span-3">
                @foreach($reservation->tires as $tire)
                    <div class="grid grid-cols-7 gap-6">
                        <div class="col-span-1">
                            <b><i>{{ __('Tire') }}</i></b><br />
                        </div>
                        <div class="col-span-1">
                            <b>#{{ $tire->id }}</b><br />
                            {{ \App\Enums\TireCategory::getDescription($tire->category) }}
                        </div>
                        <div class="col-span-1">
                            {{ $tire->width }} {{ $tire->profile }} {{ $tire->diameter }} {{ $tire->is_commercial ? 'C' : '' }}
                        </div>
                        <div class="col-span-1">
                            {{ $tire->brand }} {{ $tire->model }}
                        </div>
                        <div class="col-span-1">
                            {{ $tire->type->name }}
                        </div>
                        <div class="col-span-1">
                            <b>Q.ta:</b> {{ $tire->amount }}
                        </div>
                        <div class="col-span-1">
                            <b>Posizione:</b> {{ $tire->rack_identifier }} {{ $tire->rack_position }}<br />
                        </div>
                    </div>
                @endforeach
                @foreach($reservation->products as $product)
                    <div class="grid grid-cols-7 gap-6">
                        <div class="col-span-1">
                            <b><i>{{ __('Product') }}</i></b><br />
                        </div>
                        <div class="col-span-1">
                            <b>{{ $product->code }}</b><br />
                        </div>
                        <div class="col-span-2">
                            {{ $product->description }}
                        </div>
                        <div class="col-span-1">
                            {{ \App\Enums\ProductType::getDescription($product->type) }}
                        </div>
                        <div class="col-span-1">
                            <b>Q.ta:</b> {{ $product->amount }}
                        </div>
                        <div class="col-span-1">
                            <b>Posizione:</b> {{ $product->rack_identifier }}  {{ $product->rack_position }}<br />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr class="mt-1 mb-1 border-black text-center text-2xl"
            data-hr-content="Title"
            style="--bg:white; --p:0 10px; --trans-x:-50%; --trans-y:-50%;"
        />
    @endforeach

    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>

    <script>
        function reprint(){
            document.getElementById("print-button").style.display="none";
            printPage();
        }

        function printPage(){
            window.print();
            setTimeout(
                function(){
                    document.getElementById("print-button").style.display="block";
                },
                100
            );
        }
    </script>
</x-app-layout>
