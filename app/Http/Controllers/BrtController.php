<?php

namespace App\Http\Controllers;

use App\Enums\PaymentType;
use App\Enums\RegistryType;
use App\Enums\ShipmentStatus;
use App\Models\BrtParcel;
use App\Models\Shipment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PDF;

class BrtController extends Controller
{
    public static function createShipment(Shipment $shipment): void
    {
        $sender_reference_number = $shipment->id.'00'.rand(1, 999);

        $request = [];
        $request['account'] = [];

        $request['account']['userID'] = config('brt.user_id');
        $request['account']['password'] = config('brt.password');

        $request['createData'] = [];
        $request['createData']['network'] = ' ';
        $request['createData']['departureDepot'] = config('brt.departure_depot');
        $request['createData']['senderCustomerCode'] = config('brt.sender_customer_code');
        $request['createData']['deliveryFreightTypeCode'] = 'DAP';

        if ($shipment->registry->is_shipment_on_different_location) {
            $request['createData']['consigneeCompanyName'] = $shipment->registry->denomination_shipment;
            $request['createData']['consigneeAddress'] = $shipment->registry->address_shipment;
            $request['createData']['consigneeZIPCode'] = $shipment->registry->postal_code_shipment;
            $request['createData']['consigneeCity'] = $shipment->registry->city_shipment;
        } else {
            if ($shipment->registry->type == RegistryType::PRIVATE) {
                $request['createData']['consigneeCompanyName'] = $shipment->registry->name.' '.$shipment->registry->surname;
            } else {
                $request['createData']['consigneeCompanyName'] = $shipment->registry->denomination;
            }

            $request['createData']['consigneeAddress'] = $shipment->registry->address;
            $request['createData']['consigneeZIPCode'] = $shipment->registry->postal_code;
            $request['createData']['consigneeCity'] = $shipment->registry->city;
        }

        $request['createData']['consigneeCountryAbbreviationISOAlpha2'] = 'IT';
        $request['createData']['consigneeTelephone'] = $shipment->registry->phone;
        $request['createData']['consigneeEMail'] = $shipment->registry->email;

        $request['createData']['numberOfParcels'] = $shipment->packages;
        $request['createData']['weightKG'] = $shipment->packages * 15;
        $request['createData']['numericSenderReference'] = $sender_reference_number;

        if ($shipment->payment_type == PaymentType::CashOnDelivery) {
            $request['createData']['cashOnDelivery'] = intval($shipment->price).'.00';
            $request['createData']['isCODMandatory'] = 1;
            $request['createData']['codCurrency'] = 'EUR';
            $request['createData']['codPaymentType'] = ' ';
        } else {
            $request['createData']['isCODMandatory'] = 0;
        }

        if ($shipment->contextual_pickup) {
            $request['createData']['particularitiesDeliveryManagementCode'] = 'RC';
        }

        $request['isLabelRequired'] = 1;
        $request['labelParameters'] = [];
        $request['labelParameters']['outputType'] = 'PDF';

        $response = Http::post('https://api.brt.it/rest/v1/shipments/shipment', $request);

        $json_response = $response->json();
        if ($response->successful() && $json_response['createResponse']['executionMessage']['code'] >= 0) {
            foreach ($json_response['createResponse']['labels']['label'] as $label) {
                Storage::put('public/brt-label/'.$shipment->id.'_'.$label['parcelID'].'.pdf', base64_decode($label['stream']));

                $pdf = new \Spatie\PdfToImage\Pdf('storage/brt-label/'.$shipment->id.'_'.$label['parcelID'].'.pdf');
                $pdf->saveImage('storage/brt-label/'.$shipment->id.'_'.$label['parcelID'].'.jpg');

                BrtParcel::create([
                    'shipment_id' => $shipment->id,
                    'lna' => $label['parcelID'][3].$label['parcelID'][4].$label['parcelID'][5],
                    'sender_reference_number' => $sender_reference_number,
                    'parcel_number' => $label['parcelID'],
                    'parcel_tracking_number' => $label['trackingByParcelID'],
                    'label_path_pdf' => 'public/brt-label/'.$shipment->id.'_'.$label['parcelID'].'.pdf',
                    'label_path_img' => 'public/brt-label/'.$shipment->id.'_'.$label['parcelID'].'.jpg',
                ]);
            }
        }
    }

    public static function trackShipment(BrtParcel $parcel)
    {
        $events = [];

        $response = Http::withHeaders([
            'userID' => config('brt.user_id'),
            'password' => config('brt.password'),
        ])->get('https://api.brt.it/rest/v1/tracking/parcelID/'.$parcel->parcel_tracking_number);

        foreach ($response->json()['ttParcelIdResponse']['lista_eventi'] as $evento) {
            if ($evento['evento']['data'] != '') {
                $event = [];
                $event['date'] = $evento['evento']['data'];
                $event['time'] = $evento['evento']['ora'];
                $event['office'] = $evento['evento']['filiale'];
                $event['description'] = $evento['evento']['descrizione'];

                $events[] = $event;
            }
        }

        return $events;
    }

    public static function deleteShipment(BrtParcel $parcel): void
    {
        $request = [];
        $request['account'] = [];

        $request['account']['userID'] = config('brt.user_id');
        $request['account']['password'] = config('brt.password');

        $request['deleteData'] = [];
        $request['deleteData']['senderCustomerCode'] = config('brt.sender_customer_code');
        $request['deleteData']['numericSenderReference'] = $parcel->sender_reference_number;

        $response = Http::put('https://api.brt.it/rest/v1/shipments/delete', $request);

        if ($response->successful() && $response->json()['deleteResponse']['executionMessage']['code'] == 0) {
            $parcel->shipment->brtParcels()->delete();
        }
    }

    public function labels()
    {
        $shipments = Shipment::where('estimated_departure', Carbon::today())->has('brtParcels')->get();
        $pdf = PDF::loadView('brt.labels', ['shipments' => $shipments]);
        $pdf->setOptions([
            'defaultFont' => 'Helvetica',
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->stream('labels-brt.pdf');
    }

    public function report()
    {
        $shipments = Shipment::where('estimated_departure', Carbon::today())->has('brtParcels')->get();
        $pdf = PDF::loadView('brt.report', ['shipments' => $shipments])->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'defaultFont' => 'Helvetica',
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->stream('print-brt.pdf');
    }

    public function shipDaily()
    {
        $shipments = Shipment::where('estimated_departure', Carbon::today())->where('status', ShipmentStatus::PartiallyProcessed)->doesnthave('brtParcels')->get();
        foreach ($shipments as $shipment) {
            BrtController::createShipment($shipment);
        }

        return redirect()->route('shipments.index');
    }
}
