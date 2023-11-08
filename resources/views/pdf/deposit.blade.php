<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Pneumater') }}</title>
</head>
<body>
    <table>
        <tr>
            <td>
                <img width="70%"
                     src="data:image/jpeg;base64,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"
                >
            </td>
            <td>
                <h3 style="margin-bottom: 0px; margin-top: 0px"><b>PNEUMATICI ADRIATICA USATI E NUOVI S.R.L.</b></h3>
                Via Monte Nerone 16 - 61022 Vallefoglia (PU) - Italy<br />
                Tel. 3923026347 / 07211748147 <br />
                e-mail: amministrazione@pneumaticiadriatica.it - PEC: pneumaticiadriatica@certificazioneposta.it<br />
                C.F. / P.IVA: 02662080411
            </td>
        </tr>
    </table>
    <div style="text-align: center">
        <h1>Acconto</h1>
    </div>

    <div style="margin-top: 20px">
        <h2>Dati cliente:</h2>
        <b>Codice cliente</b>: {{ $reservation->registry->code }}<br />
        @if($reservation->registry->type == \App\Enums\RegistryType::PRIVATE)
            <b>Denominazione</b>: {{ $reservation->registry->name }} {{ $reservation->registry->surname }}<br />
        @else
            <b>Denominazione</b>: {{ $reservation->registry->denomination }}<br />
        @endif
    </div>

    <div style="margin-top: 20px">
        <h2>Dati prodotti:</h2>
        @foreach($reservation->tires as $tire)
            #{{ $tire->id }} | {{ $tire->width.(($tire->profile != 0 ) ? " ".$tire->profile : "")." R ".$tire->diameter . ($tire->is_commercial == 1  ? 'C' : '') . " " . strtoupper($tire->brand) }} <br/>
        @endforeach
        @foreach($reservation->products()->where('type', '!=', \App\Enums\ProductType::GENERIC)->get() as $product)
            {{ $product->code }} | {{ $product->description }} <br/>
        @endforeach
        <br />
        <b>Data acconto:</b>  {{ $reservation->deposit_received_at ? $reservation->deposit_received_at->format('d/m/y') : \Carbon\Carbon::now()->format('d/m/y') }}<br />
        <b>Importo:</b> {{ $reservation->deposit }} € <br />
    </div>
</body>
</html>