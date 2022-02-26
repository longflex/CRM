<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id');
            $table->string('name')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('joining_date')->nullable();
            $table->bigInteger('anual_ctc')->nullable();
            $table->float('basic_percentage', 5, 2)->nullable();
            $table->float('hra_percentage', 5, 2)->nullable();
            $table->float('special_allowance_per', 5, 2)->nullable();
            $table->float('pf_percentage', 5, 2)->nullable();
            $table->float('esi_percentage', 5, 2)->nullable();
            $table->float('advance_percentage', 5, 2)->nullable();
            $table->float('pt_percentage', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payslips');
    }
}
