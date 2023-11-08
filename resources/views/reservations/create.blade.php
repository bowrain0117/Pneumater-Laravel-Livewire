<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Prenotazione - {{ __('Create') }}</h3>

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <livewire:reservation.form />
    </form>
</x-app-layout>
