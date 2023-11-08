<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">{{ __('Shipment') }} - {{ __('Create') }}</h3>

    <form action="{{ route('shipments.store') }}" method="POST">
        @csrf

        <livewire:shipment.form />
    </form>
</x-app-layout>
