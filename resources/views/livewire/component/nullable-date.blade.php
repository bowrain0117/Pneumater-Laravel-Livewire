<div>
    @if(!$dateNotDefined)
        <div class="grid {{$show_time ? 'grid-cols-2' : 'grid-cols-1' }} gap-2">
            <input type="date" name="{{ $name_date }}" id="{{ $name_date }}" wire:model="value_date"
                   value="{{ $value_date }}"
                   class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @if($show_time)
                <input type="time" name="{{ $name_time }}" id="{{ $name_time }}" wire:model="value_time"
                       value="{{ $value_time }}"
                       class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @endif
        </div>
    @else
        <input type="hidden" name="{{ $name_date }}" id="{{ $name_date }}" value="">
        @if($show_time)
            <input type="hidden" name="{{ $name_time }}" id="{{ $name_time }}" value="">
        @endif
    @endif
    <div class="flex items-start mt-2">
        <div class="flex items-center h-5">
            <input wire:model="dateNotDefined" name="dateNotDefined" value="1" type="checkbox"
                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
            <input type="hidden" name="{{ $name_not_defined }}" value="{{ $dateNotDefined ? '1' : '0' }}">
        </div>
        <div class="ml-3 text-sm">
            <label for="{{ $name_not_defined }}" class="font-medium text-gray-700">Non definito</label>
        </div>
    </div>
</div>
