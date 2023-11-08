<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">{{ __('Registry') }} - Modifica</h3>

    <form action="{{ route('registries.update', ['registry' => $registry ]) }}" method="POST">
        <input name="_method" type="hidden" value="PUT">
        <input type="hidden" name="id" value="{{ $registry->id }}">
        @csrf

        <livewire:registry.form :role="$role" :registry="$registry"/>
    </form>
</x-app-layout>
