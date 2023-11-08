<?php

namespace App\Console\Commands;

use App\Enums\TireStatus;
use App\Models\Tire;
use Illuminate\Console\Command;

class RecalculatePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate ebay price';

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
        $tires = Tire::where('status', TireStatus::Available)->get();
        foreach ($tires as $tire) {
            $tire->recalculatePrices();
            $tire->save();
        }

        return 0;
    }
}
