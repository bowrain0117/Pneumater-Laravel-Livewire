<tr>
    @if($tire)
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-red-100">
            {{ $tire->id }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ $tire->brand . ' ' . $tire->model }}
        </td>
        <td
            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-red-100"
        >
            -
            @foreach($tire->shipments as $shipment)
                {{ $shipment->id }}
            @endforeach
        </td>
        <td
            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-red-100"
        >
            {{ $tire->rack_identifier }} {{ $tire->rack_position }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ \App\Enums\TireStatus::getDescription($tire->status) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            @if($tire->reservations()->count() != 0)
                Prenotazioni:
                @foreach($tire->reservations as $reservation)
                    {{ $reservation->id }}
                @endforeach
            @elseif($tire->shipments()->count() != 0)
                Spedizioni:
                @foreach($tire->shipments as $shipment)
                    {{ $shipment->id }}
                @endforeach
            @else
                -
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
            @if($tire->status != \App\Enums\TireStatus::Sold)
                <button wire:click="moveToSold" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Sposta su venduti">
                    <i class="bi bi-cash-coin"></i>
                </button>
            @endif
            <button wire:click="addToScan" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" title="Ignora errore">
                <i class="bi bi-check-lg"></i>
            </button>
        </td>
    @endif
</tr>
