<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('user_details', function (Blueprint $table) {
            // $table->bigIncrements('id');

            // $table->bigInteger('user_id');
            // $table->string('nick_name')->nullable();
            // $table->string('location')->nullable();
            // $table->string('reporting_to')->nullable();
            // $table->string('work_title')->nullable();
            // $table->string('hire_source')->nullable();
            // $table->date('joining_date')->nullable();
            // $table->string('seating_location')->nullable();
            // $table->string('work_status')->nullable();
            // $table->string('staff_type')->nullable();
            // $table->string('work_phone')->nullable();
            // $table->string('extension')->nullable();
            // $table->string('work_role')->nullable();
            // $table->string('experience')->nullable();
            // $table->string('pan_no')->nullable();
            // $table->string('adhar_no')->nullable();
            // $table->string('tags')->nullable();
            // $table->string('married_status')->nullable();
            // $table->string('age')->nullable();
            // $table->string('job_desc')->nullable();
            // $table->string('about_me')->nullable();
            // $table->date('exit_date')->nullable();
            // $table->string('expertise')->nullable();
            // $table->string('gender')->nullable();

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
        Schema::dropIfExists('user_details');
    }
}
