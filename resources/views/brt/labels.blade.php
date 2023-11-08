@php
    $i = 0;
@endphp

<style>
    @page { margin: 0px; }
    body { margin: 0px; }
</style>

@foreach($shipments as $key => $shipment)
    @foreach($shipment->brtParcels as $parcel)
        @if($i == 0)
            <div style="padding-top: 16.7mm;"></div>
        @endif
        @if ($i % 8 == 0 && $i != 0)
            <div style="page-break-before: always; padding-top: 14.7mm;"></div>
        @endif
        <img src="data:image/jpeg;base64,{{ base64_encode(Storage::get($parcel->label_path_img)) }}" style="width: 43.5%; padding-right: 22px; padding-left: 22px; padding-top: 5.5mm;"/>
        @php
            $i++;
        @endphp
    @endforeach
@endforeach
