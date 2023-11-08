<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium mb-3">
        Scan - {{ $storageScan->name }}
    </h3>
    <livewire:tables.storage-scan :storageScan="$storageScan" />
    <h3 class="text-gray-700 text-3xl font-medium mt-3 mb-3">
        Pneumatici non scansionati
    </h3>
    <livewire:tables.storage-not-scanned :storageScan="$storageScan" />
</x-app-layout>
