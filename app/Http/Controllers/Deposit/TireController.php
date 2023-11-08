<?php

namespace App\Http\Controllers\Deposit;

use App\Enums\TireStatus;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Tire;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Deposit $deposit): Renderable
    {
        return view('deposits.tires.create', compact('deposit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Deposit $deposit)
    {
        $validated = $request->validate([
            'width' => 'required|integer',
            'profile' => 'required|integer',
            'diameter' => 'required|integer',
            'brand' => 'required|string|max:250',
            'model' => 'required|string|max:250',
            'type_id' => 'required',
            'load_index' => 'required|string|max:20',
            'speed_index' => 'required|string|max:2',
            'is_commercial' => 'required|boolean',
            'amount' => 'required|integer',
            'millimeters' => 'required|integer',
            'rack_identifier' => 'required',
            'rack_position' => 'required|integer',
        ]);

        $tire = new Tire;
        $tire->fill($validated);
        $tire->fill([
            'category' => 1,
            'millimeters_2' => 0,
            'millimeters_new_by_manufacturer' => 0,
            'price' => 0,
            'number_of_discount' => 0,
            'price_ebay' => 0,
            'status' => TireStatus::Deposit,
            'unified' => 0,
            'process_photo' => 0,
        ]);
        $tire->save();

        $deposit->tires()->attach($tire);

        return redirect()->route('deposits.edit', $deposit);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deposit $deposit, Tire $tire): Renderable
    {
        return view('deposits.tires.edit', compact('deposit', 'tire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deposit $deposit, Tire $tire)
    {
        $validated = $request->validate([
            'width' => 'required|integer',
            'profile' => 'required|integer',
            'diameter' => 'required|integer',
            'brand' => 'required|string|max:250',
            'model' => 'required|string|max:250',
            'type_id' => 'required',
            'load_index' => 'required|string|max:20',
            'speed_index' => 'required|string|max:2',
            'is_commercial' => 'required|boolean',
            'amount' => 'required|integer',
            'millimeters' => 'required|integer',
            'rack_identifier' => 'required',
            'rack_position' => 'required|integer',
        ]);

        $tire->fill($validated);
        $tire->save();

        return redirect()->route('deposits.edit', $deposit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deposit $deposit, Tire $tire)
    {
        $deposit->tires()->detach($tire);
        $tire->delete();

        return redirect()->route('deposits.edit', $deposit);
    }
}
