<div>
    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
            <tr>
                <th wire:click="$set('order_by', 'name')" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Name') }}
                    @if($order_by == 'name')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Customers') }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Rules') }}
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($priceLists as $priceList)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $priceList->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $priceList->users()->count() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $priceList->rules()->count() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <a href="{{ route('admin.price-list.edit', ['price_list' => $priceList]) }}">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </a>
                        @if($priceList->users()->count() > 0)
                            <button
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                disabled>
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        @else
                            <div x-data="{ showModal : false }" class="inline">
                                <!-- Button -->
                                <button
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded"
                                    @click="showModal = !showModal">
                                    <i class="bi bi-trash-fill"></i>
                                </button>

                                <!-- Modal Background -->
                                <div x-show="showModal"
                                     class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                                     x-transition:enter="transition ease duration-300"
                                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease duration-300"
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
                                        <span
                                            class="font-bold block text-2xl mb-3">Eliminazione "{{ $priceList->name }}"</span>
                                        <p>Sei sicuro di voler eliminare il listino "{{ $priceList->name }}"?
                                            L'operazione è
                                            irreversibile</p>

                                        <!-- Buttons -->
                                        <div class="text-right space-x-5 mt-5">
                                            <form
                                                action="{{ route('admin.price-list.destroy', $priceList) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button @click="showModal = !showModal" type="button"
                                                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">
                                                    {{ __('Cancel') }}
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
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $priceLists->links() }}
    </div>
</div>
