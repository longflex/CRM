<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('payments', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->integer('donation_id');
            // $table->string('transaction_id');
            // $table->string('amount');
            // $table->string('currency');
            // $table->string('status');
            // $table->string('email');
            // $table->string('phone');
            // $table->string('description');
            // $table->string('method');          
            // $table->text('data');
            // $table->timestamps();
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
