<?php

namespace App\Console\Commands;

use App\Models\Tire;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProcessCustomTirePhoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:custom-tire-photo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Tire::where('process_photo', 1)->get() as $tire) {
            foreach (User::where('watermark_path', '!=', null)->get() as $user) {
                $watermark = Image::make(str_replace('public/', 'public/storage/', $user->watermark_path));
                try {
                    mkdir('public/storage/custom-tire-photo/'.$user->id.'/');
                } catch (\Exception $e) {
                }

                $photo = $tire->photos->first();

                foreach ($photo->customPhotos as $customPhoto) {
                    Storage::delete($customPhoto->path);
                    $customPhoto->delete();
                }

                if ($photo) {
                    $custom_image = Image::make(str_replace('public/', 'public/storage/', $photo->path));

                    $watermark->resize($custom_image->width(), $custom_image->height());

                    $image_name = explode('/', $photo->path);

                    $custom_image->insert($watermark);
                    $custom_image->save('public/storage/custom-tire-photo/'.$user->id.'/'.end($image_name));

                    $photo->customPhotos()->create([
                        'user_id' => $user->id,
                        'path' => 'public/custom-tire-photo/'.$user->id.'/'.end($image_name),
                    ]);
                }
            }

            $tire->process_photo = 0;
            $tire->save();
        }
    }
}
