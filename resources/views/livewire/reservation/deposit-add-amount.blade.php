<div>
    <form action="{{ route('reservations.deposit.store', ['reservation' => $reservation->id]) }}" method="POST">
        <div class="flex space-x-4">
            <input type="hidden" name="id" value="{{ $deposit->id }}" />
            <input type="hidden" name="deposit_id" value="{{ $deposit->id }}" />
            @if (request()->has('redirectToBill'))
                <input type="hidden" name="redirectToBill" value="1">
            @endif
            @csrf
            <div class="flex-1">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>
