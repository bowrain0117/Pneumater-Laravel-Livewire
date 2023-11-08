<!DOCTYPE html>
<html>
    <head>
        <title>Labels Zebra</title>
    </head>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; }
    </style>
    <body>
        @foreach($tires as $tire)
            <center>
                <div style="padding-top:12px; font-weight: bold; font-size: 30pt; border-bottom: solid 1px black">
                    #{{ $tire->id }}
                </div>
                <div style="padding-top: 6px; font-weight: bold; font-size: 30pt; border-bottom: solid 1px black">
                    {{ $tire->width }} {{ $tire->profile }} {{ $tire->diameter != 0 ? $tire->diameter : '' }} {{ $tire->isCommercial ? 'C' : '' }} |
                    {{ strtoupper($tire->load_index) }} {{ strtoupper($tire->speed_index) }}
                </div>
                <div style="font-weight: bold; font-size: 16pt; border-bottom: solid 1px black">
                    {{ strtoupper($tire->brand) }} | {{ strtoupper($tire->model) }}
                </div>
                <div style="font-weight: bold; font-size: 16pt; border-bottom: solid 1px black">
                    {{ strtoupper($tire->type->name) }} | Q.TA {{ $tire->amount }}
                </div>
                <div style="padding-top: 4px;">
                    <img src="data:image/svg+xml;base64,{{ base64_encode($tire->getQrCode()) }}" width="120" height="120" />
                </div>
                <div style="padding-top: 4px;">
                    <img src="imgs/logo.png" style="width: 28px;"/>
                </div>
            </center>
        @endforeach
    </body>
</html>
