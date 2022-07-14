<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUnitTable extends Migration
{
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {

            $table->id('id');
            $table->string('name', 25);
            $table->string('grade', 10);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    public function down()
    {
        Schema::dropIfExists('unit');
    }
}
