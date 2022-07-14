<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateJumlahSiswaView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create or replace view jumlah_siswa as
            select
                c.name as kelas,
                u2.name as unit,
                sum(case when s.gender = 'L' then 1 else 0 end) as laki,
                sum(case when s.gender = 'P' then 1 else 0 end) as perempuan
            from
                student s
            left join class c on
                s.class_id = c.id
            left join unit u2 on
                u2.id = c.unit_id
            where
                s.status = 'Aktif'
            group by
                1,
                2
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jumlah_siswa');
    }
}
