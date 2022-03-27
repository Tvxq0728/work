<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // seeder
        $this->call(StampsTableSeeder::class);
        // factory
        \App\Models\User::factory(6)->create();
    }
}
