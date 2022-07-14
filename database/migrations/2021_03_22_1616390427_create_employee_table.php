<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEmployeeTable extends Migration
{
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {

            $table->id('id');
            $table->string('nik', 50);
            $table->string('email', 50);
            $table->string('name');
            $table->string('gender', 20);
            $table->string('phone', 25);
            $table->string('status', 25);
            $table->text('address');
            $table->date('date_of_join');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
