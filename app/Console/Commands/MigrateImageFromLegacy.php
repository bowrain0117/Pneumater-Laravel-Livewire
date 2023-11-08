<?php

namespace App\Console\Commands;

use App\Models\Tire;
use App\Models\TirePhoto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MigrateImageFromLegacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legacy:migrate-photo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "Fetching pictures...\n";

        $photos = DB::connection('lagacy-mysql')->table('tires_photo')->get();

        echo 'Found '.$photos->count()." pictures\n";

        echo "Migrating...\n";

        foreach ($photos as $photo) {
            $tire = Tire::find($photo->tire_id);
            if ($tire) {
                $url = 'https://pneumater-legacy.pneumaticiadriatica.it/'.$photo->photo_path;
                $contents = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                Storage::put('public/tire-photo/'.$name, $contents);

                TirePhoto::create([
                    'tire_id' => $tire->id,
                    'path' => 'public/tire-photo/'.$name,
                ]);
            }
        }

        echo "Migration completed\n";

        return 0;
    }
}
