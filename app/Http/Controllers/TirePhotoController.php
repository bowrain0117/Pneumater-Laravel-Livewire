<?php

namespace App\Http\Controllers;

use App\Models\Tire;
use App\Models\TirePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class TirePhotoController extends Controller
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

    public function destroy(TirePhoto $tire_photo)
    {
        foreach ($tire_photo->customPhotos as $customPhoto) {
            Storage::delete($customPhoto->path);
            $customPhoto->delete();
        }

        Storage::delete($tire_photo->path);
        $tire_photo->delete();

        return back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tire_photo' => 'required',
            'tire_id' => 'required|integer',
        ]);

        $allowedfileExtension = ['jpeg', 'jpg', 'png', 'tiff'];

        if ($request->hasFile('tire_photo')) {
            foreach ($request->file('tire_photo') as $file) {
                if (in_array(strtolower($file->getClientOriginalExtension()), $allowedfileExtension)) {
                    $image = $file;
                    $file_name = 'tr_'.time().'_'.rand().'.jpg';

                    $destinationPath = public_path('/storage/tire-photo');
                    $img = Image::make($image->getRealPath());
                    $img->resize(1920, 1920, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode('jpg', 65)->save($destinationPath.'/'.$file_name);

                    TirePhoto::create([
                        'tire_id' => $request->tire_id,
                        'path' => 'public/tire-photo/'.$file_name,
                    ]);
                }
            }

            Tire::find($request->tire_id)->update([
                'process_photo' => 1,
            ]);
        }

        return back();
    }
}
