<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\EmployeeDetails;
use App\EmployeeLeaveQuota;
use App\Helper\Reply;
use App\Http\Requests\LeaveType\StoreLeaveType;
use App\LeaveType;

use App\Role;
use App\Http\Controllers\Laralum\Laralum;
use App\User;
use App\Permission;
use Validator, File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; 



class LeaveTypesConroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $this->leaveTypes = LeaveType::where('client_id', $client_id)->get();
        return view('hyper.leave-type.create', ['leaveTypes'=>$this->leaveTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLeaveType $request)
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $leaveType = new LeaveType();
        $leaveType->type_name = $request->type_name;
        $leaveType->color = $request->color;
        $leaveType->paid = $request->paid;
        $leaveType->no_of_leaves = $request->leave_number;
        $leaveType->client_id = $client_id;
        $leaveType->save();

        return Reply::success('Leave type saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        if ($request->leaves < 0) {
            return Reply::error('No of leaves should be grater than or equal to Zero');
        }
        $type = LeaveType::findOrFail($id);
        $type->no_of_leaves = $request->leaves;
        $type->paid = $request->paid;
        $type->client_id = $client_id;
        $type->save();

        return Reply::success('Leave type saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LeaveType::destroy($id);
        return Reply::success('Leave type deleted.');
    }
}
