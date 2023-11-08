<?php

namespace App\Http\Controllers;

use App\Enums\Couriers;
use App\Enums\PaymentType;
use App\Enums\RegistryRoleType;
use App\Enums\RegistryType;
use App\Enums\ShipmentStatus;
use App\Enums\Shop;
use App\Enums\TireStatus;
use App\Models\Registry;
use App\Models\Shipment;
use App\Models\ShopListing;
use App\Models\Tire;
use App\Models\User;
use DOMDocument;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EbayController extends Controller
{
    /**
     * @return mixed
     */
    private static function getAuthToken()
    {
        return auth()->user()->isA('customer') ? auth()->user()->ebay_auth_token : User::first()->ebay_auth_token;
    }

    /**
     * Generate request header
     *
     * @return string[]
     */
    private static function generateRequestHeader($call_name)
    {
        $headers = [
            'X-EBAY-API-COMPATIBILITY-LEVEL: '.config('ebay.compat_level'),
            'X-EBAY-API-DEV-NAME: '.config('ebay.dev_id'),
            'X-EBAY-API-APP-NAME: '.config('ebay.app_id'),
            'X-EBAY-API-CERT-NAME: '.config('ebay.cert_id'),
            'X-EBAY-API-CALL-NAME: '.$call_name,
            'X-EBAY-API-SITEID: '.config('ebay.site_id'),
        ];

        return $headers;
    }

    /**
     * Send request to eBay and return responses
     *
     * @return bool|string
     */
    private static function commitRequest($headers, $xml_request)
    {
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, 'https://api.ebay.com/ws/api.dll');
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($connection, CURLOPT_POST, 1);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        curl_close($connection);

        return $response;
    }

    /**
     * Get ebay time
     *
     * @return string
     */
    public static function getTime()
    {
        $call_name = 'GeteBayOfficialTime';

        $headers = self::generateRequestHeader($call_name);

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8" ?>
											<'.$call_name.'Request xmlns="urn:ebay:apis:eBLBaseComponents">
												<RequesterCredentials>
													<eBayAuthToken>'.self::getAuthToken().'</eBayAuthToken>
												</RequesterCredentials>
											</'.$call_name.'Request>';

        $response = self::commitRequest($headers, $xml_request);

        //Parsing XML to retrive value
        $dom = new DOMDocument();
        $dom->loadXML($response); // Parse data accordingly.
        $ack = $dom->getElementsByTagName('Ack')->length > 0 ? $dom->getElementsByTagName('Ack')->item(0)->nodeValue : '';
        $eBay_official_time = $dom->getElementsByTagName('Timestamp')->length > 0 ? $dom->getElementsByTagName('Timestamp')->item(0)->nodeValue : '';

        return $eBay_official_time;
    }

    public static function getItemSellEnd($item_id)
    {
        $call_name = 'GetItem';

        $headers = self::generateRequestHeader($call_name);

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8" ?>
											<'.$call_name.'Request xmlns="urn:ebay:apis:eBLBaseComponents">
												<RequesterCredentials>
													<eBayAuthToken>'.self::getAuthToken().'</eBayAuthToken>
												</RequesterCredentials>
												<ItemID>'.$item_id.'</ItemID>
											</'.$call_name.'Request>';

        $response = self::commitRequest($headers, $xml_request);

        //Parsing XML to retrive value
        $dom = new DOMDocument();
        $dom->loadXML($response); // Parse data accordingly.

        $ack = $dom->getElementsByTagName('Ack')->length > 0 ? $dom->getElementsByTagName('Ack')->item(0)->nodeValue : '';

        if ($ack == 0) {
            $endtime = $dom->getElementsByTagName('EndTime')->item(0)->nodeValue;
        } else {
            throw new Exception('Something wrong with eBay reply', 400);
        }

        return date('d-m-Y H:i:s', strtotime($endtime));
    }

    public static function getEbayDetails()
    {
        $call_name = 'GeteBayDetails';

        $headers = self::generateRequestHeader($call_name);

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8" ?>
											<'.$call_name.'Request xmlns="urn:ebay:apis:eBLBaseComponents">
												<RequesterCredentials>
													<eBayAuthToken>'.self::getAuthToken().'</eBayAuthToken>
												</RequesterCredentials>
											</'.$call_name.'Request>';

        $response = self::commitRequest($headers, $xml_request);

        return self::parseXml($response);
    }

    /**
     * @return mixed
     */
    public static function getEbayCategories()
    {
        $call_name = 'GetCategories';

        $headers = self::generateRequestHeader($call_name);

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8" ?>
											<'.$call_name.'Request xmlns="urn:ebay:apis:eBLBaseComponents">
												<RequesterCredentials>
													<eBayAuthToken>'.self::getAuthToken().'</eBayAuthToken>
												</RequesterCredentials>
												<CategoryParent>131090</CategoryParent>
												<eBayAuthToken>101</eBayAuthToken>
												<DetailLevel>ReturnAll</DetailLevel>
											</'.$call_name.'Request>';

        $response = self::commitRequest($headers, $xml_request);

        return self::parseXml($response);
    }

    public static function endItem(ShopListing $listing)
    {
        /**
         * Call to EndItem eBay API
         * Reference: http://developer.ebay.com/Devzone/XML/docs/Reference/ebay/EndItem.html
         */
        $headers = self::generateRequestHeader('EndItem');

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8" ?>
							<EndItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
							<RequesterCredentials>
								<eBayAuthToken>'.$listing->user->ebay_auth_token.'</eBayAuthToken>
							</RequesterCredentials>
							<ItemID>'.$listing->listing_id.'</ItemID>
							<EndingReason>NotAvailable</EndingReason>
							</EndItemRequest>';

        $response = self::commitRequest($headers, $xml_request);

        //Parsing XML to retrive value
        $dom = new DOMDocument();
        $dom->loadXML($response);
        //Checking if request is accepted correctly
        $ack = $dom->getElementsByTagName('Ack')->length > 0 ? $dom->getElementsByTagName('Ack')->item(0)->nodeValue : '';

        if ($ack == 'Success') {
            $listing->delete();
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public static function isTireSold(Tire $tire)
    {
        $shopListings = ShopListing::where('tire_id', $tire->id)->get();
        $isSold = false;

        foreach ($shopListings as $shopListing) {
            $item_reponse = self::getItem($shopListing);

            if ($item_reponse->Ack != 'Success') {
                return false;
            }

            $isSold = $item_reponse->Item->SellingStatus->ListingStatus == 'Completed' ? true : false;

            if ($isSold) {
                break;
            }
        }

        return $isSold;
    }

    public static function checkItemSellingStatus(ShopListing $shopListing)
    {
        $item_reponse = self::getItem($shopListing);

        if ($item_reponse->Ack != 'Success') {
            return false;
        }

        $sold = $item_reponse->Item->SellingStatus->ListingStatus == 'Completed';

        if ($sold) {
            // Retriving buyer details
            $transaction_response = self::getItemTransaction($shopListing);

            if ($transaction_response->Ack != 'Success') {
                return false;
            }

            //TODO: Filter out TransactionArray > Transaction[0] > Buyer | BuyerInfo > ShippingAddress

            if (count($transaction_response->TransactionArray) > 0) {
                $buyer = $transaction_response->TransactionArray->Transaction[0]->Buyer;
                $note = (string) $transaction_response->TransactionArray->Transaction[0]->BuyerCheckoutMessage;
                $registry = Registry::where('email', (string) $buyer->Email)->where('cellular', $buyer->BuyerInfo->ShippingAddress->Phone)->first();

                if (! $registry) {
                    $last_registry = Registry::orderBy('id', 'desc')->first();

                    $registry = new Registry();
                    $registry->fill([
                        'role' => RegistryRoleType::CUSTOMER,
                        'type' => RegistryType::PRIVATE,
                        'code' => $last_registry ? 'PN-'.$last_registry->id + 1 : 'PN-1',
                        'name' => $buyer->UserFirstName,
                        'surname' => $buyer->UserLastName,
                        'address' => $buyer->BuyerInfo->ShippingAddress->Street1,
                        'city' => $buyer->BuyerInfo->ShippingAddress->CityName,
                        'postal_code' => (string) $buyer->BuyerInfo->ShippingAddress->PostalCode,
                        'province' => $buyer->BuyerInfo->ShippingAddress->StateOrProvince,
                        'region' => '-',
                        'nation' => $buyer->BuyerInfo->ShippingAddress->CountryName,
                        'is_shipment_on_different_location' => false,
                        'cellular' => $buyer->BuyerInfo->ShippingAddress->Phone,
                        'email' => (string) $buyer->Email,
                        'note' => 'Generato automaticamente da eBay',
                    ]);
                    $registry->created_by = auth()->user() ? auth()->user()->id : User::first()->id;
                    $registry->save();
                }

                $estimated_departure = new Carbon();
                if ($estimated_departure->dayOfWeek == Carbon::SATURDAY || $estimated_departure->dayOfWeek == Carbon::SUNDAY) {
                    $estimated_departure = $estimated_departure->next('Monday');
                } else {
                    $estimated_departure = date('H') < '14' ? Carbon::today() : Carbon::tomorrow();
                }

                $shipment = Shipment::where('registry_id', $registry->id)->where(function ($query) {
                    $query->where('status', ShipmentStatus::ToBeConfirmed)
                        ->orWhere('status', ShipmentStatus::Confirmed);
                })->first();

                if (! $shipment) {
                    $shipment = new Shipment();
                    $shipment->fill([
                        'registry_id' => $registry->id,
                        'source' => 'Ebay Automation',
                        'estimated_departure' => $estimated_departure,
                        'payment_type' => PaymentType::BankTransfer,
                        'note' => $note != '' ? $note.' | ' : '',
                        'price' => floatval($transaction_response->TransactionArray->Transaction[0]->TransactionPrice),
                        'deposit' => 0,
                        'packages' => 0,
                        'contextual_pickup' => false,
                        'stationary_storage' => false,
                        'to_invoice' => false,
                        'is_confirmation_needed' => true,
                        'courier' => Couriers::BRT,
                    ]);
                    $shipment->created_by = auth()->user() ? auth()->user()->id : User::first()->id;
                    $shipment->status = ShipmentStatus::Confirmed;
                } else {
                    $shipment->note = ($note != '' ? $note.' | ' : '').($shipment->note != '' ? ' | '.$shipment->note : '');
                    $shipment->price += floatval($transaction_response->TransactionArray->Transaction[0]->TransactionPrice);
                    $shipment->is_confirmation_needed = true;
                }
                $shipment->save();

                $tire = $shopListing->tire;

                // removing tire form all shops
                if ($tire->listings()->where('shop', Shop::Subito)->count() > 0) {
                    $tire->listings()->where('shop', Shop::Subito)->delete();
                }

                $tire->removeAllFromEbay();
                $tire->save();

                $tire->status = TireStatus::ToShip;
                $shipment->tires()->attach([$tire->id], ['price_override' => $shipment->price, 'ebay_listing_id' => $shopListing->listing_id, 'ebay_listing_user_id' => $shopListing->user_id]);
                $shipment->recalculatePackages();

                $tire->save();
            }
        }

        return true;
    }

    public static function getItem(ShopListing $listing)
    {
        /**
         * Call to GetItem eBay API
         * Reference: http://developer.ebay.com/Devzone/XML/docs/Reference/ebay/GetItem.html
         */
        $headers = self::generateRequestHeader('GetItem');

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8"?>
							<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
								<RequesterCredentials>
									<eBayAuthToken>'.$listing->user->ebay_auth_token.'</eBayAuthToken>
								</RequesterCredentials>
								<ItemID>'.$listing->listing_id.'</ItemID>
							</GetItemRequest>';

        $response = self::commitRequest($headers, $xml_request);

        return simplexml_load_string($response);
    }

    public static function getItemTransaction(ShopListing $listing)
    {
        /**
         * Call to GetItem eBay API
         * Reference: http://developer.ebay.com/Devzone/XML/docs/Reference/ebay/GetItem.html
         */
        $headers = self::generateRequestHeader('GetItemTransactions');

        // Generate XML request
        $xml_request = '<?xml version="1.0" encoding="utf-8"?>
							<GetItemTransactionsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
								<RequesterCredentials>
									<eBayAuthToken>'.$listing->user->ebay_auth_token.'</eBayAuthToken>
								</RequesterCredentials>
								<ItemID>'.$listing->listing_id.'</ItemID>
							</GetItemTransactionsRequest>';

        $response = self::commitRequest($headers, $xml_request);

        return simplexml_load_string($response);
    }

    public static function sellItem($tire, $debug = false)
    {
        /**
         * Call to AddFixerdPriceItem eBay API
         * Reference: http://developer.ebay.com/Devzone/XML/docs/Reference/ebay/AddFixedPriceItem.html
         */
        $headers = self::generateRequestHeader('AddFixedPriceItem');

        $xml_request = '<?xml version="1.0" encoding="utf-8"?>
							<AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
							<RequesterCredentials>
								<eBayAuthToken>'.self::getAuthToken().'</eBayAuthToken>
							</RequesterCredentials>
							<ErrorLanguage>it_IT</ErrorLanguage>
							<WarningLevel>High</WarningLevel>
							<Item>
								<ApplicationData>Pneumater-'.$tire->id.'</ApplicationData>
								<ConditionID>3000</ConditionID>
								<ItemSpecifics>
									<NameValueList>
										<Name>Indice di carico</Name>
										<Value>'.$tire->load_index.'</Value>
									</NameValueList>
									<NameValueList>
										<Name>Larghezza pneumatico</Name>
										<Value>'.$tire->width."</Value>
									</NameValueList>
									<NameValueList>
										<Name>Rapporto d'aspetto</Name>
										<Value>".$tire->profile.'</Value>
									</NameValueList>
									<NameValueList>
										<Name>Indice di velocità</Name>
										<Value>'.$tire->speed_index.'</Value>
									</NameValueList>
									<NameValueList>
										<Name>Diametro</Name>
										<Value>'.$tire->diameter.'</Value>
									</NameValueList>
									<NameValueList>
										<Name>Marca</Name>
										<Value>'.$tire->brand.'</Value>
									</NameValueList>
									<NameValueList>
										<Name>Stagione</Name>
										<Value>'.$tire->type->name.'</Value>
									</NameValueList>
									<NameValueList>
										<Name>MPN</Name>
										<Value>'.$tire->id.'</Value>
									</NameValueList>';
        if ($tire->category == 3) {
            $xml_request .= '<NameValueList>
                                <Name>Quantità</Name>
                                <Value>'.intval($tire->amount / 2).'</Value>
                            </NameValueList>';
        } else {
            $xml_request .= '<NameValueList>
                                <Name>Quantità</Name>
                                <Value>1</Value>
                            </NameValueList>';
        }

        $xml_request .= '</ItemSpecifics>
								<Title>'.substr($tire->getEbayTitle(), 0, 80).'</Title>
								<Description><![CDATA['.$tire->getUniversalDescription().']]>
								</Description>
								<PrimaryCategory>
									<CategoryID>179680</CategoryID>
								</PrimaryCategory>
								<StartPrice currencyID="EUR">'.$tire->price_ebay.'</StartPrice>
								<CategoryMappingAllowed>true</CategoryMappingAllowed>
								<Country>IT</Country>
								<Currency>EUR</Currency>
								<DispatchTimeMax>3</DispatchTimeMax>
								<ListingDuration>GTC</ListingDuration>
								<ListingType>FixedPriceItem</ListingType>
								<PictureDetails>
									<GalleryType>Gallery</GalleryType>';

        //Obtaining and adding photo to xml request
        foreach ($tire->photos as $photo) {
            $xml_request .= '<PictureURL>'.config('app.url').Storage::url($photo->path).'</PictureURL>';
        }

        $xml_request .= '</PictureDetails>
								<PostalCode>61121</PostalCode>
								<Location>Montecchio di Vallefoglia</Location>';

        if ($tire->category == 3) {
            $xml_request .= '<Quantity>'.intval($tire->amount / 2).'</Quantity>
                              <LotSize>2</LotSize>';
        } else {
            $xml_request .= '<Quantity>1</Quantity>
                             <LotSize>'.$tire->amount.'</LotSize>';
        }

        $xml_request .= '<ProductListingDetails>
                                  <BrandMPN>
                                    <Brand>'.$tire->brand.'</Brand>
                                    <MPN>'.$tire->id.'</MPN>
                                  </BrandMPN>
                              </ProductListingDetails>
                              <ReturnPolicy>
									<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
									<ReturnsWithinOption>Days_14</ReturnsWithinOption>
									<Description>Obbligo di ricevuta/fattura per il rimborso e segnalazione problema</Description>
									<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>
								</ReturnPolicy>
								<ShippingDetails>
									<ShippingType>Flat</ShippingType>
									<CODCost currencyID="EUR">0.00</CODCost>
									<ShippingServiceOptions>
										<ShippingServicePriority>1</ShippingServicePriority>
										<ShippingService>IT_QuickPackage1</ShippingService>
										<ShippingServiceCost>0.00</ShippingServiceCost>
									</ShippingServiceOptions>
								</ShippingDetails>
								<Site>Italy</Site>
							</Item>
							</AddFixedPriceItemRequest>';

        $response = self::commitRequest($headers, $xml_request);
        if ($debug) {
            ddd($response);
        }

        //Parsing XML to retrive value
        $dom = new DOMDocument();
        $dom->loadXML($response);
        //Checking if request is accepted correctly
        $ack = $dom->getElementsByTagName('Ack')->length > 0 ? $dom->getElementsByTagName('Ack')->item(0)->nodeValue : '';

        if ($ack != 'Failure') {
            //Retriving ItemID from eBay Response
            $ebay_item_id = $dom->getElementsByTagName('ItemID')->length > 0 ? $dom->getElementsByTagName('ItemID')->item(0)->nodeValue : null;
        } else {
            $ebay_item_id = null;
        }

        if ($ebay_item_id != null) {
            ShopListing::create(
                [
                    'tire_id' => $tire->id,
                    'shop' => Shop::Ebay,
                    'listing_id' => $ebay_item_id,
                    'user_id' => auth()->user()->isA('customer') ? auth()->user()->id : User::first()->id,
                ]
            );
        }

        return $ebay_item_id;
    }

    private static function parseXml($xml)
    {
        return str_replace('>', '] ', str_replace('<', ' [', $xml));
    }

    public static function updateItemTrackingCode(Shipment $shipment)
    {
        /**
         * Call to CompleteSaleRequest eBay API
         * Reference: https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/CompleteSale.html
         */
        foreach ($shipment->tires as $tire) {
            if ($tire->pivot->ebay_listing_id && $tire->pivot->ebay_listing_user_id) {
                $user = User::find($tire->pivot->ebay_listing_user_id);
                $headers = self::generateRequestHeader('CompleteSale');

                // Generate XML request
                $xml_request = '<?xml version="1.0" encoding="utf-8"?>
                            <CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <RequesterCredentials>
									<eBayAuthToken>'.$user->ebay_auth_token.'</eBayAuthToken>
								</RequesterCredentials>
                                <ItemID>'.$tire->pivot->ebay_listing_id.'</ItemID>
                                <Shipment>
                                    <ShipmentTrackingDetails>
                                        <ShipmentTrackingNumber>'.$shipment->tracking_code.'</ShipmentTrackingNumber>
                                        <ShippingCarrierUsed>'.Couriers::getDescription($shipment->courier).'</ShippingCarrierUsed>
                                    </ShipmentTrackingDetails>
                                    <ShippedTime>'.Carbon::now().'</ShippedTime>
                                </Shipment>
                                <Shipped>true</Shipped>
                            </CompleteSaleRequest>';

                $response = self::commitRequest($headers, $xml_request);
            }
        }
    }
}
