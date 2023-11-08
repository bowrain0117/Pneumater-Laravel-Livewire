<div class="mt-5 md:mt-0 md:col-span-2">
    <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                    <input type="text" name="brand" id="brand" wire:model="brand"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                    <input type="text" name="model" id="model" wire:model="model"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="type_id" class="block text-sm font-medium text-gray-700">Type Id</label>
                    <select name="type_id" id="type_id" wire:model="type_id"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="number" name="category" id="category" wire:model="category"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="width" class="block text-sm font-medium text-gray-700">Width</label>
                    <input type="number" name="width" id="width" wire:model="width"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="profile" class="block text-sm font-medium text-gray-700">Profile</label>
                    <input type="number" name="profile" id="profile" wire:model="profile"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="diameter" class="block text-sm font-medium text-gray-700">Diameter</label>
                    <input type="number" name="diameter" id="diameter" wire:model="diameter"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
                <div class="col-span-6 sm:col-span-3 flex items-center">
                    <input type="checkbox" name="is_commercial" wire:model="is_commercial"
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <div class="ml-3 text-sm">
                        <label for="is_commercial" class="font-medium text-gray-700">Is commercial</label>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" wire:model="amount"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a href="{{ route('deposits.index') }}">
                <button type="button"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
            </a>
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save
            </button>
        </div>
    </div>
</div>
