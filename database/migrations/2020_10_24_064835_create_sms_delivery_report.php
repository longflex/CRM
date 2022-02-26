<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsDeliveryReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('smsreport', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->string('senderId')->nullable();
            // $table->string('requestId')->nullable();
            // $table->string('date')->nullable();
            // $table->string('number')->nullable();
            // $table->string('status')->nullable();
            // $table->string('desc')->nullable();
            // $table->string('userId')->nullable();
            // $table->string('campaignName')->nullable();
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smsreport', function (Blueprint $table) {
            //
        });
    }
}
