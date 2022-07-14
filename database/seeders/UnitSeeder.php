<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("unit")->insert([
            [
                'name' => 'TK',
                'grade' => 'A'
            ],
            [
                'name' => 'TK',
                'grade' => 'B'
            ],
            [
                'name' => 'SD',
                'grade' => '1'
            ],
            [
                'name' => 'SD',
                'grade' => '2'
            ],
            [
                'name' => 'SD',
                'grade' => '3'
            ],
            [
                'name' => 'SD',
                'grade' => '4'
            ],
            [
                'name' => 'SD',
                'grade' => '5'
            ],
            [
                'name' => 'SD',
                'grade' => '6'
            ],
            [
                'name' => 'SMP',
                'grade' => '1'
            ],
            [
                'name' => 'SMP',
                'grade' => '2'
            ],
            [
                'name' => 'SMP',
                'grade' => '3'
            ],
        ]);
    }
}
