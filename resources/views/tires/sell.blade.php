<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">
        Vendita
    </h3>

    <form action="{{ route('tires.sellSubmit') }}" method="POST">
        @csrf

        <livewire:tire.sell-form :tires="$tires"/>
    </form>
</x-app-layout>
