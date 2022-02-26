<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\Laralum\Laralum;
use App\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Role;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Services\DepartmentService;
use App\Department;


class DepartmentsController extends Controller
{
	private $department;

	public function __construct(DepartmentService $department)
    {
        $this->department = $department;
    }


    public function index(Request $request){
		Laralum::permissionToAccess('laralum.department.list');
		return view('hyper/department/index');	
	}

	public function create()
	{
		Laralum::permissionToAccess('laralum.department.create');
		return view('hyper/department/create');
	}

	public function store(Request $request)
	{ ///dd($request->all());
		Laralum::permissionToAccess('laralum.department.create');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
		Department::create([
			'client_id' => $client_id,
			'department' => $request->department,
			'created_at' => date('Y-m-d'),
		]);
		$msg="The Department has been created.";
		return response()->json(['status' => true ,'message' => $msg]);

		
	}


	public function edit($id)
	{
		Laralum::permissionToAccess('laralum.department.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$department = DB::table('departments')->where('id', $id)->first();
		//dd($department);
		# Return the edit form
		return view('hyper/department/edit', [
			'id' =>$id,
			'department' => $department,

		]);
	}

	public function Update(Request $request)
	{
		//dd($request->all());
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		Department::where('id', '=', $request->edit_id)->update(array('department' => $request->department));
		$msg="The Department has been updated.";
		return response()->json(['status' => true ,'message' => $msg]);
	}



	public function destroy(Request $request)
	{
		Laralum::permissionToAccess('laralum.department.delete');
		//Laralum::permissionToAccess('laralum.member.delete');
		# Find The Lead
		if ($request->ajax()){
			DB::beginTransaction();
		try {
		    $staff_user=Department::where('id', $request->id)->delete();
			
		    DB::commit();
		    return redirect()->route('Crm::department')->with('success', "The staff has been deleted");
		} catch (\Exception $e) {
		    DB::rollback();
		    //return response()->json(['error' => $ex->getMessage()], 500);
		    //return redirect()->route('Crm::staff')->with('error', 'Some problem occurred, please try again.');
		}		
		}
	}


	public function get_department_data(Request $request){
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $departments = $this->department->getDepartmentForTable($request,$client_id);
        return $this->department->departmentDataTable($departments);
    }























    
}
