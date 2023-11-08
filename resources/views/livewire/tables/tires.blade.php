<div>
    @php
        $search_type_letter = '';
        switch($type) {
            case 1:
            case 4:
                $search_type_letter = 'e';
                break;
            case 2:
                $search_type_letter = 'i';
                break;
            case 3:
                $search_type_letter = 'q';
                break;
        }
    @endphp
    <div class="shadow sm:rounded-md sm:overflow-hidden px-4 py-5 bg-white">
        <div class="w-full">
            <div class="mb-2">
                <b>Azioni multiple</b>
            </div>

            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4 inline-flex">
                    <button wire:click="sell"
                            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded ml-2 mx-1">
                        <i class="bi bi-credit-card"></i>
                    </button>

                    @if(auth()->user()->isNotA('customer'))
                        <button wire:click="label"
                                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mx-1">
                            <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    @endif

                    <button wire:click="publishEbay"
                            class="bg-white-500 hover:bg-yellow-700 text-white font-bold px-2 border border-yellow-700 rounded mx-1">
                        <svg class="fill-current w-12 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <path data-name="layer4"
                                  d="M8.313 25.106c-4.507 0-8.313 1.9-8.313 7.7 0 4.6 2.5 7.5 8.413 7.5 6.911 0 7.311-4.5 7.311-4.5h-3.305s-.7 2.4-4.207 2.4a4.607 4.607 0 0 1-4.908-4.6h12.82v-1.9c.001-2.7-1.802-6.6-7.811-6.6zm-5.008 6.3c0-2.6 2.4-4.1 4.807-4.1 2.7 0 4.507 1.7 4.507 4.1z"
                                  fill="#e43532"></path>
                            <path data-name="layer3"
                                  d="M32.751 34.106a7.557 7.557 0 0 0 .1-1.5 7.168 7.168 0 0 0-7.612-7.5c-4.507 0-5.809 2.4-5.809 2.4v-8h-3.305v17.8c0 1-.1 2.4-.1 2.4h3.205s.1-1 .1-2c0 0 1.6 2.5 5.909 2.5a7.233 7.233 0 0 0 7.311-5.2c.073-.329.193-.729.317-1.142-.035.082-.087.156-.116.242zm-8.413 4c-3.305 0-5.008-2.6-5.008-5.4 0-2.6 1.6-5.4 5.008-5.4 3.1 0 5.008 2.3 5.008 5.3 0 3.3-2.304 5.5-5.008 5.5z"
                                  fill="#0063da"></path>
                            <path data-name="layer2"
                                  d="M40.764 25.106c-6.811 0-7.211 3.7-7.211 4.3h3.405s.2-2.2 3.606-2.2c2.2 0 4.006 1 4.006 3v.7h-4.007c-4.227 0-6.867 1.022-7.7 2.958-.124.413-.244.813-.317 1.142v.5c0 3.1 2.6 4.7 6.009 4.7 4.707 0 6.31-2.6 6.31-2.6 0 1 .1 2.1.1 2.1h3s-.1-1.3-.1-2.1v-7a8.582 8.582 0 0 0-.4-2.4l-.6-.7c-1.294-1.9-3.798-2.4-6.101-2.4zm-1.6 13c-2.4 0-3.505-1.2-3.505-2.6 0-2.5 3.505-2.6 8.613-2.6v1h.1c-.003 1.2-.804 4.2-5.211 4.2z"
                                  fill="#f6b000"></path>
                            <path data-name="layer1" fill="#87b900"
                                  d="M50.679 45.006h3.606L64 25.706h-3.405l-5.409 10.9-5.508-10.9h-3.806l1.001 1.8.601.7 6.11 11.4-2.905 5.4z"></path>
                        </svg>
                    </button>

                    <button wire:click="publishSubito" type="submit"
                            class="bg-white-500 hover:bg-yellow-700 text-white font-bold px-2 border border-yellow-700 rounded mx-1">
                        <svg viewBox="0 0 600 136" xmlns="http://www.w3.org/2000/svg" class="fill-current w-12 h-8">
                            <path fill="#F9423A"
                                  d="M105.832 67.807a2.565 2.565 0 001.414-3.33L93.15 29.588a2.563 2.563 0 00-3.329-1.41l-9.06 3.659a2.565 2.565 0 00-1.415 3.329l14.099 34.89a2.561 2.561 0 003.326 1.411l9.06-3.66zM85.75 79.027a2.545 2.545 0 000-3.588L51.635 41.324a2.542 2.542 0 00-3.585 0l-6.937 6.938a2.545 2.545 0 000 3.589l34.111 34.114c.99.987 2.602.987 3.588 0l6.938-6.938zM71.252 96.99a2.561 2.561 0 00-1.411-3.33L34.95 79.565a2.563 2.563 0 00-3.326 1.411l-3.662 9.062a2.563 2.563 0 001.414 3.326l34.887 14.1a2.564 2.564 0 003.329-1.414l3.66-9.06zM67.89.209c37.494 0 67.89 30.398 67.89 67.895 0 37.5-30.396 67.896-67.89 67.896S0 105.604 0 68.104C0 30.607 30.396.21 67.89.21zM429.278 0c1.74 0 1.986 1.218 1.679 2.589l-4.636 23.736c-.153 1.37-.939 1.676-2.215 1.676h-11.161c-1.737 0-1.987-1.216-1.679-2.587l4.636-23.735C416.055.309 416.84 0 418.117 0h11.161zM574 49.31c0 1.228-.755 1.831-2.126 1.831h-13.74c3.957 6.867 5.188 14.041 5.188 21.663 0 25.468-17.69 46.67-42.554 46.67-9.148 0-20.278-4.572-25.006-14.028-5.648 7.164-13.272 14.028-25.478 14.028-7.929 0-16.616-2.586-21.048-10.529-6.701 6.712-14.938 10.53-23.48 10.53-25.468 0-28.222-21.356-24.865-40.417l3.86-22.497c-6.095 3.176-15.125 3.176-20.026 2.062 1.228 4.573 1.676 9.146 1.676 13.72 0 24.558-13.717 47.131-40.708 47.131-9.465 0-19.678-4.417-24.403-14.18-5.035 8.84-14.797 14.18-24.712 14.18-7.47 0-15.706-4.125-19.83-12.35-6.864 8.996-17.23 12.35-25.619 12.35-17.691 0-25.008-10.979-25.008-27.914 0-4.42.603-9.148 1.526-14.336l7.18-39.671c.152-1.076.92-1.524 2.135-1.524h12.578c1.505 0 1.678 1.229 1.523 2.14l-7.25 39.515c-3.049 16.475-1.986 26.239 9.61 26.239 10.055 0 17.381-6.867 20.125-22.126l7.942-44.244c.155-1.076.923-1.524 2.139-1.524h12.575c1.508 0 1.678 1.229 1.526 2.14l-7.403 40.426c-1.831 9.608-3.357 25.175 8.392 25.175 8.376 0 13.72-8.392 17.228-27.161l13.72-75.035C329.822.511 330.827 0 331.806 0h12.582c.842 0 1.819.755 1.524 2.129l-7.085 39.251c6.25-3.512 13.412-5.638 20.278-5.638 6.253 0 10.53 1.831 14.795 3.805 14.299 7.1 27.805 3.128 33.748-2.358.717-.725 1.536-1.16 2.594-1.16.287-.002 12.35 0 12.35 0 2.03 0 2.295 1.371 1.987 2.907l-7.522 40.274c-2.281 11.132-2.126 24.56 9.762 24.56 9.913 0 16.474-10.071 19.523-26.086l5.045-25.643h-14.16c-1.522 0-2.446-.755-2.446-2.126V38.321c0-1.523.771-2.292 2.14-2.292h17.586l6.643-34.35C461.305.308 462.09 0 463.365 0h12.285c1.74 0 1.986 1.218 1.678 2.589l-6.484 33.44h18.843c1.381 0 2.139.769 2.139 2.14v11.899c0 1.218-.758 1.973-1.986 1.973h-22.127l-5.358 27.17c-1.833 9.455-3.052 24.56 8.697 24.56 13.117 0 17.692-13.121 19.675-27.302 3.96-28.07 20.74-41.035 43.465-41.035h37.682c1.37 0 2.126.758 2.126 2.14V49.31zM369.935 72.957c0-14.95-7.153-21.663-15.34-21.663-10.957 0-23.08 11.594-23.08 30.966 0 11.747 5.115 21.51 15.632 21.51 11.83 0 22.788-11.902 22.788-30.813zm176.76 0c0-14.95-7.468-21.663-16.012-21.663-11.441 0-24.098 11.594-24.098 30.966 0 11.747 5.343 21.51 16.321 21.51 12.349 0 23.79-11.902 23.79-30.813zm-323.48-26.083l-5.788 8.995c-.77 1.073-1.834 1.228-2.744.615-5.033-2.896-11.13-6.866-20.135-6.866-8.392 0-14.183 2.741-14.183 8.082 0 4.88 1.679 6.406 15.859 12.363 15.257 6.406 22.571 12.044 22.571 25.622 0 17.988-14.795 23.79-30.806 23.79-6.713 0-20.433-.766-31.258-13.271l-3.202-3.665c-.49-.648-.768-1.063-.768-1.678 0-.603.308-1.216.768-1.679l8.685-7.622c.432-.379.923-.603 1.525-.603.46 0 1.073.143 1.524.756 6.866 8.085 13.884 12.21 22.726 12.21 9.76 0 14.038-2.602 14.038-8.238 0-4.277-1.831-6.406-13.27-11.286-17.089-7.175-24.71-12.518-24.71-26.699 0-14.18 11.899-23.944 30.808-23.944 9.3 0 18.905 3.05 27.757 9.303.91.613 1.218 1.37 1.218 1.984 0 .615-.307 1.218-.615 1.83z"
                                  fill-rule="evenodd"/>
                        </svg>
                    </button>

                    @if(auth()->user()->isNotA('customer'))
                        <button wire:click="multipleDelete"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded mx-1">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    @endif

                    @if(auth()->user()->isNotA('customer'))
                        <button wire:click="import"
                                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mx-1">
                            <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        </button>
                    @endif

                    @if(auth()->user()->isNotA('customer'))
                        <button wire:click="discount"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 border border-yellow-700 rounded mx-1">
                            <i class="bi bi-tags"></i>
                        </button>
                    @endif

                    @if(auth()->user()->isNotA('customer'))
                        <button wire:click="resetDiscount"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded mx-1"
                                tile="Rimuovi sconto">
                            <i class="bi bi-tags-fill"></i>
                        </button>
                    @endif

                    <div class="mx-4">
                        <input type="checkbox" wire:model="only_available_tires" value=1></input> Solo disponibili <br/>
                        <input type="checkbox" wire:model="only_not_available_tires" value=1></input> Solo non
                        disponibili
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-2 inline-flex">
                    <a href="https://tyre24.alzura.com/it/it/redex?search={{ $search_type_letter }}{{ $width_from }}{{ $profile_from }}{{ $diameter_from }}&manufacturerName={{ $brand }}&filter[stock]=4&filter[attr_256]=3&filter[attr_254]=3&sort=price:asc&area=ty&category=&page=0&rating=good&stock=4"
                       target="_blank">
                        <button
                            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded mx-1">
                            <i class="bi bi-search"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
            <tr>
                @if(auth()->user()->isNotA('customer'))
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    </th>
                @endif
                <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    @if($discount_mode)
                        <button wire:click="$set('discount_mode',false)"
                                class="bg-yellow-700 hover:bg-yellow-900 text-white font-bold py-2 px-4 border border-yellow-900 rounded mx-1">
                            <i class="bi bi-tags"></i>
                        </button>
                    @else
                        <button wire:click="$set('discount_mode',true)"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 border border-yellow-700 rounded mx-1">
                            <i class="bi bi-tags"></i>
                        </button>
                    @endif
                    ({{ count($tires_selected)  }})
                </th>
                @if($discount_mode)
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Shop
                    </th>
                @endif
                <th wire:click="$set('order_by', 'id')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    #
                    @if($order_by == 'id')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                @if(auth()->user()->isNotA('customer'))
                    <th wire:click="$set('order_by', 'rack_identifier')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Rack
                        @if($order_by == 'rack_identifier')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'rack_position')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Posizione
                        @if($order_by == 'rack_position')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                @endif
                <th wire:click="$set('order_by', 'ean')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    EAN
                    @if($order_by == 'ean')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Categoria
                </th>
                <th wire:click="$set('order_by', 'width')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Larghezza
                    @if($order_by == 'width')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'profile')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Profilo
                    @if($order_by == 'profile')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'diameter')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Diametro
                    @if($order_by == 'diameter')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    C
                </th>
                <th wire:click="$set('order_by', 'brand')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Marca
                    @if($order_by == 'brand')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'model')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Modello
                    @if($order_by == 'model')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Millimetri
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Stagione
                </th>
                <th wire:click="$set('order_by', 'load_index')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Indice carico
                    @if($order_by == 'load_index')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'speed_index')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Indice velocità
                    @if($order_by == 'speed_index')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'dot')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Anno costruzione
                    @if($order_by == 'dot')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'amount')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Q.ta
                    @if($order_by == 'amount')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                @if($discount_mode)
                    <th wire:click="$set('order_by', 'price')" scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Prezzo ritiro (singolo)
                        @if($order_by == 'price')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Prezzo montate e spedite (singolo)
                    </th>
                @endif
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Prezzo Subito/Kijiji Ebay
                </th>
                @if($discount_mode)
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Creato il
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Sconto
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Data ultimo sconto
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Numero sconti effettuati
                    </th>
                @endif
                <th scope="col"
                    class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Unificato
                </th>
                <th scope="col"
                    class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    Immagini
                </th>
                <th scope="col" class="relative px-6 py-3 text-right bg-gray-100">
                    @if(auth()->user()->isNotA('customer'))
                        <a
                            href="{{ route('tires.create') }}"
                            class="text-indigo-600 hover:text-indigo-900"
                        >Aggiungi</a>
                    @endif
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                @if(auth()->user()->isNotA('customer'))
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">

                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                    <input type="checkbox" wire:model="tires_selected_all" value="1"/><br/>
                    Tutto
                </td>
                @if($discount_mode)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <select
                            class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            wire:model="shop"
                        >
                            <option></option>
                            <option value="1">Nessuno</option>
                            <option value="2">Ebay</option>
                            <option value="3">Subito</option>
                            <option value="4">Ebay e Subito</option>
                        </select>
                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="identifier"
                           wire:keydown.enter="storeIdentifier"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @foreach($storedIdentifiers as $storedIdentifier)
                        <span wire:click="removeIdentifier({{ $storedIdentifier }})"
                              class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $storedIdentifier }}</span>
                    @endforeach
                </td>
                @if(auth()->user()->isNotA('customer'))
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                        <input type="text"
                               wire:model="rack_identifier"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                @endif
                @if(auth()->user()->isNotA('customer'))
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                        <input type="number"
                               wire:model="rack_position"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="ean"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <select
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        wire:model="category"
                    >
                        <option></option>
                        @foreach(\App\Enums\TireCategory::getValues() as $value)
                            <option value="{{ $value }}">{{ \App\Enums\TireCategory::getDescription($value) }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="width_from"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @if($discount_mode)
                        <input type="number"
                               wire:model="width_to"
                               min=1
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @endif
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="profile_from"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @if($discount_mode)
                        <input type="number"
                               wire:model="profile_to"
                               min=1
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @endif
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number"
                           wire:model="diameter_from"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @if($discount_mode)
                        <input type="number"
                               wire:model="diameter_to"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @endif
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="checkbox"
                           wire:model="is_commercial_yes"
                           value="1"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="is_commercial_yes"
                           class="ml-3 block text-sm font-medium text-gray-700 mr-4">
                        Si
                    </label>

                    <input type="checkbox"
                           wire:model="is_commercial_no"
                           value="1"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="is_commercial_no"
                           class="ml-3 block text-sm font-medium text-gray-700 mr-4">
                        No
                    </label>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="brand"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="model"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <select
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        wire:model="type"
                    >
                        <option></option>
                        @foreach(\App\Models\Type::get() as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text"
                           wire:model="load_index"
                           min=0
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                    <input type="text"
                           wire:model="speed_index"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                    <input type="text"
                           wire:model="dot"
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                    <input type="number"
                           wire:model="amount"
                           min=1
                           class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                @if($discount_mode)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                        <input type="number"
                               wire:model="price_from"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @if($discount_mode)
                            <input type="number"
                                   wire:model="price_to"
                                   min=0
                                   class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @endif
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">

                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                @if($discount_mode)
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                        <input type="date"
                               wire:model="created_at_from"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <input type="date"
                               wire:model="created_at_to"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="number"
                               wire:model="price_discount_from"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <input type="number"
                               wire:model="price_discount_to"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500 bg-blue-100">
                        <input type="date"
                               wire:model="discounted_at_from"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <input type="date"
                               wire:model="discounted_at_to"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                @endif
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <select
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        wire:model="photo"
                    >
                        <option value="1">-</option>
                        <option value="2">Si</option>
                        <option value="3">No</option>
                    </select>
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100 text-center">

                </td>
            </tr>
            @foreach($tires as $tire)
                <livewire:tables.tire-row :tire="$tire" :discount_mode="$discount_mode" :key="$tire->id"/>
            @endforeach
            </tbody>
        </table>

        <div class="pr-4 pl-4">
            {{ $tires->links() }}
        </div>
    </div>
</div>
