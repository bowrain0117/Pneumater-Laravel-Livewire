<?php

namespace App\Models;

use App\Enums\Shop;
use App\Enums\TireCategory;
use App\Enums\TireStatus;
use App\Http\Controllers\EbayController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Tire extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'ean',
        'category',
        'millimeters',
        'millimeters_2',
        'millimeters_new_by_manufacturer',
        'width',
        'profile',
        'diameter',
        'brand',
        'model',
        'type_id',
        'load_index',
        'speed_index',
        'is_commercial',
        'dot',
        'advertisement_date',
        'amount',
        'rack_identifier',
        'rack_position',
        'pfu_contribution',
        'discount_immediate_payment',
        'discount_supplier',
        'price',
        'price_discount',
        'number_of_discount',
        'price_list',
        'price_ebay',
        'status',
        'created_by',
        'discount_at',
    ];

    protected $casts = [
        'discount_at' => 'datetime',
    ];

    protected $attributes = [
        'millimeters' => 0,
        'millimeters_2' => 0,
        'millimeters_new_by_manufacturer' => 0,
        'pfu_contribution' => 0,
        'discount_immediate_payment' => 0,
        'discount_supplier' => 0,
        'price' => 0,
        'price_list' => 0,
        'price_ebay' => 0,
        'status' => 1,
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function photos()
    {
        return $this->hasMany(TirePhoto::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class);
    }

    public function listings()
    {
        return $this->hasMany(ShopListing::class);
    }

    public function getPackageWeightAttribute()
    {
        return $this->package_number * 15;
    }

    public function getPriceAttribute($value)
    {
        return $this->price_discount ? $value - $this->price_discount : $value;
    }

    public function getPriceFullAttribute()
    {
        return $this->price_discount ? $this->price + $this->price_discount : $this->price;
    }

    public function getPriceMountedAndShippedAttribute()
    {
        $price = ($this->category != TireCategory::NEW_EXTRA) ? $this->getKijijiPrice() : $this->price_list;
        $amount = $this->amount != 0 ? $this->amount : 1;
        if ($this->category == TireCategory::NEW_EXTRA) {
            $amount = $amount <= 4 ? $amount : 4;
            $amount = $amount == 3 ? 2 : $amount;
        }
        if ($this->category != TireCategory::NEW) {
            $price = $price / $amount;
        }

        return round(
            $price, 0, PHP_ROUND_HALF_DOWN
        );
    }

    /**
     * Sell tire on ebay
     */
    public function sellOnEbay()
    {
        EbayController::sellItem($this);
    }

    /**
     * Remove tire form ebay
     */
    public function removeFromEbay()
    {
        $user_id = auth()->user()->isA('customer') ? auth()->user()->id : User::first()->id;

        $listing = $this->listings()->where('user_id', $user_id)->where('shop', Shop::Ebay)->first();
        if ($listing) {
            EbayController::endItem($listing);
            $listing->delete();
        }
    }

    /**
     * Remove tire form ebay
     */
    public function removeAllFromEbay()
    {
        $listings = $this->listings()->where('shop', Shop::Ebay)->get();
        foreach ($listings as $listing) {
            EbayController::endItem($listing);
            $listing->delete();
        }
    }

    /**
     * Generate seach string to use on search engine for tire price
     */
    public function searchString(): string
    {
        return $this->width.' '.
            (($this->profile != 0) ? ' '.$this->profile.' ' : '').
            $this->diameter.' '.
            ($this->is_commercial == 1 ? 'C ' : '').
            strtoupper($this->brand).' '.
            strtoupper($this->model).' '.
            strtoupper($this->type->name).' '.
            $this->load_index.
            $this->speed_index;
    }

    /**
     * Duplicate photos of current tire to another tire
     */
    public function duplicatePhotos(Tire $target_tire)
    {
        foreach ($this->photos as $photo) {
            $filename = basename($photo->path);
            $filename_splitted = explode('.', $filename);

            $filename_copy = $filename_splitted[0].'_'.Str::random(5).'.'.$filename_splitted[1];

            Storage::copy($photo->path, 'public/tire-photo/'.$filename_copy);

            TirePhoto::create([
                'tire_id' => $target_tire->id,
                'path' => 'public/tire-photo/'.$filename_copy,
            ]);
        }
    }

    public function getEbayTitle(): string
    {
        $string = '';

        if ($this->category == TireCategory::NEW_EXTRA) {
            $amount = $this->amount;
            $amount = $amount <= 4 ? $amount : 4;
            $amount = $amount == 3 ? 2 : $amount;
            $string .= $amount.' PNEUMATICI ';
        } elseif ($this->amount > 1 && $this->category != TireCategory::NEW) {
            $string .= $this->amount.' PNEUMATICI ';
        } elseif ($this->category != TireCategory::NEW) {
            $string .= $this->amount.' PNEUMATICO ';
        } else {
            $string .= '4 PNEUMATICI NUOVI ';
        }

        if ($this->category == 5) {
            $string .= ' NUOVI ';
        }

        $string .= $this->width.(($this->profile != 0) ? ' '.$this->profile : '').' R '.$this->diameter.($this->is_commercial == 1 ? 'C' : '').' ';
        $string .= strtoupper($this->brand).' ';
        $string .= strtoupper($this->type->name).' ';

        if ($this->category == TireCategory::HIGH_PROFILE || $this->category == TireCategory::PROFILE || $this->category == TireCategory::REPAIRED) {
            $string .= 'AL '.$this->calculateMillimeterPercentage().'% GOMME USATE #ADRIATICA';
        } elseif ($this->category == TireCategory::NEW || $this->category == TireCategory::NEW_AGED || $this->category == TireCategory::NEW_EXTRA) {
            $string .= 'GOMME NUOVE #ADRIATICA';
        }

        return $string;
    }

    public function getKijijiTitle(): string
    {
        $string = '';

        if ($this->category == TireCategory::NEW) {
            $string .= 'Gomme NUOVE ';
        } elseif ($this->category == TireCategory::NEW_EXTRA) {
            $amount = $this->amount;
            $amount = $amount <= 4 ? $amount : 4;
            $amount = $amount == 3 ? 2 : $amount;
            $string .= $amount.' Gomme NUOVE ';
        } else {
            if ($this->amount > 1) {
                $string .= $this->amount.' Gomme ';
            } else {
                $string .= $this->amount.' Gomma ';
            }
        }

        if ($this->category == TireCategory::NEW_AGED) {
            $string .= ' NUOVE ';
        }

        $string .= $this->width.(($this->profile != 0) ? ' '.$this->profile : '').' R '.$this->diameter.($this->is_commercial == 1 ? 'C' : '').' ';
        $string .= ucfirst($this->brand).' ';

        if ($this->category == TireCategory::HIGH_PROFILE || $this->category == TireCategory::PROFILE || $this->category == TireCategory::REPAIRED) {
            $string .= 'al '.$this->calculateMillimeterPercentage().'% SPED GRATIS';
        } elseif ($this->category == TireCategory::NEW || $this->category == TireCategory::NEW_AGED || $this->category == TireCategory::NEW_EXTRA) {
            $string .= 'SPED GRATIS';
        }

        return $string;
    }

    public function getSubitoTitle(): string
    {
        return $this->getKijijiTitle();
    }

    public function getKijijiPrice($real_price = false)
    {
        $tire_price = $real_price ? $this->price_full : $this->price;
        if ($this->category == 3) {
            $price = ($this->price_list * ((100 - $this->discount_immediate_payment) / 100)) * 1.22;
            $price = ceil(($price + ($this->pfu_contribution * 1.22)));
        } elseif ($this->category == 5) {
            $price = $this->price_list;
        } else {
            $price = $tire_price * $this->amount;

            switch ($this->diameter) {
                case 13:
                case 14:
                    if ($this->amount == 2) {
                        $price += 15;
                    } else {
                        $price += 20;
                    }
                    break;
                case 15:
                case 16:
                    if ($this->amount == 2) {
                        $price += 15;
                    } else {
                        $price += 25;
                    }
                    break;
                case 17:
                case 18:
                    if ($this->amount == 2) {
                        $price += 15;
                    } else {
                        $price += 30;
                    }
                    break;
                case 19:
                case 20:
                    if ($this->amount == 2) {
                        $price += 20;
                    } else {
                        $price += 35;
                    }
                    break;
                default:
                    if ($this->amount == 2) {
                        $price += 20;
                    } else {
                        $price += 40;
                    }
            }
        }

        return $price;
    }

    public function getSubitoPrice()
    {
        return $this->getKijijiPrice();
    }

    /**
     * Calculate percentage millimeter remaining of tread
     */
    public function calculateMillimeterPercentage(): float
    {
        if ($this->millimeters_new_by_manufacturer != 0) {
            if ($this->millimeters_2 != 0) {
                $percent_1 = ($this->millimeters * 100) / $this->millimeters_new_by_manufacturer;
                $percent_2 = ($this->millimeters_2 * 100) / $this->millimeters_new_by_manufacturer;
                $percent = ($percent_1 + $percent_2) / 2;
            } else {
                $percent = ($this->millimeters * 100) / $this->millimeters_new_by_manufacturer;
            }
        } else {
            $percent = 0;
        }

        return round($percent, 0, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Generate description for ecommerce
     */
    public function getUniversalDescription(): string
    {
        if ($this->category == \App\Enums\TireCategory::HIGH_PROFILE || $this->category == \App\Enums\TireCategory::PROFILE || $this->category == \App\Enums\TireCategory::REPAIRED) {
            $description = 'Prezzo riferito al lotto completo – Montaggio o Spedizione GRATIS <br />';
            $description .= '<br />';
            $description .= 'MISURA: '.$this->width.(($this->profile != 0) ? ' '.$this->profile : '').' '.$this->diameter.($this->is_commercial == 1 ? 'C' : '').'<br />';
            $description .= '<br />';
            $description .= 'MARCA / MODELLO: '.strtoupper($this->brand).' '.strtoupper($this->model).'<br />';
            $description .= '<br />';
            $description .= 'STAGIONE: '.strtoupper($this->type->name).'<br />';
            $description .= '<br />';
            $description .= 'INDICE DI CARICO E VELOCITÀ: '.$this->load_index.' '.$this->speed_index.'<br />';
            $description .= '<br />';
            $description .= 'DOT (ANNO DI COSTRUZIONE): '.$this->dot.'<br />';
            $description .= '<br />';
            if ($this->millimeters_2) {
                $description .= 'MILLIMETRI: '.$this->millimeters.' / '.$this->millimeters_2.' ('.$this->calculateMillimeterPercentage().'% un pneumatico nuovo nasce con '.$this->millimeters_new_by_manufacturer.'mm)'.'<br />';
            } else {
                $description .= 'MILLIMETRI: '.$this->millimeters.' ('.$this->calculateMillimeterPercentage().'% un pneumatico nuovo nasce con '.$this->millimeters_new_by_manufacturer.'mm)'.'<br />';
            }
            $description .= '<br />';
            $description .= 'QUANTITÀ: '.$this->amount.'<br />';
            $description .= '<br />';
            $description .= 'Pneumatici d’occasione garantiti! Selezionati e testati con macchinario apposito<br />';
            $description .= 'Spediamo in tutta Italia GRATUITAMENTE con corriere espresso BRT in 24/48<br />';
            $description .= 'Pagamento alla Consegna o Anticipato tramite PayPal / Bonifico<br />';
            $description .= 'Montaggio ed equilibratura GRATUITI prenotando al 3923026347 Cell/Whatsapp<br />';
            $description .= '<br />';
            $description .= 'Visita la nostra sede in Via Monte Nerone 16, Vallefoglia 61022 ( PU )<br />';
            $description .= 'Pneumatici Adriatica Usati e Nuovi <br />';
            $description .= 'Codice Articolo #'.$this->id.'<br />';
            $description .= '<br />';
            $description .= 'Note venditore : '.$this->width.$this->profile.$this->diameter.' – '.$this->width.$this->profile.'R'.$this->diameter.' - '.$this->width.'/'.$this->profile.'/'.$this->diameter.' – '.$this->width.'/'.$this->profile.'R'.$this->diameter.' – '.$this->width.'-'.$this->profile.'-'.$this->diameter.' – '.$this->width.'-'.$this->profile.'R'.$this->diameter.' - '.$this->width.'-'.$this->profile.'-R'.$this->diameter.' - '.$this->width.'/'.$this->profile.' '.$this->diameter.' – '.$this->width.'/'.$this->profile.'r'.$this->diameter.' – R'.$this->diameter.'<br />';
            if ($this->type_id == 1) {
                $description .= 'Estiva – Estive – Estivi<br />';
            } elseif ($this->type_id == 2) {
                $description .= 'Invernale – Invernali<br />';
            } elseif ($this->type_id == 3) {
                $description .= '4 Stagione – 4 Stagioni<br />';
            } elseif ($this->type_id == 4) {
                $description .= 'Estiva (m+s) – Estive (m+s) – Estivi (m+s)<br />';
            }
            $description .= 'Gomme – Gomma – Pneumatico – Pneumatici – Usata – Usate - Usati – Semi Nuovi – Semi-Nuovi – Occasione – Occasioni – Offerta – Offerte<br />';
        } elseif ($this->category == \App\Enums\TireCategory::NEW) {
            $description = 'Prezzo riferito al singolo pneumatico – Montaggio o Spedizione GRATIS <br />';
            $description .= '<br />';
            $description .= 'MISURA: '.$this->width.(($this->profile != 0) ? ' '.$this->profile : '').' '.$this->diameter.($this->is_commercial == 1 ? 'C' : '').'<br />';
            $description .= '<br />';
            $description .= 'MARCA / MODELLO: '.strtoupper($this->brand).' '.strtoupper($this->model).'<br />';
            $description .= '<br />';
            $description .= 'STAGIONE: '.strtoupper($this->type->name).'<br />';
            $description .= '<br />';
            $description .= 'INDICE DI CARICO E VELOCITÀ: '.$this->load_index.' '.$this->speed_index.'<br />';
            $description .= '<br />';
            $description .= 'STATO: NUOVO<br />';
            $description .= '<br />';
            $description .= 'Pneumatici d’occasione garantiti! Selezionati e testati con macchinario apposito<br />';
            $description .= 'Spediamo in tutta Italia GRATUITAMENTE con corriere espresso BRT in 24/48<br />';
            $description .= 'Pagamento alla Consegna o Anticipato tramite PayPal / Bonifico<br />';
            $description .= 'Montaggio ed equilibratura GRATUITI prenotando al 3923026347 Cell/Whatsapp<br />';
            $description .= '<br />';
            $description .= 'Visita la nostra sede in Via Monte Nerone 16, Vallefoglia 61022 ( PU )<br />';
            $description .= 'Pneumatici Adriatica Usati e Nuovi <br />';
            $description .= 'Codice Articolo #'.$this->id.'<br />';
            $description .= '<br />';
            $description .= 'Note venditore : '.$this->width.$this->profile.$this->diameter.' – '.$this->width.$this->profile.'R'.$this->diameter.' - '.$this->width.'/'.$this->profile.'/'.$this->diameter.' – '.$this->width.'/'.$this->profile.'R'.$this->diameter.' – '.$this->width.'-'.$this->profile.'-'.$this->diameter.' – '.$this->width.'-'.$this->profile.'R'.$this->diameter.' - '.$this->width.'-'.$this->profile.'-R'.$this->diameter.' - '.$this->width.'/'.$this->profile.' '.$this->diameter.' – '.$this->width.'/'.$this->profile.'r'.$this->diameter.' – R'.$this->diameter.'<br />';
            if ($this->type_id == 1) {
                $description .= 'Estiva – Estive – Estivi<br />';
            } elseif ($this->type_id == 2) {
                $description .= 'Invernale – Invernali<br />';
            } elseif ($this->type_id == 3) {
                $description .= '4 Stagione – 4 Stagioni<br />';
            } elseif ($this->type_id == 4) {
                $description .= 'Estiva (m+s) – Estive (m+s) – Estivi (m+s)<br />';
            }
            $description .= 'Gomme – Gomma – Pneumatico – Pneumatici – Usata – Usate - Usati – Semi Nuovi – Semi-Nuovi – Occasione – Occasioni – Offerta – Offerte – Nuovi – Nuove<br />';
        } elseif ($this->category == \App\Enums\TireCategory::NEW_AGED) {
            $description = 'Prezzo riferito al lotto completo – Montaggio o Spedizione GRATIS <br />';
            $description .= '<br />';
            $description .= 'MISURA: '.$this->width.(($this->profile != 0) ? ' '.$this->profile : '').' '.$this->diameter.($this->is_commercial == 1 ? 'C' : '').'<br />';
            $description .= '<br />';
            $description .= 'MARCA / MODELLO: '.strtoupper($this->brand).' '.strtoupper($this->model).'<br />';
            $description .= '<br />';
            $description .= 'STAGIONE: '.strtoupper($this->type->name).'<br />';
            $description .= '<br />';
            $description .= 'INDICE DI CARICO E VELOCITÀ: '.$this->load_index.' '.$this->speed_index.'<br />';
            $description .= '<br />';
            $description .= 'DOT (ANNO DI COSTRUZIONE): '.$this->dot.'<br />';
            $description .= '<br />';
            $description .= 'STATO: NUOVO<br />';
            $description .= '<br />';
            $description .= 'QUANTITÀ: '.$this->amount.'<br />';
            $description .= '<br />';
            $description .= 'Pneumatici d’occasione garantiti! Selezionati e testati con macchinario apposito<br />';
            $description .= 'Spediamo in tutta Italia GRATUITAMENTE con corriere espresso BRT in 24/48<br />';
            $description .= 'Pagamento alla Consegna o Anticipato tramite PayPal / Bonifico<br />';
            $description .= 'Montaggio ed equilibratura GRATUITI prenotando al 3923026347 Cell/Whatsapp<br />';
            $description .= '<br />';
            $description .= 'Visita la nostra sede in Via Monte Nerone 16, Vallefoglia 61022 ( PU )<br />';
            $description .= 'Pneumatici Adriatica Usati e Nuovi <br />';
            $description .= 'Codice Articolo #'.$this->id.'<br />';
            $description .= '<br />';
            $description .= 'Note venditore : '.$this->width.$this->profile.$this->diameter.' – '.$this->width.$this->profile.'R'.$this->diameter.' - '.$this->width.'/'.$this->profile.'/'.$this->diameter.' – '.$this->width.'/'.$this->profile.'R'.$this->diameter.' – '.$this->width.'-'.$this->profile.'-'.$this->diameter.' – '.$this->width.'-'.$this->profile.'R'.$this->diameter.' - '.$this->width.'-'.$this->profile.'-R'.$this->diameter.' - '.$this->width.'/'.$this->profile.' '.$this->diameter.' – '.$this->width.'/'.$this->profile.'r'.$this->diameter.' – R'.$this->diameter.'<br />';
            if ($this->type_id == 1) {
                $description .= 'Estiva – Estive – Estivi<br />';
            } elseif ($this->type_id == 2) {
                $description .= 'Invernale – Invernali<br />';
            } elseif ($this->type_id == 3) {
                $description .= '4 Stagione – 4 Stagioni<br />';
            } elseif ($this->type_id == 4) {
                $description .= 'Estiva (m+s) – Estive (m+s) – Estivi (m+s)<br />';
            }
            $description .= 'Gomme – Gomma – Pneumatico – Pneumatici – Usata - Usate – Usati – Semi Nuovi – Semi-Nuovi – Occasione – Occasioni – Offerta – Offerte – Nuovi – Nuove<br />';
        } elseif ($this->category == \App\Enums\TireCategory::NEW_EXTRA) {
            $amount = $this->amount;
            $amount = $amount <= 4 ? $amount : 4;
            $amount = $amount == 3 ? 2 : $amount;

            $description = 'Prezzo riferito al lotto completo – Montaggio o Spedizione GRATIS <br />';
            $description .= '<br />';
            $description .= 'MISURA: '.$this->width.(($this->profile != 0) ? ' '.$this->profile : '').' '.$this->diameter.($this->is_commercial == 1 ? 'C' : '').'<br />';
            $description .= '<br />';
            $description .= 'MARCA / MODELLO: '.strtoupper($this->brand).' '.strtoupper($this->model).'<br />';
            $description .= '<br />';
            $description .= 'STAGIONE: '.strtoupper($this->type->name).'<br />';
            $description .= '<br />';
            $description .= 'INDICE DI CARICO E VELOCITÀ: '.$this->load_index.' '.$this->speed_index.'<br />';
            $description .= '<br />';
            $description .= 'STATO: NUOVO<br />';
            $description .= '<br />';
            $description .= 'QUANTITÀ: '.$amount.'<br />';
            $description .= '<br />';
            $description .= 'Pneumatici d’occasione garantiti! Selezionati e testati con macchinario apposito<br />';
            $description .= 'Spediamo in tutta Italia GRATUITAMENTE con corriere espresso BRT in 24/48<br />';
            $description .= 'Pagamento alla Consegna o Anticipato tramite PayPal / Bonifico<br />';
            $description .= 'Montaggio ed equilibratura GRATUITI prenotando al 3923026347 Cell/Whatsapp<br />';
            $description .= '<br />';
            $description .= 'Visita la nostra sede in Via Monte Nerone 16, Vallefoglia 61022 ( PU )<br />';
            $description .= 'Pneumatici Adriatica Usati e Nuovi <br />';
            $description .= 'Codice Articolo #'.$this->id.'<br />';
            $description .= '<br />';
            $description .= 'Note venditore : '.$this->width.$this->profile.$this->diameter.' – '.$this->width.$this->profile.'R'.$this->diameter.' - '.$this->width.'/'.$this->profile.'/'.$this->diameter.' – '.$this->width.'/'.$this->profile.'R'.$this->diameter.' – '.$this->width.'-'.$this->profile.'-'.$this->diameter.' – '.$this->width.'-'.$this->profile.'R'.$this->diameter.' - '.$this->width.'-'.$this->profile.'-R'.$this->diameter.' - '.$this->width.'/'.$this->profile.' '.$this->diameter.' – '.$this->width.'/'.$this->profile.'r'.$this->diameter.' – R'.$this->diameter.'<br />';
            if ($this->type_id == 1) {
                $description .= 'Estiva – Estive – Estivi<br />';
            } elseif ($this->type_id == 2) {
                $description .= 'Invernale – Invernali<br />';
            } elseif ($this->type_id == 3) {
                $description .= '4 Stagione – 4 Stagioni<br />';
            } elseif ($this->type_id == 4) {
                $description .= 'Estiva (m+s) – Estive (m+s) – Estivi (m+s)<br />';
            }
            $description .= 'Gomme – Gomma – Pneumatico – Pneumatici – Usata – Usate - Usati – Semi Nuovi – Semi-Nuovi – Occasione – Occasioni – Offerta – Offerte – Nuovi – Nuove<br />';
        }

        return $description;
    }

    /**
     * Recalculating prices based on price list for various caategory
     */
    public function recalculatePrices()
    {
        if ($this->category == 3) {
            $price = ($this->price_list * ((100 - $this->discount_immediate_payment) / 100)) * 1.22;

            switch ($this->diameter) {
                case 13:
                case 14:
                    $price -= 5;
                    break;
                case 15:
                case 16:
                    $price -= 6.25;
                    break;
                case 17:
                case 18:
                    $price -= 7.5;
                    break;
                case 19:
                case 20:
                    $price -= 8.75;
                    break;
                default:
                    $price -= 10;
            }
            $this->price = round(($price + ($this->pfu_contribution * 1.22)), 0, PHP_ROUND_HALF_UP);

            $price = ($this->price_list * ((100 - $this->discount_immediate_payment) / 100)) * 1.22;
            $price = round(
                ($price + ($this->pfu_contribution * 1.22)),
                0,
                PHP_ROUND_HALF_UP
            );
            $this->price_ebay = round(
                $this->calculateEbayPrice(),
                1,
                PHP_ROUND_HALF_UP
            );
        } elseif ($this->category == 5) {
            $amount = $this->amount <= 4 ? $this->amount : 4;
            $amount = $amount == 3 ? 2 : $amount;

            $price_list = $this->price;

            switch ($this->diameter) {
                case 13:
                case 14:
                    $price_list += 5;
                    break;
                case 15:
                case 16:
                    $price_list += 6.25;
                    break;
                case 17:
                case 18:
                    $price_list += 7.5;
                    break;
                case 19:
                case 20:
                    $price_list += 8.75;
                    break;
                default:
                    $price_list += 10;
            }

            $price_list = $price_list * $amount;

            $this->price_list = round(
                $price_list, 0, PHP_ROUND_HALF_DOWN
            );

            $this->price_ebay = round(
                $price_list * 1.07, 1, PHP_ROUND_HALF_UP
            );
        } else {
            $price_list = $this->price;

            switch ($this->diameter) {
                case 13:
                case 14:
                    $price_list += 5;
                    break;
                case 15:
                case 16:
                    $price_list += 6.25;
                    break;
                case 17:
                case 18:
                    $price_list += 7.5;
                    break;
                case 19:
                case 20:
                    $price_list += 8.75;
                    break;
                default:
                    $price_list += 10;
            }

            $price_list = $price_list * $this->amount;

            $this->price_list = round(
                $price_list, 0, PHP_ROUND_HALF_DOWN
            );

            $this->price_ebay = round(
                $this->calculateEbayPrice(), 1, PHP_ROUND_HALF_UP
            );
        }
    }

    /**
     * Calculate ebay priced based on single tire price
     *
     * @param $tire_price
     * @param $amount
     * @param $diameter
     */
    public function calculateEbayPrice($real_price = false): float
    {
        $tire_price = $real_price ? $this->price_full : $this->price;
        $amount = ($this->category == 3) ? 2 : $this->amount;
        $diameter = $this->diameter;

        $price = 0;

        switch (intval($diameter)) {
            case 13:
            case 14:
                if ($amount == 2) {
                    $price += 15;
                } else {
                    $price += 20;
                }
                break;
            case 15:
            case 16:
                if ($amount == 2) {
                    $price += 15;
                } else {
                    $price += 25;
                }
                break;
            case 17:
            case 18:
                if ($amount == 2) {
                    $price += 15;
                } else {
                    $price += 30;
                }
                break;
            case 19:
            case 20:
                if ($amount == 2) {
                    $price += 20;
                } else {
                    $price += 35;
                }
                break;
            default:
                if ($amount == 2) {
                    $price += 20;
                } else {
                    $price += 40;
                }
        }

        return ($price + (intval($tire_price) * $amount)) * 1.07;
    }

    /**
     * Calculate time slot required for mounting based on amount and diameter
     */
    public function calculateLabourTimeSlot(): float
    {
        if ($this->is_commercial) {
            if ($this->diameter <= 14) {
                $labour = 0.25 * $this->amount;
            } else {
                $labour = 0.375 * $this->amount;
            }
        } else {
            if ($this->diameter <= 17) {
                $labour = 0.25 * $this->amount;
            } else {
                $labour = 0.375 * $this->amount;
            }
        }

        return $labour;
    }

    /**
     * Return similar tire if amount equals 2
     *
     * @return Tire[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getSimilar()
    {
        return ($this->amount == 2) ? Tire::where('id', '!=', $this->id)
            ->where('model', $this->model)
            ->where('brand', $this->brand)
            ->where('width', $this->width)
            ->where('profile', $this->profile)
            ->where('diameter', $this->diameter)
            ->where('type_id', $this->type_id)
            ->where('category', $this->category)
            ->where('category', '<', 3)
            ->where('load_index', $this->load_index)
            ->where('speed_index', $this->speed_index)
            ->where('amount', 2)
            ->where('status', TireStatus::Available)
            ->get() : collect();
    }

    /**
     * Generate QrCode with tire id
     *
     * @return mixed
     */
    public function getQrCode()
    {
        return QrCode::size(120)->format('svg')->generate($this->id);
    }

    public function destory()
    {
        foreach ($this->photos as $photo) {
            Storage::delete($photo->path);
            $photo->delete();
        }
        $this->delete();
    }
}
