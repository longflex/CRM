<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecuriingPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('recurring_payments', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->string('donation_id');
            // $table->string('emi_amount');
            // $table->string('emi_period');
            // $table->date('paid_date');
            // $table->boolean('emi_status');
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
        Schema::dropIfExists('recurring_payments');
    }
}
