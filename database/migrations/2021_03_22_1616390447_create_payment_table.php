<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePaymentTable extends Migration
{
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {

            $table->id('id');
            $table->integer('student_id',);
            $table->text('description');
            $table->integer('category_payment_id',);
            $table->decimal('amount', 16, 2);
            $table->decimal('adjusment_amount', 16, 2);
            $table->string('payment_method', 25);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
