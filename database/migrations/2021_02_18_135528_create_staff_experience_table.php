<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('staff_experience', function (Blueprint $table) {
            // $table->bigIncrements('exp_id');  
            // $table->bigInteger('exp_staff_id');
            // $table->string('exp_company_name')->nullable();
            // $table->string('exp_job_title')->nullable();
            // $table->date('exp_from_date')->nullable();
            // $table->date('exp_to_date')->nullable();
            // $table->longText('exp_job_desc')->nullable();
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
        Schema::dropIfExists('staff_experience');
    }
}
