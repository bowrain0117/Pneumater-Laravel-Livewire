<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 @if($scanTire->tire) bg-green-100 @else bg-red-100 @endif">
        {{ $scanTire->tire_id }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $scanTire->tire ? $scanTire->tire->brand . ' ' . $scanTire->tire->model : '-' }}
    </td>
    <td
        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 @if($scanTire->tire && $scanTire->tire->rack_identifier == $scanTire->rack_identifier && $scanTire->tire->rack_position == $scanTire->rack_position) bg-green-100 @else bg-red-100 @endif"
    >
        {{ $scanTire->rack_identifier }} {{ $scanTire->rack_position }}
    </td>
    <td
        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 @if($scanTire->tire && $scanTire->tire->rack_identifier == $scanTire->rack_identifier && $scanTire->tire->rack_position == $scanTire->rack_position) bg-green-100 @else bg-red-100 @endif"
    >
        {{ $scanTire->tire ? $scanTire->tire->rack_identifier : '' }} {{ $scanTire->tire ? $scanTire->tire->rack_position : '-' }}
    </td>
    <td
        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center"
    >
        @if($scanTire->tire && ($scanTire->tire->rack_identifier != $scanTire->rack_identifier || $scanTire->tire->rack_position != $scanTire->rack_position))
            <button wire:click="updatePosition" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Copia posizione da scansione">
                <i class="bi bi-clipboard-data"></i>
            </button>
            <button wire:click="updateScanPosition" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Conferma posizione database">
                <i class="bi bi-check-lg"></i>
            </button>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 @if($scanTire->tire && $scanTire->tire->status != \App\Enums\TireStatus::Sold || $scanTire->ignore_status) bg-green-100 @else bg-red-100 @endif">
        {{ $scanTire->tire ? \App\Enums\TireStatus::getDescription($scanTire->tire->status) : '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
        @if($scanTire->tire && $scanTire->tire->status != \App\Enums\TireStatus::Sold)
            <button wire:click="moveToSold" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Sposta su venduti">
                <i class="bi bi-cash-coin"></i>
            </button>
        @endif
        @if($scanTire->tire && $scanTire->tire->status == \App\Enums\TireStatus::Sold)
            <button wire:click="moveToAvailable" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Sposta su disponibili">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        @endif
        @if($scanTire->tire && $scanTire->tire->status == \App\Enums\TireStatus::Sold && !$scanTire->ignore_status)
            <button wire:click="disableStatusError" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Ignora errore di stato">
                <i class="bi bi-check-lg"></i>
            </button>
        @endif
    </td>
</tr>
