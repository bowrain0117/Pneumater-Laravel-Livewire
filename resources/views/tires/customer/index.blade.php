<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium mb-3">
        Pneumatici
    </h3>

    <div class="flex flex-col">
        <livewire:tires.customer.table :status="$status" />
    </div>
</x-app-layout>
