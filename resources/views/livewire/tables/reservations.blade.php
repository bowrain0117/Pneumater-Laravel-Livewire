<div>
    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">

                    </th>
                    <th wire:click="$set('order_by', 'id')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        #
                        @if($order_by == 'id')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'name')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Nominativo
                        @if($order_by == 'name')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'phone')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Telefono
                        @if($order_by == 'phone')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'email')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        E-mail
                        @if($order_by == 'email')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'status')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Stato
                        @if($order_by == 'status')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'type')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Tipologia
                        @if($order_by == 'type')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'lift_id')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Ponte
                        @if($order_by == 'lift_id')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'appointment_date')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Data appuntamento
                        @if($order_by == 'appointment_date')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'appointment_time')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Ora inizio appuntamento
                        @if($order_by == 'appointment_time')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'appointment_time')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Ora fine appuntamento
                        @if($order_by == 'appointment_time')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'note')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Note
                        @if($order_by == 'note')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'price')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Prezzo
                        @if($order_by == 'price')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'deposit')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Acconto
                        @if($order_by == 'deposit')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'created_by')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Creata da
                        @if($order_by == 'created_by')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'source')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Sorgente
                        @if($order_by == 'source')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th wire:click="$set('order_by', 'created_at')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        Data inserimento
                        @if($order_by == 'created_at')
                            <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                        @endif
                    </th>
                    <th scope="col" class="relative px-6 py-3 text-right bg-gray-100">

                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="number"
                               wire:model="identifier"
                               wire:keydown.enter="storeIdentifier"
                               min=1
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        @foreach($storedIdentifiers as $storedIdentifier)
                            <span wire:click="removeIdentifier({{ $storedIdentifier }})" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $storedIdentifier }}</span>
                        @endforeach
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="name"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="phone"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="email"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <select
                            class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            wire:model="status"
                        >
                            <option></option>
                            @foreach(\App\Enums\ReservationStatus::getValues() as $status_key)
                                <option value="{{ $status_key }}">{{ \App\Enums\ReservationStatus::getDescription($status_key) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <select
                            class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            wire:model="type"
                        >
                            <option></option>
                            @foreach(\App\Enums\ReservationType::getValues() as $status_key)
                                <option value="{{ $status_key }}">{{ \App\Enums\ReservationType::getDescription($status_key) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <select
                            class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            wire:model="lift_id"
                        >
                            <option></option>
                            @foreach(\App\Models\Lift::get() as $lift)
                                <option value="{{ $lift->id }}">{{ $lift->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="date"
                               wire:model="appointment_date_from"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <input type="date"
                               wire:model="appointment_date_to"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <select
                            class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            wire:model="appointment_time_type"
                        >
                            <option></option>
                            <option value="1">Mattino</option>
                            <option value="2">Pomeriggio</option>
                        </select>
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                        <input type="date"
                               wire:model="create_at_from"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <input type="date"
                               wire:model="create_at_to"
                               min=0
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">

                    </td>
                </tr>
                @foreach($reservations as $reservation)
                    <livewire:tables.reservation-row :reservation="$reservation" :key="$reservation->id" />
                @endforeach
            </tbody>
        </table>

        <div class="pr-4 pl-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
