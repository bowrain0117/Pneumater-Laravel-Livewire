<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium mb-3">
        {{ __('Registries') }} {{ \App\Enums\RegistryRoleType::getDescription($role) }}
        <a href="{{ route('registries.create', ['role' => $role]) }}">
            <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded">
                <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
            </button>
        </a>
    </h3>

    <div class="flex flex-col">
        <livewire:registry.table :role="$role" />
    </div>
</x-app-layout>
