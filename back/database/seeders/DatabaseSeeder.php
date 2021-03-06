<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserTypesSeeder::class,
            UserSeeder::class,

            SupplierSeeder::class,
            ProductSeeder::class,

            MtProductSupplierSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
