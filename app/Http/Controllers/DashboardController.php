<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        if ($request->user()->isA('customer')) {
            return view('customer.dashboard');
        }

        return view('dashboard');
    }
}
