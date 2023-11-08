<tr>
    <td wire:click="alternateLockStatus" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
        @if ($edit_lock)
            <i class="bi bi-lock-fill"></i>
        @else
            <i class="bi bi-unlock-fill"></i>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $reservation->id }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        @if ($reservation->registry && $reservation->registry->type == \App\Enums\RegistryType::PRIVATE)
            {{ $reservation->registry->name }} {{ $reservation->registry->surname }}
        @elseif($reservation->registry && $reservation->registry->type == \App\Enums\RegistryType::COMPANY)
            {{ $reservation->registry->denomination }}
        @else
            {{ $reservation->name }}
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        @if ($reservation->registry)
            {{ $reservation->registry->phone }}
            @if ($reservation->registry->phone && $reservation->registry->cellular)
                <br />
            @endif
            {{ $reservation->registry->cellular }}
        @else
            {{ $reservation->phone }}
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        @if ($reservation->registry)
            {{ $reservation->registry->email }}
        @else
            {{ $reservation->email }}
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if ($reservation->status)
            {{ \App\Enums\ReservationStatus::getDescription($reservation->status) }}
        @else
            -
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if ($reservation->type)
            {{ \App\Enums\ReservationType::getDescription($reservation->type) }}
        @else
            -
        @endif
    </td>
    @if (!$edit_lock && $field_in_edit == 'lift_id' && $reservation->status != \App\Enums\ReservationStatus::ToBeConfirmed)
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <select wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                @foreach (\App\Models\Lift::get() as $lift)
                    <option value="{{ $lift->id }}">{{ $lift->name }}</option>
                @endforeach
            </select>
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'lift_id')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $reservation->lift->name ?? '-' }}
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $reservation->appointment_date ? $reservation->appointment_date->format('d/m/Y') : '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if ($reservation->appointment_time)
            {{ $reservation->appointment_time }}
        @elseif($reservation->appointment_date)
            Macchina in aggiunta
        @else
            -
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        @if ($reservation->appointment_time)
            {{ (new \Carbon\Carbon($reservation->appointment_time))->add(30 * $reservation->amount_of_time_slot, 'minute')->format('H:i:s') }}
        @elseif($reservation->appointment_date)
            Macchina in aggiunta
        @else
            -
        @endif
    </td>
    @if (!$edit_lock && $field_in_edit == 'note')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input type="text" wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'note')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $reservation->note }}
        </td>
    @endif
    @if (!$edit_lock && $field_in_edit == 'price')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input type="number" min="0" wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'price')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $reservation->price . ' €' }}
            @if ($reservation->deposit > 0)
                <br />(Rimanenti: {{ $reservation->price - $reservation->deposit }} €)
            @endif
        </td>
    @endif
    @if (!$edit_lock && $field_in_edit == 'deposit')
        <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">
            <input type="number" min="0" wire:model="field_in_edit_value"
                class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
        </td>
    @else
        <td wire:click="$set('field_in_edit', 'deposit')" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $reservation->deposit . ' €' }}
        </td>
    @endif
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $reservation->createdBy->name }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $reservation->source }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $reservation->created_at->format('d/m/Y') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <x-reservation.modal-info :reservation="$reservation" />
        <div x-data="{ showModal: false }">
            <!-- Button -->
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                @click="showModal = !showModal">
                <i class="bi bi-card-checklist"></i>
            </button>

            <!-- Modal Background -->
            <div x-show="showModal"
                class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <!-- Modal -->
                <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                    @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease duration-100 transform"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                    <span class="font-bold block text-2xl mb-3">Create a new deposit</span>
                    <p>Are you sure you want to create a depoist?</p>

                    <!-- Buttons -->
                    <div class="text-right space-x-5 mt-5">
                        <a href="{{ route('reservations.createDeposit', ['reservation' => $reservation]) }}">
                            <button @click="showModal = !showModal" type="button"
                                class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                Create
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('reservations.edit', ['reservation' => $reservation]) }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                <i class="bi bi-pencil-fill"></i>
            </button>
        </a>
        <a href="{{ route('reservations.bill', ['reservation' => $reservation]) }}">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                <i class="bi bi-file-earmark-arrow-down"></i>
            </button>
        </a>
        @if ($reservation->status == \App\Enums\ReservationStatus::Confirmed)
            <a href="{{ route('reservations.print', ['reservation' => $reservation]) }}">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                    title="Stampa">
                    <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </a>
        @endif
        @if ($reservation->status == \App\Enums\ReservationStatus::PartiallyProcessed)
            <button wire:click="prepareForPayment"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                <i class="bi bi-wallet-fill"></i>
            </button>
        @endif
        @if ($reservation->status == \App\Enums\ReservationStatus::Processed)
            <button wire:click="conclude"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        @endif
        <div x-data="{ showModal: false }">
            <!-- Button -->
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                @click="showModal = !showModal">
                <i class="bi bi-trash-fill"></i>
            </button>

            <!-- Modal Background -->
            <div x-show="showModal"
                class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <!-- Modal -->
                <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                    @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease duration-100 transform"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                    <span class="font-bold block text-2xl mb-3">Eliminazione #{{ $reservation->id }}</span>
                    <p>Sei sicuro di voler eliminare la prenotazione #{{ $reservation->id }}? L'operazione è
                        irreversibile</p>

                    <!-- Buttons -->
                    <div class="text-right space-x-5 mt-5">
                        <form action="{{ route('reservations.destroy', ['reservation' => $reservation]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button @click="showModal = !showModal" type="button"
                                class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                Elimina
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
