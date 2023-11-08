<div>
    @if(!$dateNotDefined)
        <div class="grid grid-cols-2 gap-2">
            <input type="date" name="appointment_date" wire:model="appointment_date"
                   class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <select name="appointment_time" wire:model="appointment_time"
                    class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                <option value="">Macchina in aggiunta</option>
                @foreach($available_slots as $available_slot)
                    <option>{{ $available_slot }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <select wire:model="lift_id" name="lift_id" id="lift_id"
                    class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @foreach(\App\Models\Lift::get() as $lift)
                    <option value="{{ $lift->id }}">{{ $lift->name }}</option>
                @endforeach
            </select>
            <select wire:model="amount_of_time_slot" name="amount_of_time_slot" id="amount_of_time_slot"
                    class="mt-1 col-span-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                <option value="1">30m</option>
                <option value="2">1h</option>
                <option value="3">1h 30m</option>
                <option value="4">2h</option>
            </select>
        </div>
    @else
        <input type="hidden" name="appointment_date" id="appointment_date" wire:model="appointment_date" value="">
        <input type="hidden" name="appointment_time" id="appointment_time" value="">
        <input type="hidden" name="amount_of_time_slot" id="amount_of_time_slot" value="1">
        <input type="hidden" name="lift_id" id="lift_id" value="">
    @endif
    <div class="grid grid-cols-2 gap-2">
        <div class="flex items-start mt-2">
            <div class="flex items-center h-5 col-span-1">
                <input wire:model="dateNotDefined" value="1" type="checkbox"
                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <input type="hidden" name="appointmentNotDefined" value="{{ $dateNotDefined ? '1' : '0' }}">
            </div>
            <div class="ml-3 text-sm">
                <label for="appointmentNotDefined" class="font-medium text-gray-700">Non definito</label>
            </div>
        </div>
    </div>
</div>
