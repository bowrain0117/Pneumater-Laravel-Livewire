<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Deposit - Add</h3>

    <form action="{{ route('deposits.store') }}" method="POST">
        @csrf
        <livewire:deposit.form />
    </form>
</x-app-layout>
