<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendedor;

class VendedoresSeeder extends Seeder
{

    public function run()
    {
        Vendedor::factory(5)->create();
    }
}
