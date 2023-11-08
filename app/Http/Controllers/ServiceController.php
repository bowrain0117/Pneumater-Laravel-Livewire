<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('verified');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('services.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Service $service)
    {
        return view('services.edit', ['service' => $service]);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back();
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'description' => 'sometimes|nullable|string',
            'price' => 'required|numeric',
            'amount_of_time_slot' => 'required|int',
        ]);

        Service::create($validate);

        return redirect(route('services.index'));
    }

    public function update(Request $request, Service $service)
    {
        $validate = $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'description' => 'sometimes|nullable|string',
            'price' => 'required|numeric',
            'amount_of_time_slot' => 'required|int',
        ]);

        $service->fill($validate);
        $service->save();

        return redirect(route('services.index'));
    }
}
