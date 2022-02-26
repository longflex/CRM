<?php

namespace App\Http\Controllers\Laralum;
use Illuminate\Http\Request;
use App\Exports\ContactExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Group;
use App\Contact;
use Laralum;
use DB;
class GroupsController extends Controller
{

    public function index(){
		Laralum::permissionToAccess('laralum.groups.access');
        # Get all group
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        $group = DB::table('group')			    
			   ->where('client_id', $client_id)
			   ->orderBy('id', 'desc')
			   ->paginate(15);
     
	   foreach($group as $grp){
		 $grp->Contactcount = DB::table('contacts')->where('group_id', $grp->id)->count();  
	   }
	   
        # Return the view
        return view('laralum/groups/index', ['group' => $group]);
    }

	 public function store(Request $request)
     {
		Laralum::permissionToAccess('laralum.groups.access');
		# Check permissions
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		        	    		
		$group = new Group;
		$group->client_id = $client_id;
		$group->name = $request->group_name;
		$group->description = $request->group_desc;				
		$group->save();
        # Return the admin to the group page with a success message
        return response()->json(array('success' => true, 'status' => 'success'), 200);
    }
   
    public function update(Request $request)
    {
		Laralum::permissionToAccess('laralum.groups.access');
		$id = $request->group_id;
        if($id){
           # Update the data
           DB::table('group')
            ->where('id', $id)
            ->update(['name' => $request->edit_group_name, 'description' => $request->edit_group_desc]);
 
            # Return the true
            return response()->json(array('success' => true, 'status' => 'success'), 200);
		}else{
			return response()->json(array('error' => true, 'status' => 'error'), 200);
		}
       
    }
	
	public function destroy(Request $request, $id)
    {      
		Laralum::permissionToAccess('laralum.groups.access');
        # Find The Lead
        $group = Laralum::groups('id', $id);	
    	if($group){
	       DB::table('contacts')->where('group_id', $id)->delete();
	    }
		# Delete Lead
		$group->delete();

		# Return a redirect
		return redirect()->route('Laralum::groups')->with('success', "The group has been deleted");
       
    }

 
	#contacts Method
	
	  public function contactList($id, Request $request) {
        Laralum::permissionToAccess('laralum.groups.access');
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
        # Get all contacts
		$contactid = $request->contact_id;
		$name = $request->name;
		$mobile = $request->mobile;
        $contact = DB::table('contacts')
		   ->when($contactid, function ($query, $contactid){
				return $query->where('contact_id', $contactid);
			 })
			->when($name, function ($query, $name) {
				return $query->where('name', $name);
			 })
			->when($mobile, function ($query, $mobile) {
				return $query->where('mobile', $mobile);
			 })		
		   ->where('group_id', $id)
		   ->orderBy('id', 'desc')
		   ->paginate(15);
		   $group = DB::table('group')->where(['id'=> $id])->first();
      
        # Return the view
        return view('laralum/groups/contacts/index', ['contact' => $contact, 'id' => $id, 'grpname'=> $group->name, 'client_id'=> $client_id]);
    }
	
	public function storeContact(Request $request)
    { 
		Laralum::permissionToAccess('laralum.groups.access');
		$mobile_exists = DB::table('contacts')->where(['mobile'=> $request->contact_no,'group_id'=> $request->group_id])->first();
		if(!$mobile_exists){
		# Save the data
			if(Laralum::loggedInUser()->reseller_id==0){
				$client_id = Laralum::loggedInUser()->id;
			}else{
				$client_id = Laralum::loggedInUser()->reseller_id;
			}
									
			$contact = new Contact;
			$contact->user_id = $client_id;
			$contact->group_id = $request->group_id;
			$contact->name = $request->contact_name;
			$contact->mobile = $request->contact_no;								
			$contact->save();
			if($contact->id){
			 DB::table('contacts')
				->where('id', $contact->id)
				->update(['contact_id' => $contact->id]);
			}
			# Return the admin to the group page with a success message
			return response()->json(array('success' => true, 'status' => 'success'), 200);
		}else{
			return response()->json(array('error' => true, 'status' => 'error'), 200);
		}
    }
	
	public function contactUpdate(Request $request)
	{
		Laralum::permissionToAccess('laralum.groups.access');
		# update the data
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
								
		 DB::table('contacts')
		->where('id', $request->contact_id)
		->update(['name' => $request->edit_contact_name, 'mobile' => $request->edit_contact_no]);
		# Return the admin to the contact page with a success message
		return response()->json(array('success' => true, 'status' => 'success'), 200);					   
	}
	
	public function contactDestroy(Request $request)
	{
		Laralum::permissionToAccess('laralum.groups.access');
        if($request->id)
		   DB::table('contacts')->where('id', $request->id)->delete();
		# Return the view
    	return response()->json(array('success' => true, 'status' => 'success'), 200);
	}
	
	public function deleteAll(Request $request)
	{
        $ids = $request->ids;
        DB::table("contacts")->whereIn('id',explode(",",$ids))->delete();
		# Return the view
    	
		return response()->json(['success' => "The contact has been deleted!"]);
	}
		

	
	public function ContactExport(Request $request) 
    {
		Laralum::permissionToAccess('laralum.groups.access');
      return Excel::download(new ContactExport($request->group_id), 'contacts.xlsx');
    } 
	
	public function ContactImport(Request $request)
    {
		Laralum::permissionToAccess('laralum.groups.access');
      if(Laralum::loggedInUser()->reseller_id==0){
		$client_id = Laralum::loggedInUser()->id;
	  }else{
		$client_id = Laralum::loggedInUser()->reseller_id;
	  }
	  if(isset($_POST['importSubmit'])){    
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
			// Validate whether selected file is a CSV file
			if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
				
				// If the file is uploaded
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// Open uploaded CSV file with read-only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					// Skip the first line
					fgetcsv($csvFile);
					
					// Parse data from CSV file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
                    if(!empty($line[1])){						
					 $mobile_exists = DB::table('contacts')->where(['mobile'=> $line[1], 'group_id'=> $request->import_contact_group_id])->first();
		             if(!$mobile_exists){
						// Get row data
						$contact = new Contact;
						$contact->user_id = $client_id;
						$contact->group_id = $request->import_contact_group_id;
						$contact->name = $line[0];
						$contact->mobile = $line[1];								
						$contact->save();
						if($contact->id){
							 DB::table('contacts')
								->where('id', $contact->id)
								->update(['contact_id' => $contact->id]);
						 }
					   }
					  }					  
					}
					
					// Close opened CSV file
					fclose($csvFile);
					
					return redirect()->route('Laralum::contacts', ['id' => $request->import_contact_group_id])->with('success', 'Contacts data has been imported successfully.');
				}else{
					
					return redirect()->route('Laralum::contacts', ['id' => $request->import_contact_group_id])->with('error', 'Some problem occurred, please try again.');
				}
			}else{
				
				return redirect()->route('Laralum::contacts', ['id' => $request->import_contact_group_id])->with('error', 'Please upload a valid CSV file.');
			}
		}
		
        
    }
	
}
