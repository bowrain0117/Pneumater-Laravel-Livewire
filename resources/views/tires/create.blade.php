<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Pneumatici</h3>

    <form action="{{ route('tires.store') }}" method="POST">
        @csrf
        <livewire:tire.form />
    </form>
</x-app-layout>
