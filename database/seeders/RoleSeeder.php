<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("role")->insert([
            [
                'name' => 'admin',
            ],
            [
                'name' => 'operator',
            ],
            [
                'name' => 'siswa',
            ],
        ]);
    }
}
