<?php

namespace App\Http\Controllers;

use App\Enums\PaymentType;
use App\Enums\ProductType;
use App\Enums\RegistryType;
use App\Enums\TireCategory;
use App\Enums\User\CustomerType;
use App\Models\Registry;
use App\Models\Reservation;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;

class EasyFattController extends Controller
{
    public function counter_sale_deposit_reservation(Reservation $reservation)
    {
        if ($reservation->deposit_received_at == null) {
            $reservation->deposit_received_at = now();
            $reservation->save();
        }

        $rows = '<Row>
                  <Code></Code>
                  <Description>Acconto</Description>
                  <Qty>1</Qty>
                  <Um>pz</Um>
                  <Stock>true</Stock>
                  <Price>'.$reservation->deposit.'</Price>
                  <VatCode Perc="22" Class="Imponibile" Description="Aliquota 22%">22</VatCode>
                </Row>';
        $xml = $this->generateMainReservationXML($reservation, 'B', $rows, 'Pneumater prenotazione #'.$reservation->id.' - Acconto');

        return response()
            ->view('layouts.xml', compact('xml'))
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="counter-sale-reservation-'.$reservation->id.'.DefXml"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function counter_sale_reservation(Reservation $reservation)
    {
        $total_price = $reservation->products->sum('price');

        foreach ($reservation->services as $service) {
            if ($service->pivot->price_override) {
                $total_price += $service->pivot->price_override;
            } else {
                $total_price += $service->price;
            }
        }

        foreach ($reservation->tires as $tire) {
            if ($tire->pivot->price_override) {
                $total_price += $tire->pivot->price_override;
            } else {
                $total_price += $tire->price * $tire->amount;
            }
        }

        $discount = $total_price - $reservation->price;

        $rows = $this->generateTiresXML($reservation->tires).$this->generateProductsXML($reservation->products).$this->generateServicesXML($reservation->services).$this->generateDiscountXML($discount);
        $xml = $this->generateMainReservationXML($reservation, 'B', $rows, 'Pneumater prenotazione #'.$reservation->id);

        return response()
            ->view('layouts.xml', compact('xml'))
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="counter-sale-reservation-'.$reservation->id.'.DefXml"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function invoice_reservation(Reservation $reservation)
    {
        $total_price = $reservation->products->sum('price');

        foreach ($reservation->services as $service) {
            if ($service->pivot->price_override) {
                $total_price += $service->pivot->price_override;
            } else {
                $total_price += $service->price;
            }
        }

        foreach ($reservation->tires as $tire) {
            $total_price += $tire->price * $tire->amount;
        }

        $discount = $total_price - $reservation->price;

        $rows = $this->generateTiresXML($reservation->tires).$this->generateProductsXML($reservation->products).$this->generateServicesXML($reservation->services).$this->generateDiscountXML($discount);
        $xml = $this->generateMainReservationXML($reservation, 'I', $rows, 'Pneumater prenotazione #'.$reservation->id);

        return response()
            ->view('layouts.xml', compact('xml'))
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="invoice-reservation-'.$reservation->id.'.DefXml"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function ddt_shipment()
    {
        $shipments = Shipment::find(request()->get('shipments', []));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <EasyfattDocuments AppVersion="2" Creator="Danea Soft" CreatorUrl="www.danea.it">
          <Documents>';

        if (is_a($shipments, 'Illuminate\Database\Eloquent\Collection')) {
            foreach ($shipments as $shipment) {
                $xml .= $this->generateDocumentShipmentXML($shipment, 'D');
            }
        } else {
            $xml .= $this->generateDocumentShipmentXML($shipments, 'D');
        }

        $xml .= '</Documents>
        </EasyfattDocuments>';

        return response()
            ->view('layouts.xml', compact('xml'))
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="ddt-reservation-'.now()->format('Y_m_d-H_i_s').'.DefXml"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function invoice_shipment()
    {
        $shipments = Shipment::find(request()->get('shipments', []));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <EasyfattDocuments AppVersion="2" Creator="Danea Soft" CreatorUrl="www.danea.it">
          <Documents>';

        if (is_a($shipments, 'Illuminate\Database\Eloquent\Collection')) {
            foreach ($shipments as $shipment) {
                $xml .= $this->generateDocumentShipmentXML($shipment, 'I');
            }
        } else {
            $xml .= $this->generateDocumentShipmentXML($shipments, 'I');
        }

        $xml .= '</Documents>
        </EasyfattDocuments>';

        return response()
            ->view('layouts.xml', compact('xml'))
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="invoice-shipment-'.now()->format('Y_m_d-H_i_s').'.DefXml"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    private function generateDocumentShipmentXML($shipment, $document_type)
    {
        $total_price = $shipment->products->sum('price');

        foreach ($shipment->tires as $tire) {
            $total_price += ($tire->pivot->price_override ?? $tire->price * $tire->amount);
        }

        $discount = $total_price - $shipment->price;

        $rows = $this->generateTiresXML($shipment->tires).$this->generateProductsXML($shipment->products).$this->generateDiscountXML($discount);

        $note = '';

        if ($shipment->contextual_pickup) {
            $note .= ($note != '' ? ' | ' : '').'Fare ritiro contestuale';
        }
        if ($shipment->stationary_storage) {
            $note .= ($note != '' ? ' | ' : '').'Fermo deposito';
        }
        if ($shipment->to_invoice) {
            $note .= ($note != '' ? ' | ' : '').'Da fatturare';
        }

        if ($shipment->createdBy->isA('customer') && $shipment->createdBy->customer_type == CustomerType::Dropshipping && $shipment->created_by != auth()->id()) {
            $registry_dropshipping = $shipment->createdBy->registry;
        } else {
            $registry_dropshipping = null;
        }

        if ($document_type == 'I' && $shipment->ddt_number != null) {
            $row_prenote = '<Row>
              <Code></Code>
              <Description>** Rif. Doc. di trasporto N° '.$shipment->ddt_number.' del '.$shipment->ddt_date->format('d/m/Y').'</Description>
              <Qty></Qty>
              <Um></Um>
              <Price></Price>
              <Discounts></Discounts>
              <VatCode Perc="20" Class="Imponibile" Description="Aliquota 20%"></VatCode>
              <Notes></Notes>
            </Row>';
        } else {
            $row_prenote = '';
        }

        $xml = '<Document>
          <DocumentType>'.$document_type.'</DocumentType>
          '.$this->generateCustomerXML($shipment->registry, $registry_dropshipping).'
          <Date>'.now()->format('Y-m-d').'</Date>
          <Numbering>/A</Numbering>
          <PaymentName>'.PaymentType::getEasyFattName($shipment->payment_type).'</PaymentName>
          <NumOfPieces>'.$shipment->packages.'</NumOfPieces>
          <TransportedWeight>'.$shipment->packages * 15 .'</TransportedWeight>
          <InternalComment>'.$note.'</InternalComment>
          <CustomField4>Pneumater spedizione #'.$shipment->id.'</CustomField4>
          <PricesIncludeVat>true</PricesIncludeVat>
          <Rows>
            '.$row_prenote.$rows.'
           </Rows>
          <Payments>
            <Payment>
              <Advance>false</Advance>
              <Date>'.now()->format('Y-m-d').'</Date>
              <Amount>'.$shipment->price.'</Amount>
              <Paid>true</Paid>
            </Payment>
          </Payments>
        </Document>';

        return $xml;
    }

    private function generateMainReservationXML($reservation, $document_type, $rows, $note)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <EasyfattDocuments AppVersion="2" Creator="Danea Soft" CreatorUrl="www.danea.it">
          <Documents>
            <Document>
              <DocumentType>'.$document_type.'</DocumentType>
              '.$this->generateCustomerXML($reservation->registry).'
              <Date>'.now()->format('Y-m-d').'</Date>
              <Numbering>/A</Numbering>
              <PaymentName>'.PaymentType::getEasyFattName($reservation->payment_type).'</PaymentName>
              <CustomField4>'.$note.'</CustomField4>
              <PricesIncludeVat>true</PricesIncludeVat>
              <Rows>
                '.$rows.'
               </Rows>
          <Payments>
            <Payment>
              <Advance>false</Advance>
              <Date>'.now()->format('Y-m-d').'</Date>
              <Amount>'.$reservation->price.'</Amount>';
        if ($reservation->payed) {
            $xml .= '<Paid>true</Paid>';
        } else {
            $xml .= '<Paid>false</Paid>';
        }
        $xml .= '</Payment>
          </Payments>
            </Document>
          </Documents>
        </EasyfattDocuments>';

        return $xml;
    }

    private function generateCustomerXML(Registry $registry = null, $registry_dropshipper = null)
    {
        $xml = '';

        if ($registry) {
            $xml .= '<CustomerName>';
            if ($registry_dropshipper) {
                $xml .= mb_convert_encoding(htmlspecialchars($registry_dropshipper->type == RegistryType::COMPANY ? $registry_dropshipper->denomination : $registry_dropshipper->name.' '.$registry_dropshipper->surname, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252');
            } else {
                $xml .= mb_convert_encoding(htmlspecialchars($registry->type == RegistryType::COMPANY ? $registry->denomination : $registry->name.' '.$registry->surname, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252');
            }
            $xml .= '</CustomerName>';
            if ($registry_dropshipper && $registry_dropshipper->address) {
                $xml .= '<CustomerAddress>'.mb_convert_encoding(htmlspecialchars($registry_dropshipper->address, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252').'</CustomerAddress>';
            } elseif ($registry->address) {
                $xml .= '<CustomerAddress>'.mb_convert_encoding(htmlspecialchars($registry->address, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252').'</CustomerAddress>';
            }
            if ($registry_dropshipper && $registry_dropshipper->postal_code) {
                $xml .= '<CustomerPostcode>'.$registry_dropshipper->postal_code.'</CustomerPostcode>';
            } elseif ($registry->postal_code) {
                $xml .= '<CustomerPostcode>'.$registry->postal_code.'</CustomerPostcode>';
            }
            if ($registry_dropshipper && $registry_dropshipper->city) {
                $xml .= '<CustomerCity>'.htmlspecialchars($registry_dropshipper->city, ENT_NOQUOTES, 'Windows-1252').'</CustomerCity>';
            } elseif ($registry->city) {
                $xml .= '<CustomerCity>'.htmlspecialchars($registry->city, ENT_NOQUOTES, 'Windows-1252').'</CustomerCity>';
            }
            if ($registry_dropshipper && $registry_dropshipper->province) {
                $xml .= '<CustomerProvince>'.$registry_dropshipper->province.'</CustomerProvince>';
            } elseif ($registry->province) {
                $xml .= '<CustomerProvince>'.$registry->province.'</CustomerProvince>';
            }
            if ($registry_dropshipper && $registry_dropshipper->nation) {
                $xml .= '<CustomerCountry>'.$registry_dropshipper->nation.'</CustomerCountry>';
            } elseif ($registry->nation) {
                $xml .= '<CustomerCountry>'.$registry->nation.'</CustomerCountry>';
            }
            if ($registry_dropshipper && $registry_dropshipper->fiscal_code) {
                $xml .= '<CustomerFiscalCode>'.$registry_dropshipper->fiscal_code.'</CustomerFiscalCode>';
            } elseif ($registry->fiscal_code) {
                $xml .= '<CustomerFiscalCode>'.$registry->fiscal_code.'</CustomerFiscalCode>';
            }
            if ($registry_dropshipper && $registry_dropshipper->vat_number) {
                $xml .= '<CustomerVatCode>'.$registry_dropshipper->vat_number.'</CustomerVatCode>';
            } elseif ($registry->vat_number) {
                $xml .= '<CustomerVatCode>'.$registry->vat_number.'</CustomerVatCode>';
            }
            if ($registry_dropshipper && $registry_dropshipper->sdi) {
                $xml .= '<CustomerEInvoiceDestCode>'.$registry_dropshipper->sdi.'</CustomerEInvoiceDestCode>';
            } elseif ($registry->sdi) {
                $xml .= '<CustomerEInvoiceDestCode>'.$registry->sdi.'</CustomerEInvoiceDestCode>';
            }
            if ($registry->phone) {
                $xml .= '<CustomerTel>'.$registry->phone.'</CustomerTel>';
            }
            if ($registry->cellular) {
                $xml .= '<CustomerCellPhone>'.$registry->cellular.'</CustomerCellPhone>';
            }
            if ($registry->email) {
                $xml .= '<CustomerEmail>'.$registry->email.'</CustomerEmail>';
            }
            if ($registry->is_shipment_on_different_location) {
                $xml .= '<DeliveryName>'.mb_convert_encoding(htmlspecialchars($registry->denomination_shipment, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252').'</DeliveryName>';

                if ($registry->address_shipment) {
                    $xml .= '<DeliveryAddress>'.mb_convert_encoding(htmlspecialchars($registry->address_shipment, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252').'</DeliveryAddress>';
                }
                if ($registry->postal_code_shipment) {
                    $xml .= '<DeliveryPostcode>'.$registry->postal_code_shipment.'</DeliveryPostcode>';
                }
                if ($registry->city_shipment) {
                    $xml .= '<DeliveryCity>'.htmlspecialchars($registry->city_shipment, ENT_NOQUOTES, 'Windows-1252').'</DeliveryCity>';
                }
                if ($registry->province_shipment) {
                    $xml .= '<DeliveryProvince>'.$registry->province_shipment.'</DeliveryProvince>';
                }
                if ($registry->nation_shipment) {
                    $xml .= '<DeliveryCountry>'.$registry->nation_shipment.'</DeliveryCountry>';
                }
            } elseif ($registry_dropshipper) {
                $xml .= '<DeliveryName>'.mb_convert_encoding(htmlspecialchars($registry->type == RegistryType::COMPANY ? $registry->denomination : $registry->name.' '.$registry->surname, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252').'</DeliveryName>';

                if ($registry->address) {
                    $xml .= '<DeliveryAddress>'.mb_convert_encoding(htmlspecialchars($registry->address, ENT_NOQUOTES, 'Windows-1252'), 'UTF-8', 'Windows-1252').'</DeliveryAddress>';
                }
                if ($registry->postal_code) {
                    $xml .= '<DeliveryPostcode>'.$registry->postal_code.'</DeliveryPostcode>';
                }
                if ($registry->city) {
                    $xml .= '<DeliveryCity>'.htmlspecialchars($registry->city, ENT_NOQUOTES, 'Windows-1252').'</DeliveryCity>';
                }
                if ($registry->province) {
                    $xml .= '<DeliveryProvince>'.$registry->province.'</DeliveryProvince>';
                }
                if ($registry->nation) {
                    $xml .= '<DeliveryCountry>'.$registry->nation.'</DeliveryCountry>';
                }
            }
        }

        return $xml;
    }

    private function generateDiscountXML(int $discount)
    {
        $xml = '';

        if ($discount > 0) {
            $xml .= '<Row>';
            $xml .= '<Code></Code>';
            $xml .= '<Description>Sconto</Description>';
            $xml .= '<Stock>true</Stock>';
            $xml .= '<Price>-'.$discount.'</Price>';
            $xml .= '<VatCode Perc="22" Class="Imponibile" Description="Aliquota 22%">22</VatCode>';
            $xml .= '</Row>';
        }

        return $xml;
    }

    private function generateServicesXML(Collection $services)
    {
        $xml = '';

        foreach ($services as $service) {
            if ($service->pivot->amount > 0) {
                $xml .= '<Row>';
                $xml .= '<Code>'.$service->code.'</Code>';
                if ($service->description) {
                    $xml .= '<Description>'.$service->description.'</Description>';
                } else {
                    $xml .= '<Description>'.$service->name.'</Description>';
                }
                $xml .= '<Qty>'.$service->pivot->amount.'</Qty>';
                $xml .= '<Um>pz</Um>';
                $xml .= '<Stock>true</Stock>';
                if ($service->pivot->price_override) {
                    $xml .= '<Price>'.$service->pivot->price_override / $service->pivot->amount.'</Price>';
                } else {
                    $xml .= '<Price>'.$service->price / $service->pivot->amount.'</Price>';
                }
                $xml .= '<VatCode Perc="22" Class="Imponibile" Description="Aliquota 22%">22</VatCode>';
                $xml .= '</Row>';
            }
        }

        return $xml;
    }

    private function generateProductsXML(Collection $products)
    {
        $xml = '';

        foreach ($products as $product) {
            $xml .= '<Row>';
            if ($product->type == ProductType::USED_TIRE) {
                $xml .= '<Code>PU</Code>';
            } else {
                $xml .= '<Code>'.$product->code.'</Code>';
            }

            if ($product->type == ProductType::USED_TIRE) {
                $xml .= '<Description>PNEUMATICI USATI DESTINATI AL RIUTILIZZO TALI E QUALI</Description>';
            } else {
                $xml .= '<Description>'.$product->description.'</Description>';
            }

            $xml .= '<Qty>'.$product->amount.'</Qty>';
            $xml .= '<Um>pz</Um>';
            $xml .= '<Stock>true</Stock>';
            $xml .= '<Price>'.($product->price / $product->amount) - $product->pfu_contribution.'</Price>';
            if ($product->pfu_contribution != 0) {
                $xml .= '<EcoFee>'.$product->pfu_contribution.'</EcoFee>';
            }
            $xml .= '<VatCode Perc="22" Class="Imponibile" Description="Aliquota 22%">22</VatCode>';
            $xml .= '</Row>';
        }

        return $xml;
    }

    private function generateTiresXML(Collection $tires)
    {
        $xml = '';

        foreach ($tires as $tire) {
            $xml .= '<Row>';
            if ($tire->category == TireCategory::NEW || $tire->category == TireCategory::NEW_EXTRA) {
                $xml .= '<Code>'.$tire->ean.'</Code>';
            } else {
                $xml .= '<Code>PU</Code>';
            }

            if ($tire->category == TireCategory::NEW || $tire->category == TireCategory::NEW_EXTRA) {
                $xml .= '<Description>'.$tire->description.'</Description>';
            } elseif ($tire->category == TireCategory::NEW_AGED) {
                $xml .= '<Description>'.$tire->width.(($tire->profile != 0) ? ' '.$tire->profile : '').' R '.$tire->diameter.($tire->is_commercial == 1 ? 'C' : '').' '.strtoupper($tire->brand).' '.strtoupper($tire->type->name).'</Description>';
            } else {
                $xml .= '<Description>PNEUMATICI USATI DESTINATI AL RIUTILIZZO TALI E QUALI</Description>';
            }
            $xml .= '<Qty>'.$tire->amount.'</Qty>';
            $xml .= '<Um>pz</Um>';
            $xml .= '<Stock>true</Stock>';
            if ($tire->pivot->price_override) {
                $xml .= '<Price>'.($tire->pivot->price_override - (($tire->pfu_contribution ?: 0) * $tire->amount)) / $tire->amount.'</Price>';
            } else {
                $xml .= '<Price>'.$tire->price - ($tire->pfu_contribution ?: 0).'</Price>';
            }
            if ($tire->category == TireCategory::NEW || $tire->category == TireCategory::NEW_EXTRA) {
                $xml .= '<EcoFee>'.$tire->pfu_contribution.'</EcoFee>';
            }
            $xml .= '<VatCode Perc="22" Class="Imponibile" Description="Aliquota 22%">22</VatCode>';
            $xml .= '</Row>';
        }

        return $xml;
    }
}
