<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('module');
            $table->string('permission');
            // $table->boolean('assignable');
            // $table->boolean('su');
            $table->timestamps();
        });

        $permissions = [
            'laralum.admin.dashboard',
            'laralum.member.access',
            'laralum.member.dashboard',
            'laralum.member.list',
            'laralum.member.view',
            'laralum.member.create',
            'laralum.member.edit',
            'laralum.member.delete',
            'laralum.member.makecall',
            'laralum.member.recievecall',
            'laralum.member.calllogs',
            'laralum.member.sendsms',
            'laralum.member.viewsms',
            'laralum.member.list_prayer',
            'laralum.member.add_prayer',
            'laralum.member.edit_prayer',
            'laralum.member.view_prayer',
            'laralum.member.prayer_status',
            'laralum.donation.list',
            'laralum.donation.view',
            'laralum.donation.create',
            'laralum.donation.edit',
            'laralum.donation.delete',
            'laralum.appointments.list',
            'laralum.appointments.view',
            'laralum.appointments.create',
            'laralum.appointments.edit',
            'laralum.appointments.delete',
            'laralum.vehicles.dashboard',
            'laralum.vehicles.view',
            'laralum.vehicles.create',
            'laralum.vehicles.edit',
            'laralum.vehicles.delete',
            'laralum.sms.dashboard',
            'laralum.sendsms.access',
            'laralum.groups.access',
            'laralum.reports.access',
            'laralum.senderid.access',
            'laralum.ivr.dashboard',
        ];
        $permission_names = [
            'Access Super Admin Dashboard',
            'Access Member Module',
            'View Member Dashboard',
            'List',
            'View',
            'Create',
            'Edit',
            'Delete',
            'Makecall',
            'Recievecall',
            'View Call Logs',
            'Send SMS',
            'View SMS',
            'View Prayer List',
            'Add Prayer',
            'Edit Prayer',
            'View Prayer',
            'Prayer Status',
            'List',
            'View',
            'Create',
            'Edit',
            'Delete',
            'List',
            'View',
            'Create',
            'Edit',
            'Delete',
            'Vehicle Dashboard',
            'View',
            'Create',
            'Edit',
            'Delete',
            'Sms Dashboard',
            'Send Sms',
            'View Group',
            'View Reports',
            'View Sender',
            'Ivr Dashboard'
        ];
        $modules= [
            'SuperAdmin',
            'Member',
            'Member',
            'Member',
            'Member',
            'Member',
            'Member',
            'Member',
            "telemarketing",
            "telemarketing",
            "telemarketing",
            "telemarketing",
            "telemarketing",
            "prayer",
            "prayer",
            "prayer",
            "prayer",
            "prayer",
            'Donation',
            'Donation',
            'Donation',
            'Donation',
            'Donation',
            'Appointments',
            'Appointments',
            'Appointments',
            'Appointments',
            'Appointments',
            'Vehicles',
            'Vehicles',
            'Vehicles',
            'Vehicles',
            'Vehicles',
            'Sms',
            'Sms',
            'Sms',
            'Sms',
            'Sms',
            'Ivr'
        ];

        foreach ($permissions as $key => $permission) {
            $perm = \Laralum::newPermission();
            $perm->slug = $permission;
            $perm->module=$modules[$key];
            $perm->permission = $permission_names[$key];
            // $perm->assignable = true;
            // $perm->su = true;
            $perm->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
