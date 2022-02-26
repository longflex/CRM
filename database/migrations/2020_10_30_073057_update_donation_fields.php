<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDonationFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::table('donations', function (Blueprint $table) {
            // $table->boolean('payment_status');
            // $table->boolean('donation_purpose');
            // $table->string('payment_method');
            // $table->string('payment_type');
            // $table->string('location');
            // $table->date('payment_start');
            // $table->date('payment_end');
            // $table->string('donation_type')->change();
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            //
        });
    }
}
