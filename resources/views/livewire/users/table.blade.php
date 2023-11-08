<div>
    <div class="overflow-x-auto rounded-t-xl bg-white mt-2">
        <table class="w-full divide-y divide-gray-200 p-2">
            <thead class="bg-gray-50">
            <tr>
                <th wire:click="$set('order_by', 'name')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Name') }}
                    @if($order_by == 'id')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th wire:click="$set('order_by', 'email')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Email') }}
                    @if($order_by == 'rack_identifier')
                        <i class="bi bi-caret-{{ $order_direction == 'DESC' ? 'up' : 'down' }}-square-fill"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Role') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                    {{ __('Actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="name"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                        <input type="text"
                               wire:model="email"
                               class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100">
                        <select
                            class="m-1 text-sm leading-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            wire:model="role"
                        >
                            <option value="">-</option>
                            @foreach(\Silber\Bouncer\Database\Role::orderBy('name','ASC')->get() as $role)
                                <option>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-1 py-1 whitespace-nowrap text-sm text-center text-gray-900 bg-blue-100"></td>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->getRoles()->implode(' ') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <a href="{{ route('admin.users.edit', ['user' => $user]) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                            </a>
                            @if($user->isA('customer'))
                                @if($user->registry_id)
                                    <a href="{{ route('registries.edit', $user->registry) }}">
                                        <button class="bg-green-500 hover:bg-green-700 border-green-700 border text-white font-bold py-2 px-4 rounded">
                                            <i class="bi bi-person-rolodex"></i>
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('registries.create', ['user_id' => $user]) }}">
                                        <button class="bg-yellow-500 hover:bg-yellow-700 border-yellow-700 border text-white font-bold py-2 px-4 rounded">
                                            <i class="bi bi-person-rolodex"></i>
                                        </button>
                                    </a>
                                @endif
                            @endif
                            <div x-data="{ showModal : false }" class="inline">
                                <!-- Button -->
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="showModal = !showModal">
                                    <i class="bi bi-trash-fill"></i>
                                </button>

                                <!-- Modal Background -->
                                <div x-show="showModal" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                    <!-- Modal -->
                                    <div x-show="showModal" class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 mx-10" @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                                        <span class="font-bold block text-2xl mb-3">Eliminazione "{{ $user->name }}"</span>
                                        <p>Sei sicuro di voler eliminare l'utente "{{ $user->name }}"? L'operazione è irreversibile</p>

                                        <!-- Buttons -->
                                        <div class="text-right space-x-5 mt-5">
                                            <form action="{{ route('admin.users.destroy', ['user' => $user]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button @click="showModal = !showModal" type="button" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
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
                @endforeach
            </tbody>
        </table>
    </div>
</div>
