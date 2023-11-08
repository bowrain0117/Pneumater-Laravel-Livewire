<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! Type::where('name', 'Estiva')->first()) {
            Type::create([
                'name' => 'Estiva',
            ]);
        }

        if (! Type::where('name', 'Invernale')->first()) {
            Type::create([
                'name' => 'Invernale',
            ]);
        }

        if (! Type::where('name', '4 Stagioni')->first()) {
            Type::create([
                'name' => '4 Stagioni',
            ]);
        }

        if (! Type::where('name', 'Estiva (m+s)')->first()) {
            Type::create([
                'name' => 'Estiva (m+s)',
            ]);
        }
    }
}
