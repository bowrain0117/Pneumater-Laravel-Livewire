<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Bouncer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Renderable
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|integer|min:1',
            'password' => 'required|confirmed|min:6',
            'price_list_id' => 'nullable|exists:price_lists,id',
            'default_courier' => 'nullable|integer',
            'customer_type' => 'nullable|integer',
            'ebay_auth_token' => 'nullable|string',
        ]);

        $user = User::create($validated);
        $user->password = bcrypt($validated['password']);
        $user->save();
        Bouncer::sync($user)->roles($request->input('role'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Renderable
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required|integer|min:1',
            'price_list_id' => 'nullable|exists:price_lists,id',
            'default_courier' => 'nullable|integer',
            'customer_type' => 'nullable|integer',
            'lock_price_edit' => 'required|boolean',
            'ebay_auth_token' => 'nullable|string',
        ]);

        $allowedfileExtension = ['jpeg', 'jpg', 'png', 'tiff'];

        $user->update($validated);
        Bouncer::sync($user)->roles($request->input('role'));

        if ($request->hasFile('watermark')) {
            $image = $request->file('watermark');
            if (in_array(strtolower($image->getClientOriginalExtension()), $allowedfileExtension)) {
                if ($user->watermark_path) {
                    Storage::delete($user->watermark_path);
                    $user->watermark_path = null;
                    $user->save();
                }

                $destinationPath = public_path('/storage/watermark');
                $img = Image::make($image->getRealPath());
                $img->resize(1920, 1920, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('png', 65)->save($destinationPath.'/wtm_'.$user->id.'.png');

                $user->watermark_path = 'public/watermark/wtm_'.$user->id.'.png';
                $user->save();
            }
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
