<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Deposit - Edit</h3>

    <form action="{{ route('deposits.update', ['deposit' => $deposit->id, 'reservation' => $reservation]) }}"
        method="POST">
        <input name="_method" type="hidden" value="PUT">
        @csrf
        <livewire:deposit.form :deposit="$deposit" :reservation="$reservation" />
    </form>
    <div class="mt-4">
        <div>
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Pneumatici</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Pneumatici collegati alla spedizione.
                        </p>
                        @if ($errors->any())
                            <div class="mt-2a">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="bg-white overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Measures') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Load') }} - {{ __('Speed') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Season') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Description') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Amount') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Position') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Tread percentage') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-right">
                                            <a href="{{ route('deposits.tires.create', ['deposit' => $deposit]) }}"
                                                class="text-indigo-600 hover:text-indigo-900">{{ __('Add') }}</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($deposit->tires as $tire)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tire->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tire->width . ($tire->profile != 0 ? ' ' . $tire->profile : '') . ' ' . $tire->diameter . ($tire->is_commercial == 1 ? 'C' : '') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tire->load_index }} {{ $tire->speed_index }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tire->type->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tire->brand }} {{ $tire->model }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tire->amount }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tire->rack_identifier }} {{ $tire->rack_position }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $tire->millimeters }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a
                                                    href="{{ route('deposits.tires.edit', ['deposit' => $deposit, 'tire' => $tire]) }}">
                                                    <button
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </a>
                                                <div x-data="{ showModal: false }">
                                                    <!-- Button -->
                                                    <button
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                                        @click="showModal = !showModal">
                                                        <svg class="fill-current w-4 h-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>

                                                    <!-- Modal Background -->
                                                    <div x-show="showModal"
                                                        class="text-left fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                                        x-transition:enter="transition ease duration-300"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="transition ease duration-300"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0">
                                                        <!-- Modal -->
                                                        <div x-show="showModal"
                                                            class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10"
                                                            @click.away="showModal = false"
                                                            x-transition:enter="transition ease duration-100 transform"
                                                            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave="transition ease duration-100 transform"
                                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                                            <span class="font-bold block text-2xl mb-3">Eliminazione
                                                                pneumatici</span>
                                                            <p>Sei sicuro di voler eliminare gli pneumatici?
                                                                L'operazione è
                                                                irreversibile</p>

                                                            <!-- Buttons -->
                                                            <div class="text-right space-x-5 mt-5">
                                                                <form
                                                                    action="{{ route('deposits.tires.destroy', ['deposit' => $deposit, 'tire' => $tire]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button @click="showModal = !showModal"
                                                                        type="button"
                                                                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                                                        Cancel
                                                                    </button>
                                                                    <button
                                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                                                                        Elimina
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
