<?php

namespace App\Observers;


use App\EmployeeLeaveQuota;
use App\Events\LeaveEvent;
use App\Leave;
use App\LeaveType;
use App\User;
use App\Http\Controllers\Laralum\Laralum;

class LeaveTypeObserver
{
    
    public function created(LeaveType $leaveType)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        //!isRunningInConsoleOrSeeding() &&
        if ( request()->has('all_employees')) {
            $employees = User::select('id')->get();

            foreach ($employees as $key => $employee) {
                EmployeeLeaveQuota::create(
                    [
                        'user_id' => $employee->id,
                        'leave_type_id' => $leaveType->id,
                        'no_of_leaves' => $leaveType->no_of_leaves,
                        'client_id'=>$client_id
                    ]
                );
            }
        }
    }

}
