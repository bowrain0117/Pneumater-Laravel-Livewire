<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">{{ __('User') }} - {{ __('Create') }}</h3>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <livewire:users.form />
    </form>
</x-app-layout>
