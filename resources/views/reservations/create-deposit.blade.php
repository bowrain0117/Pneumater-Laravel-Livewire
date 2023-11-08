<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Deposit - Create</h3>

    <form action="{{ route('reservations.storeDeposit', ['reservation' => $reservation]) }}" method="POST">
        @csrf
        <livewire:reservation.create-deposit :tires="$tires" :reservation="$reservation" />
    </form>
</x-app-layout>
