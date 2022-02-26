<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('staffdatas', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->bigInteger('staff_id');
            // $table->string('staff_relation')->nullable();
            // $table->string('staff_relation_name')->nullable();
            // $table->string('staff_relation_mobile')->nullable();
            // $table->date('staff_relation_dob')->nullable();
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
        Schema::dropIfExists('staffdatas');
    }
}
