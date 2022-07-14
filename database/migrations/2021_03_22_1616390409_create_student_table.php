<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStudentTable extends Migration
{
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {

            $table->id('id');
            $table->string('year', 10);
            $table->string('nis', 50);
            $table->string('email', 50);
            $table->string('name');
            $table->string('gender', 20);
            $table->string('phone', 25);
            $table->date('date_of_birth');
            $table->string('status', 20);
            $table->integer('class_id',);
            $table->integer('unit_id',);
            $table->text('description')->nullable(true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    public function down()
    {
        Schema::dropIfExists('student');
    }
}
