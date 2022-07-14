<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNaikKelasView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create or replace view naik_kelas as
            with naik as (
                select id as student_id, class_id, unit_id, unit_id+1 as new_unit_id from student s
            ),
                kelas as (
                select * from (
                    select unit_id, id as class_id, row_number() over(partition by unit_id) as rn from class c
                ) a where rn = 1
            )
            select
            student_id, new_unit_id, coalesce(kelas.class_id,0) as new_class_id
            from naik left join kelas on naik.new_unit_id = kelas.unit_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('naik_kelas');
    }
}
