<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">{{ __('User') }} - {{ __('Edit') }}</h3>

    <form action="{{ route('admin.users.update', ['user' => $user ]) }}" method="POST" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
        <input type="hidden" name="id" value="{{ $user->id }}">
        @csrf

        <livewire:users.form :user="$user"/>
    </form>
</x-app-layout>
