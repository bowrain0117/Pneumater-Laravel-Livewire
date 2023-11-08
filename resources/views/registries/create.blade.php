<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">{{ __('Registry') }}</h3>

    <form action="{{ route('registries.store') }}" method="POST">
        @csrf
        <livewire:registry.form :role="$role"/>

        @if(request()->get('user_id'))
            <input type="hidden" name="user_id" value="{{ request()->get('user_id') }}">
        @endif
    </form>
</x-app-layout>
