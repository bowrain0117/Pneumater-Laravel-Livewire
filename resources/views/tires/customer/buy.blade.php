<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">
        {{ __('Buy') }}
    </h3>

    <livewire:tires.buy-form :tires="$tires"/>
</x-app-layout>
