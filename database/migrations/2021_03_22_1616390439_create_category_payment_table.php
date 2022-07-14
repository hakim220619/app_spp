<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoryPaymentTable extends Migration
{
    public function up()
    {
        Schema::create('category_payment', function (Blueprint $table) {

            $table->id('id');
            $table->string('name', 50);
            $table->decimal('amount', 16, 2);
            $table->string('type', 25);
            $table->integer('class_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    public function down()
    {
        Schema::dropIfExists('category_payment');
    }
}
