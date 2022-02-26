<?php

namespace App\Http\Controllers\Laralum;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\groups_Role;
use Laralum;
use DB;
//use Illuminate\Support\Facades\Validator;
class BanksController extends Controller
{

    public function index() {
        // Laralum::permissionToAccess('laralum.bank.access');

        # Get all bank details
        
		   $bank = DB::table('bank_details')->where('user_id', Laralum::loggedInUser()->id)->get();	

	  
        # Return the view
        return view('laralum/bank-details/index', ['banks' => $bank]);
    }

    public function create()
    {
        // Laralum::permissionToAccess('laralum.bank.access');

        # Get all the data
        $data_index = 'bank-details';
        require('Data/Create/Get.php');

        # Return the view
        return view('laralum/bank-details/create', [
            'fields'    =>  $fields,
            'confirmed' =>  $confirmed,
            'encrypted' =>  $encrypted,
            'hashed'    =>  $hashed,
            'masked'    =>  $masked,
            'table'     =>  $table,
            'code'      =>  $code,
            'wysiwyg'   =>  $wysiwyg,
            'relations' =>  $relations,
        ]);
    }

    public function store(Request $request)
    {
		
		# Check permissions
        // Laralum::permissionToAccess('laralum.bank.access');
        
		$row = Laralum::newBank();
		 # Save the data
        $data_index = 'bank-details';
		
        require('Data/Create/Save.php');
		
        $row->user_id = Laralum::loggedInUser()->id;
		if(Laralum::loggedInUser()->su){
			$row->role_id = 1;
		}else{
			$row->role_id = 3;
		}
		
        $row->save();

        # Return the admin to the blogs page with a success message
        return redirect()->route('Laralum::bank')->with('success', "The bank details has been created");
    }
    #update delete record
	public function destroy(Request $request)
    {
		$entry_id = $request->entry_id;
       
        
        # Check permissions
        //  Laralum::permissionToAccess('laralum.bank.access');

        # Check if bank owner
        Laralum::mustOwnBank($entry_id);

        # Find The Group
        $row = Laralum::banks('id', $entry_id);
        
    	if($row->user_id == Laralum::loggedInUser()->id or Laralum::loggedInUser()->su) {
            # The user who's trying to delete the post is able to do such because it's the owner or it's su
        
            # Delete contact
            $row->delete();

            # Return a redirect
            # Return the true
            return response()->json(array('success' => true, 'id' => $entry_id), 200);
        } else {
            #The user is not allowed to delete the blog
            abort(403, trans('laralum.error_not_allowed'));
        }
    } 
     
   
	
}
