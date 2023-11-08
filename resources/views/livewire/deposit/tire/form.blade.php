<div class="px-4 py-5 bg-white space-y-6 sm:p-6">

    <div class="grid grid-cols-6 gap-6">
        <div class="col-span-2 sm:col-span-1">
            <label for="width"
                   class="block text-sm font-medium text-gray-700">{{ __('Measures') }}</label>
            <input type="number" name="width" id="width"
                   wire:model="width" min=1 step=1
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-2 sm:col-span-1">
            <label for="profile"
                   class="block text-sm font-medium text-gray-700">&nbsp</label>
            <input type="number" name="profile" id="profile"
                   wire:model="profile" min=0 step=1
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-2 sm:col-span-1">
            <label for="diameter"
                   class="block text-sm font-medium text-gray-700">&nbsp</label>
            <input type="number" name="diameter" id="diameter"
                   wire:model="diameter" min=1 step=1
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-1">
            <label for="is_commercial" class="block text-sm font-medium text-gray-700">C (Carico)?</label>
            <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <input id="is_commercial" name="is_commercial" type="radio" value="1"
                           wire:model="is_commercial" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                    <label for="is_commercial"
                           class="ml-3 block text-sm font-medium text-gray-700 mr-4">
                        Si
                    </label>
                    <input id="is_commercial" name="is_commercial" type="radio" value="0"
                           wire:model="is_commercial" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                    <label for="is_commercial"
                           class="ml-3 block text-sm font-medium text-gray-700">
                        No
                    </label>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="brand" class="block text-sm font-medium text-gray-700">{{ __('Brand') }}</label>
            <input type="text" name="brand" id="brand"
                   wire:model="brand"
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="model"
                   class="block text-sm font-medium text-gray-700">{{ __('Model') }}</label>
            <input type="text" name="model" id="model"
                   wire:model="model"
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="load_index" class="block text-sm font-medium text-gray-700">{{ __('Load index') }}</label>
            <input type="text" name="load_index" id="load_index"
                   wire:model="load_index"
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="speed_index"
                   class="block text-sm font-medium text-gray-700">{{ __('Speed index') }}</label>
            <input type="text" name="speed_index" id="speed_index"
                   wire:model="speed_index" maxlength="10"
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="type_id"
                   class="block text-sm font-medium text-gray-700">{{ __('Season') }}</label>
            <select id="type_id" name="type_id" wire:model="type_id"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                @foreach (\App\Models\Type::get() as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="millimeters"
                   class="block text-sm font-medium text-gray-700">{{ __('Tread percentage') }}</label>
            <input type="number" name="millimeters" id="millimeters"
                   wire:model="millimeters"
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-1">
            <label for="rack_identifier" class="block text-sm font-medium text-gray-700">Scaffale</label>
            <input type="text" name="rack_identifier" id="rack_identifier"
                   value="{{ $rack_identifier }}"
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-1">
            <label for="rack_position"
                   class="block text-sm font-medium text-gray-700">Posizione</label>
            <input type="number" name="rack_position" id="rack_position"
                   value="{{ $rack_position }}" min=1 step=1
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="col-span-6 sm:col-span-1">
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="amount"
                   class="block text-sm font-medium text-gray-700">{{ __('Amount') }}</label>
            <input type="number" name="amount" id="amount"
                   wire:model="amount"
                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>
    </div>
</div>
