<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('sms_templates', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->string('name');
            // $table->string('period')->nullable();
            // $table->boolean('status');
            // $table->string('template')->nullable();
        //});
        // $names = [
        //     'After creating donation',
        //     'After receiving payment',
        //     'For recurring payment',
        //     'For recurring due payment',
        //     'For not paying due amount',
        //     'For thank you message',
        //     'After receiving call',
        //     'After making call',
        //     'Sending receipt by staff'
        // ];
        // foreach ($names as $key => $name) {
        //     DB::table('sms_templates')->insert(
        //         array(
        //             'name' => $name,
        //             'status'=>0
        //         )
        //     );
        // }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smsm_templates');
    }
}
