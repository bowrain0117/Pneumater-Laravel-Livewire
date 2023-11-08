<x-app-layout>
    <button onclick="reprint()" style="display: none" type="submit"
            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mb-2"
            id="print-button">
        <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path fill-rule="evenodd"
                  d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                  clip-rule="evenodd"/>
        </svg>
    </button>
    @foreach($shipments as $shipment)
        <div class="grid grid-cols-5 gap-6 divide-black">
            <div class="col-span-2">
                <div class="grid grid-cols-4 gap-6">
                    <div class="col-span-1">
                        <b>#{{ $shipment->id }}</b>
                    </div>
                    <div class="col-span-1">
                        @if($shipment->registry && $shipment->registry->type == \App\Enums\RegistryType::PRIVATE)
                            {{ $shipment->registry->name }} {{ $shipment->registry->surname }}
                        @elseif($shipment->registry && $shipment->registry->type == \App\Enums\RegistryType::COMPANY)
                            {{ $shipment->registry->denomination }}
                        @else
                            {{ $shipment->name }}
                        @endif
                    </div>
                    <div class="col-span-1">
                        @if($shipment->registry)
                            {{ $shipment->registry->phone }}
                            @if($shipment->registry->phone && $shipment->registry->cellular)
                                <br/>
                            @endif
                            {{ $shipment->registry->cellular }}
                        @else
                            {{ $shipment->phone }}
                        @endif
                    </div>
                    <div class="col-span-1">
                        @if($shipment->courier)
                            {{ strtoupper(\App\Enums\Couriers::getDescription($shipment->courier)) }}
                        @else
                            -
                        @endif
                        @if($shipment->payment_type == \App\Enums\PaymentType::CashOnDelivery)
                            <br/><i>Contrassegno</i>
                        @endif
                    </div>
                </div>
                @if($shipment->note)
                    <b>Note:</b> {{ $shipment->note }}<br/>
                @endif
                <b>Colli:</b> {{ $shipment->packages }}
            </div>
            <div class="col-span-3">
                @foreach($shipment->tires as $tire)
                    <div class="grid grid-cols-7 gap-6">
                        <div class="col-span-1">
                            <b><i>{{ __('Tire') }}</i></b><br/>
                        </div>
                        <div class="col-span-1">
                            <b>#{{ $tire->id }}</b><br/>
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
                            <b>Posizione:</b> {{ $tire->rack_identifier }} {{ $tire->rack_position }}<br/>
                        </div>
                    </div>
                @endforeach
                @foreach($shipment->products as $product)
                    <div class="grid grid-cols-7 gap-6">
                        <div class="col-span-1">
                            <b><i>{{ __('Product') }}</i></b><br/>
                        </div>
                        <div class="col-span-1">
                            <b>{{ $product->code }}</b><br/>
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
                            <b>Posizione:</b> {{ $product->rack_identifier }}  {{ $product->rack_position }}<br/>
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
        @page {
            size: landscape;
        }
    </style>

    <script>
        function reprint() {
            document.getElementById("print-button").style.display = "none";
            printPage();
        }

        function printPage() {
            window.print();
            setTimeout(
                function () {
                    document.getElementById("print-button").style.display = "block";
                },
                100
            );
        }
    </script>
</x-app-layout>
