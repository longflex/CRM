<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            // $table->string('branch')->unsigned()->nullable()->change();
            // $table->string('profession')->unsigned()->nullable()->change();
            // $table->string('sms_language')->unsigned()->nullable()->change();
            // $table->string('member_id')->unsigned()->nullable()->change();
            // $table->string('member_type')->unsigned()->nullable()->change();
            // $table->string('blood_group')->unsigned()->nullable()->change();
            // $table->string('married_status')->unsigned()->nullable()->change();
            // $table->string('rfid')->unsigned()->nullable()->change();
            // $table->string('alt_numbers')->unsigned()->nullable()->change();
            // $table->string('country')->unsigned()->nullable()->change();
            // $table->string('qualification')->unsigned()->nullable()->change();
            // $table->string('branch')->unsigned()->nullable()->change();
            // $table->boolean('sms_required')->unsigned()->nullable()->change();
            // $table->boolean('call_required')->unsigned()->nullable()->change();
            // $table->string('id_proof')->unsigned()->nullable()->change();
            // $table->string('email')->unsigned()->nullable()->change();
            // $table->string('mobile')->unsigned()->nullable()->change();
            // $table->string('state')->change();
            // $table->string('district')->change();
            // $table->string('pincode')->change();
            //$table->string('address_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            // $table->dropColumn('branch')
            // $table->dropColumn('profession')
            // $table->dropColumn('sms_language')
            // $table->dropColumn('member_id')
            // $table->dropColumn('member_type')
            // $table->dropColumn('blood_group')
            // $table->dropColumn('married_status')
            // $table->dropColumn('rfid')
            // $table->dropColumn('alt_numbers')
            // $table->dropColumn('country')
            // $table->dropColumn('qualification')
            // $table->dropColumn('branch')
            // $table->dropColumn('sms_required')
            // $table->dropColumn('call_required')
            // $table->dropColumn('id_proof')
        });
    }
}
