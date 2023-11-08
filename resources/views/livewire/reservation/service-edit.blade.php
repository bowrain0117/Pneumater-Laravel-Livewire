<div>
    <div class="grid grid-cols-6 gap-6">
        <div class="col-span-6 sm:col-span-3">
            <label for="amount"
                   class="block text-sm font-medium text-gray-700">Quantità</label>
            <input type="number" id="amount" name="amount" step="1" min="1"
                   class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   wire:model="amount"
            >
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="price_override"
                   class="block text-sm font-medium text-gray-700">{{ __('Price override') }}</label>
            <input type="number" id="price_override" name="price_override" step="0.01" wire:model="price_override"
                   class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
        </div>
    </div>
</div>
