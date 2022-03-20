<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StampsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            "user_id"=>"1",
            "date"=>"2022/03/11",
            "start_at"=>"00:00:00",
            "end_at"=>"00:00:10",
        ];
        DB::table("stamps")->insert($param);
    }
}
