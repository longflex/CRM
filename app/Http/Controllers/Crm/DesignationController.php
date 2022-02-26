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
use App\Services\DesignationService;
use App\Designation;

class DesignationController extends Controller
{
    private $designation;

	public function __construct(DesignationService $designation)
    {
        $this->designation = $designation;
    }

    public function index(Request $request){
		Laralum::permissionToAccess('laralum.designation.list');
		return view('hyper/designation/index');	
	}

	public function create()
	{
		Laralum::permissionToAccess('laralum.designation.create');
		return view('hyper/designation/create');
	}

	public function store(Request $request)
	{ ///dd($request->all());
		Laralum::permissionToAccess('laralum.staff.access');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
		Designation::create([
			'client_id' => $client_id,
			'designation' => $request->designation,
			'created_at' => date('Y-m-d'),
		]);
		$msg="The Designation has been created.";
		return response()->json(['status' => true ,'message' => $msg]);

		
	}


	public function edit($id)
	{
		Laralum::permissionToAccess('laralum.designation.edit');
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}

		$designation = DB::table('designation')->where('id', $id)->first();
		//dd($department);
		# Return the edit form
		return view('hyper/designation/edit', [
			'id' =>$id,
			'designation' => $designation,

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
		Designation::where('id', '=', $request->edit_id)->update(array('designation' => $request->designation));
		$msg="The Designation has been updated.";
		return response()->json(['status' => true ,'message' => $msg]);
	}



	public function destroy(Request $request)
	{
		Laralum::permissionToAccess('laralum.designation.delete');
		//Laralum::permissionToAccess('laralum.member.delete');
		# Find The Lead
		if ($request->ajax()){
			DB::beginTransaction();
		try {
		    $staff_user=Designation::where('id', $request->id)->delete();
			
		    DB::commit();
		    return redirect()->route('Crm::designation')->with('success', "The designation has been deleted");
		} catch (\Exception $e) {
		    DB::rollback();
		    //return response()->json(['error' => $ex->getMessage()], 500);
		    //return redirect()->route('Crm::staff')->with('error', 'Some problem occurred, please try again.');
		}		
		}
	}


	public function get_designation_data (Request $request){
		if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $designation = $this->designation->getDesignationForTable($request,$client_id);
        return $this->designation->designationDataTable($designation);
    }





































}
