<?php

namespace App\Http\Controllers;

use App\Models\Lift;
use Illuminate\Http\Request;

class LiftController extends Controller
{
    public function index()
    {
        return view('lifts.index');
    }

    public function create()
    {
        return view('lifts.create');
    }

    public function edit(Lift $lift)
    {
        return view('lifts.edit', ['lift' => $lift]);
    }

    public function destroy(Lift $lift)
    {
        $lift->delete();

        return redirect()->route('lifts.index');
    }

    public function update(Request $request, Lift $lift)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        $lift->fill($validated);
        $lift->save();

        return redirect()->route('lifts.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        Lift::create($validated);

        return redirect()->route('lifts.index');
    }
}
