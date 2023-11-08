<div>
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white p-4 text-center">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">ID</label>
                    <input type="number" step="1" wire:model="identifier"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Telephone</label>
                    <input type="text" wire:model="phone"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="text" wire:model="email"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Car Model</label>
                    <input type="text" wire:model="car_model"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-1">
                    <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Plate</label>
                    <input type="text" wire:model="license_plate"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
        </div>
    </div>
    <table class="min-w-full divide-y divide-gray-200 mt-2">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    #
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Telephone
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    E-mail
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Car Model
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Plate
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Note
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($deposit_list as $deposit)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $deposit->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $deposit->registry->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $deposit->registry->phone }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $deposit->registry->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $deposit->car_model }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $deposit->license_plate }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $deposit->note }}
                    </td>

                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <livewire:reservation.deposit-add-amount :reservation="$reservation" :deposit="$deposit"
                            :key="time() . $deposit->id" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
