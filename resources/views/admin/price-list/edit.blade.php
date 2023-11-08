<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">{{ __('Price list') }} - {{ __('Edit') }}</h3>

    <livewire:price-list.form :priceList="$priceList"/>
</x-app-layout>
