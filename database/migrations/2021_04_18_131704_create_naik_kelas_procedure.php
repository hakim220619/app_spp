<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateNaikKelasProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE PROCEDURE proc_naik_kelas()
            begin
                update student
                join naik_kelas t2 on student.id = t2.student_id
                set
                class_id = t2.new_class_id,
                unit_id = t2.new_unit_id;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP procedure IF EXISTS proc_naik_kelas');
    }
}
