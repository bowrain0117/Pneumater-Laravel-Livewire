<style>
    html {
        font-size: 11px;
    }
</style>

@php
    $amount_of_packages = 0;
@endphp

<b>Data Stampa:</b> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}<br/>

<table style="width: 100%">
    <thead style="font-weight: bold; border-top: 1px solid black; border-bottom: 1px dashed black;">
    <tr>
        <td colspan="2">
            Destinatario
        </td>
        <td colspan="2">
            Indirizzo
        </td>
        <td>
        </td>
        <td>
            Rif. Numerico
        </td>
        <td>
            Cod
        </td>
        <td>
            Importo
        </td>
        <td>
            T.I.
        </td>
        <td>
            Importo
        </td>
        <td>
            Colli
        </td>
        <td>
            Peso
        </td>
        <td>
            MC Pallet
        </td>
        <td colspan="2">
            Segnacolli
        </td>
    </tr>
    <tr>
        <td colspan="2">
        </td>
        <td>
            CAP
        </td>
        <td>
            Località
        </td>
        <td>
            LNA
        </td>
        <td>
            Riferimento
        </td>
        <td>
            Boi
        </td>
        <td>
            Assic.
        </td>
        <td>
            c/a
        </td>
        <td>
            C/Assegno
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
            Dal
        </td>
        <td colspan="2">
            Al
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center;">
            Mittente: {{ config('brt.sender_customer_code') }} PNEUMATICI ADRIATICA USATI E NUOVI SRL
        </td>
    </tr>
    @foreach($shipments as $shipment)
        @php
            $amount_of_packages += $shipment->packages;
        @endphp
        <tr>
            <td colspan="2">
                @if ($shipment->registry->is_shipment_on_different_location)
                    {{ strtoupper($shipment->registry->denomination_shipment) }}
                @else
                    @if ($shipment->registry->type == \App\Enums\RegistryType::PRIVATE)
                        {{ strtoupper($shipment->registry->name) }} {{ strtoupper($shipment->registry->surname) }}
                    @else
                        {{ strtoupper($shipment->registry->denomination) }}
                    @endif
                @endif
            </td>
            <td colspan="2">
                @if ($shipment->registry->is_shipment_on_different_location)
                    {{ strtoupper($shipment->registry->address_shipment) }}
                @else
                    {{ strtoupper($shipment->registry->address) }}
                @endif
            </td>
            <td>
                {{ $shipment->brtParcels()->first()->lna }}
            </td>
            <td>
                {{ $shipment->brtParcels()->first()->sender_reference_number }}
            </td>
            <td>
                1
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                @if($shipment->payment_type == \App\Enums\PaymentType::CashOnDelivery)
                    {{ intval($shipment->price) }},00 EUR
                @endif
            </td>
            <td>
                {{ $shipment->packages }}
            </td>
            <td>
                {{ $shipment->packages * 15 }},0
            </td>
            <td>
            </td>
            <td>
                {{ $shipment->brtParcels()->first()->parcel_tracking_number }}
            </td>
            <td>
                {{ $shipment->brtParcels()->orderBy('created_at', 'DESC')->first()->parcel_tracking_number }}
            </td>
        </tr>
        <tr>
            <td>
                Tipo Servizio <b>C</b>
            </td>
            <td>
                Cod.Tar. <b>100</b>
            </td>
            <td colspan="2">
                @if ($shipment->registry->is_shipment_on_different_location)
                    {{ strtoupper($shipment->registry->postal_code_shipment) }} {{ strtoupper($shipment->registry->city_shipment) }}
                    ({{ strtoupper($shipment->registry->province_shipment) }})
                @else
                    {{ strtoupper($shipment->registry->postal_code) }} {{ strtoupper($shipment->registry->city) }}
                    ({{ strtoupper($shipment->registry->province) }})
                @endif
            </td>
            <td>
            </td>
            <td>
                {{ str_pad($shipment->brtParcels()->first()->sender_reference_number,15,'0',STR_PAD_LEFT) }}
            </td>
            <td colspan="9">
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot style="font-weight: bold; border-top: 1px solid black;">
    <tr>
        <td colspan="9"></td>
        <td>Totali:</td>
        <td>{{ $amount_of_packages }}</td>
        <td>{{ $amount_of_packages * 15 }}</td>
        <td></td>
        <td colspan="2">Spedizioni: {{ $shipments->count() }}</td>
    </tr>
    </tfoot>
</table>
