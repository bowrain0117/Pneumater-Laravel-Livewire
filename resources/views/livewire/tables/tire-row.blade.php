<tr>
    @if(auth()->user()->isNotA('customer'))
        <td wire:click="alternateLockStatus" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
            @if($edit_lock)
                <i class="bi bi-lock-fill"></i>
            @else
                <i class="bi bi-unlock-fill"></i>
            @endif
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <input type="checkbox" wire:model="checked" value="1"/>
    </td>
    @if($discount_mode)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            @foreach($listings as $listing)
                @if($listing->shop == \App\Enums\Shop::Ebay)
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
                @endif

                @if($listing->shop == \App\Enums\Shop::Subito)
                    <svg viewBox="0 0 600 136" xmlns="http://www.w3.org/2000/svg" class="fill-current w-12 h-8">
                        <path fill="#F9423A"
                              d="M105.832 67.807a2.565 2.565 0 001.414-3.33L93.15 29.588a2.563 2.563 0 00-3.329-1.41l-9.06 3.659a2.565 2.565 0 00-1.415 3.329l14.099 34.89a2.561 2.561 0 003.326 1.411l9.06-3.66zM85.75 79.027a2.545 2.545 0 000-3.588L51.635 41.324a2.542 2.542 0 00-3.585 0l-6.937 6.938a2.545 2.545 0 000 3.589l34.111 34.114c.99.987 2.602.987 3.588 0l6.938-6.938zM71.252 96.99a2.561 2.561 0 00-1.411-3.33L34.95 79.565a2.563 2.563 0 00-3.326 1.411l-3.662 9.062a2.563 2.563 0 001.414 3.326l34.887 14.1a2.564 2.564 0 003.329-1.414l3.66-9.06zM67.89.209c37.494 0 67.89 30.398 67.89 67.895 0 37.5-30.396 67.896-67.89 67.896S0 105.604 0 68.104C0 30.607 30.396.21 67.89.21zM429.278 0c1.74 0 1.986 1.218 1.679 2.589l-4.636 23.736c-.153 1.37-.939 1.676-2.215 1.676h-11.161c-1.737 0-1.987-1.216-1.679-2.587l4.636-23.735C416.055.309 416.84 0 418.117 0h11.161zM574 49.31c0 1.228-.755 1.831-2.126 1.831h-13.74c3.957 6.867 5.188 14.041 5.188 21.663 0 25.468-17.69 46.67-42.554 46.67-9.148 0-20.278-4.572-25.006-14.028-5.648 7.164-13.272 14.028-25.478 14.028-7.929 0-16.616-2.586-21.048-10.529-6.701 6.712-14.938 10.53-23.48 10.53-25.468 0-28.222-21.356-24.865-40.417l3.86-22.497c-6.095 3.176-15.125 3.176-20.026 2.062 1.228 4.573 1.676 9.146 1.676 13.72 0 24.558-13.717 47.131-40.708 47.131-9.465 0-19.678-4.417-24.403-14.18-5.035 8.84-14.797 14.18-24.712 14.18-7.47 0-15.706-4.125-19.83-12.35-6.864 8.996-17.23 12.35-25.619 12.35-17.691 0-25.008-10.979-25.008-27.914 0-4.42.603-9.148 1.526-14.336l7.18-39.671c.152-1.076.92-1.524 2.135-1.524h12.578c1.505 0 1.678 1.229 1.523 2.14l-7.25 39.515c-3.049 16.475-1.986 26.239 9.61 26.239 10.055 0 17.381-6.867 20.125-22.126l7.942-44.244c.155-1.076.923-1.524 2.139-1.524h12.575c1.508 0 1.678 1.229 1.526 2.14l-7.403 40.426c-1.831 9.608-3.357 25.175 8.392 25.175 8.376 0 13.72-8.392 17.228-27.161l13.72-75.035C329.822.511 330.827 0 331.806 0h12.582c.842 0 1.819.755 1.524 2.129l-7.085 39.251c6.25-3.512 13.412-5.638 20.278-5.638 6.253 0 10.53 1.831 14.795 3.805 14.299 7.1 27.805 3.128 33.748-2.358.717-.725 1.536-1.16 2.594-1.16.287-.002 12.35 0 12.35 0 2.03 0 2.295 1.371 1.987 2.907l-7.522 40.274c-2.281 11.132-2.126 24.56 9.762 24.56 9.913 0 16.474-10.071 19.523-26.086l5.045-25.643h-14.16c-1.522 0-2.446-.755-2.446-2.126V38.321c0-1.523.771-2.292 2.14-2.292h17.586l6.643-34.35C461.305.308 462.09 0 463.365 0h12.285c1.74 0 1.986 1.218 1.678 2.589l-6.484 33.44h18.843c1.381 0 2.139.769 2.139 2.14v11.899c0 1.218-.758 1.973-1.986 1.973h-22.127l-5.358 27.17c-1.833 9.455-3.052 24.56 8.697 24.56 13.117 0 17.692-13.121 19.675-27.302 3.96-28.07 20.74-41.035 43.465-41.035h37.682c1.37 0 2.126.758 2.126 2.14V49.31zM369.935 72.957c0-14.95-7.153-21.663-15.34-21.663-10.957 0-23.08 11.594-23.08 30.966 0 11.747 5.115 21.51 15.632 21.51 11.83 0 22.788-11.902 22.788-30.813zm176.76 0c0-14.95-7.468-21.663-16.012-21.663-11.441 0-24.098 11.594-24.098 30.966 0 11.747 5.343 21.51 16.321 21.51 12.349 0 23.79-11.902 23.79-30.813zm-323.48-26.083l-5.788 8.995c-.77 1.073-1.834 1.228-2.744.615-5.033-2.896-11.13-6.866-20.135-6.866-8.392 0-14.183 2.741-14.183 8.082 0 4.88 1.679 6.406 15.859 12.363 15.257 6.406 22.571 12.044 22.571 25.622 0 17.988-14.795 23.79-30.806 23.79-6.713 0-20.433-.766-31.258-13.271l-3.202-3.665c-.49-.648-.768-1.063-.768-1.678 0-.603.308-1.216.768-1.679l8.685-7.622c.432-.379.923-.603 1.525-.603.46 0 1.073.143 1.524.756 6.866 8.085 13.884 12.21 22.726 12.21 9.76 0 14.038-2.602 14.038-8.238 0-4.277-1.831-6.406-13.27-11.286-17.089-7.175-24.71-12.518-24.71-26.699 0-14.18 11.899-23.944 30.808-23.944 9.3 0 18.905 3.05 27.757 9.303.91.613 1.218 1.37 1.218 1.984 0 .615-.307 1.218-.615 1.83z"
                              fill-rule="evenodd"/>
                    </svg>
                @endif
            @endforeach
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $tire->id }}
    </td>
    @if(auth()->user()->isNotA('customer'))
        @if($field_in_edit == 'rack_identifier')
            <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
                <input
                    type="text"
                    wire:model="field_in_edit_value"
                    class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                />
            </td>
        @else
            <td wire:click="$set('field_in_edit', 'rack_identifier')"
                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $tire->rack_identifier }}
            </td>
        @endif
    @endif
    @if(auth()->user()->isNotA('customer'))
        @if($field_in_edit == 'rack_position')
            <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
                <input
                    type="number"
                    wire:model="field_in_edit_value"
                    class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                />
            </td>
        @else
            <td wire:click="$set('field_in_edit', 'rack_position')"
                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $tire->rack_position }}
            </td>
        @endif
    @endif
    @if(!$edit_lock && $field_in_edit == 'ean')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="text"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'ean')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->ean }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'category')
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <select
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                wire:model="field_in_edit_value"
            >
                @foreach(\App\Enums\TireCategory::getValues() as $value)
                    <option value="{{ $value }}">{{ \App\Enums\TireCategory::getDescription($value) }}</option>
                @endforeach
            </select>
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'category')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ \App\Enums\TireCategory::getDescription($tire->category) }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'width')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="number"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'width')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->width }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'profile')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="number"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'profile')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->profile }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'diameter')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="number"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'diameter')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->diameter }}
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if($tire->is_commercial)
            <i class="bi bi-check-circle text-green-600"></i>
        @else
            <i class="bi bi-x-circle text-red-600"></i>
        @endif
    </td>
    @if(!$edit_lock && $field_in_edit == 'brand')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="text"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'brand')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->brand }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'model')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="text"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'model')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->model }}
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if($tire->millimeters != 0)
            @if ($tire->millimeters_2 != 0)
                {{ $tire->millimeters }} / {{ $tire->millimeters_2 }}
            @else
                {{ $tire->millimeters }}
            @endif
            ({{ $tire->calculateMillimeterPercentage() }}%)
        @else
            -
        @endif
    </td>
    @if(!$edit_lock && $field_in_edit == 'type_id')
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <select
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                wire:model="field_in_edit_value"
            >
                @foreach(\App\Models\Type::get() as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'type_id')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->type->name }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'load_index')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="number"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'load_index')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->load_index }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'speed_index')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="text"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'speed_index')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->speed_index }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'dot')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="text"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'dot')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->dot }}
        </td>
    @endif
    @if(!$edit_lock && $field_in_edit == 'amount')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input
                type="number"
                wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'amount')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $tire->amount }}
        </td>
    @endif
    @if($discount_mode)
        <td class="px-6 py-4 whitespace-nowrap text-sm @if($tire->price_discount) text-red-600 @else text-gray-900 @endif"
            title="{{ $tire->price_full }} €">
            {{ $tire->price }} €
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm @if($tire->price_discount) text-red-600 @else text-gray-900 @endif">
            {{ $tire->price_mounted_and_shipped }} €
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm @if($tire->price_discount) text-red-600 @else text-gray-900 @endif"
        title="{{ $tire->getKijijiPrice(true) }} € | {{ $tire->calculateEbayPrice(true) }} €">
        {{ $tire->getKijijiPrice() }} €<br/>
        <small>{{ $tire->price_ebay }} €</small>
    </td>
    @if($discount_mode)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->created_at->format('d/m/Y') }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            @if($tire->price_discount)
                {{ $tire->price_discount }} €
            @else
                -
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            @if($tire->discount_at)
                {{ $tire->discount_at->format('d/m/Y')}}
            @else
                -
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->number_of_discount }}
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <livewire:tire.table-unified :tire="$tire" :key="time().'-un-'.$tire->id"/>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <livewire:tire.table-images :tire="$tire" :key="time().'-im-'.$tire->id"/>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <livewire:tire.table-actions :tire="$tire" :key="time().'-az-'.$tire->id"/>
    </td>
</tr>
