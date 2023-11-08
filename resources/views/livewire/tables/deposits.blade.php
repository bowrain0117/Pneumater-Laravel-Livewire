<div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    #
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Denomination') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Phone') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('E-mail') }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Car model') }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('License plate') }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Notes') }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Status') }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="number" wire:model="identifier" wire:keydown.enter="storeIdentifier" min=1
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text" wire:model="name"
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text" wire:model="phone"
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text" wire:model="email"
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text" wire:model="car_model"
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                    <input type="text" wire:model="license_plate"
                        class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                </td>
                <td class="px-1 py-1 whitespace-nowrap text-sm text-gray-900 bg-blue-100">
                </td>
            </tr>
            @foreach ($deposits as $deposit)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $deposit->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($deposit->registry && $deposit->registry->type == \App\Enums\RegistryType::PRIVATE)
                            {{ $deposit->registry->name }} {{ $deposit->registry->surname }}
                        @elseif($deposit->registry && $deposit->registry->type == \App\Enums\RegistryType::COMPANY)
                            {{ $deposit->registry->denomination }}
                        @else
                            N/A
                        @endif
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($deposit->registry)
                            {{ $deposit->registry->phone }}
                            @if ($deposit->registry->phone && $shipment->registry->cellular)
                                <br />
                            @endif
                            {{ $deposit->registry->cellular }}
                        @else
                            N/A
                        @endif
                    </td> --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($deposit->registry)
                            {{ $deposit->registry->email }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $deposit->car_model }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $deposit->license_plate }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $deposit->note }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($deposit->status == 1)
                            Available
                        @elseif ($deposit->status == 2)
                            Mounted
                        @elseif ($deposit->status == 3)
                            Picked up
                        @elseif ($deposit->status == 4)
                            Scraped
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <a href="{{ route('deposits.edit', $deposit->id) }}">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </a>
                        <div x-data="{ showModal: false }" class="inline">
                            <!-- Button -->
                            <button
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
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
                                    @click.away="showModal = false"
                                    x-transition:enter="transition ease duration-100 transform"
                                    x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease duration-100 transform"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                    <span class="font-bold block text-2xl mb-3">Eliminazione</span>
                                    <p>Are you sure you permanently delete this file?</p>

                                    <!-- Buttons -->
                                    <div class="text-right space-x-5 mt-5">
                                        <form action="{{ route('deposits.destroy', $deposit->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button @click="showModal = !showModal" type="button"
                                                class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                                Cancel
                                            </button>
                                            <button
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
