<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("class")->insert([
            [
                'name' => 'A Kecil',
                'unit_id' => '1'
            ],
            [
                'name' => 'A Besar',
                'unit_id' => '1'
            ],
            [
                'name' => 'B Kecil',
                'unit_id' => '2'
            ],
            [
                'name' => 'B Besar',
                'unit_id' => '2'
            ],
        ]);
    }
}
