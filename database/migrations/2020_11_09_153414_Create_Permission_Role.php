<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission_Role;
use App\Permission;

class CreatePermissionRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('permission_role', function (Blueprint $table) {
            // $table->increments('id');
            // $table->integer('permission_id');
            // $table->integer('role_id');
            // $table->timestamps();
        //});
        
        // foreach (Permission::all() as $perm) {
        //     $rel = new Permission_Role;
        //     $rel->permission_id = $perm->id;
        //     $rel->role_id = 1;
        //     $rel->save();
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
    }
}
