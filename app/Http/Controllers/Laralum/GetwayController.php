<?php

namespace App\Http\Controllers\Laralum;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\groups_Role;
use Laralum;
use DB;
class GetwayController extends Controller
{

    public function index() {
        Laralum::permissionToAccess('laralum.getways.access');

        # Get all getway
        $getway = Laralum::getway('user_id', Laralum::loggedInUser()->id );
		$default = DB::table('gateway_default')->first();
        # Return the view
        return view('laralum/gateways/index', ['getways' => $getway, 'default'=> $default]);
    }

    public function create()
    {  
	    # Check permissions to access
        Laralum::permissionToAccess('laralum.getways.access');

        # Check permissions to create
        Laralum::permissionToAccess('laralum.gateways.create');

        # Get all the data
        $data_index = 'gateways';
        require('Data/Create/Get.php');

        # Return the view
        return view('laralum/gateways/create', [
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
        # Check permissions to access
        Laralum::permissionToAccess('laralum.getways.access');

        # Check permissions to create
        Laralum::permissionToAccess('laralum.gateways.create');

        # create the user
        $row = Laralum::newGateway();
		
        # Save the data
		//echo $row->insertGetId;die;
        $data_index = 'gateways';
        require('Data/Create/Save.php');

        $row->user_id = Laralum::loggedInUser()->id;
        $row->save();
        # Return the admin to the blogs page with a success message
        return redirect()->route('Laralum::getway')->with('success', "The gateway has been created");
    }


    public function edit($id)
    {
        # Check permissions to access
        Laralum::permissionToAccess('laralum.getways.access');

        # Check permissions to create
        Laralum::permissionToAccess('laralum.gateways.edit');

        # Check if gateway owner
         Laralum::mustOwnGatewayID($id);

        # Find the blog
       $row = Laralum::getway('id', $id)[0];

        # Get all the data
        $data_index = 'gateways';
        require('Data/Edit/Get.php');

        # Return the edit form
        return view('laralum/gateways/edit', [
            'row'       =>  $row,
            'fields'    =>  $fields,
            'confirmed' =>  $confirmed,
            'empty'     =>  $empty,
            'encrypted' =>  $encrypted,
            'hashed'    =>  $hashed,
            'masked'    =>  $masked,
            'table'     =>  $table,
            'code'      =>  $code,
            'wysiwyg'   =>  $wysiwyg,
            'relations' =>  $relations,
        ]);
    }

    public function update($id, Request $request)
    {
       # Check permissions to access
        Laralum::permissionToAccess('laralum.getways.access');

        # Check permissions to create
        Laralum::permissionToAccess('laralum.gateways.edit');

        # Check if gateway owner
        Laralum::mustOwnGatewayID($id);

        # Find the getway
        $row = Laralum::getway('id', $id)[0];

        if($row->user_id == Laralum::loggedInUser()->id AND Laralum::loggedInUser()->su) {
            # The user who's trying to modify the post is able to do such because it's the owner or it's su

            # Save the data
            $data_index = 'gateways';
            require('Data/Edit/Save.php');

            # Return the admin to the gateways page with a success message
            return redirect()->route('Laralum::getway')->with('success', "The gateway has been edited");
        } else {
            #The user is not allowed to delete the blog
            abort(403, trans('laralum.error_not_allowed'));
        }
    }

    public function destroy(Request $request)
    {
		$gateway_id = $request->gateway_id;
       # Check permissions to access
        Laralum::permissionToAccess('laralum.getways.access');

        # Check permissions to create
        Laralum::permissionToAccess('laralum.gateways.delete');

        # Check if group owner
        Laralum::mustOwnGatewayID($gateway_id);

        # Find The Group
        $row = Laralum::getway('id', $gateway_id)[0];
        
    	if($row->user_id == Laralum::loggedInUser()->id AND Laralum::loggedInUser()->su) {
            # The user who's trying to delete the post is able to do such because it's the owner or it's su
        
            
            # Delete gateway
            $row->delete();

            # Return a redirect
            # Return the true
            return response()->json(array('success' => true, 'id' => $gateway_id), 200);
        } else {
            #The user is not allowed to delete the blog
            abort(403, trans('laralum.error_not_allowed'));
        }
    }
	#Set Default Method
	
	  public function setDefault($id,$type) {
		  
         # Check permissions to access
        Laralum::permissionToAccess('laralum.getways.access');
		if($type=='sms') {
			 DB::table('gateway_default')->update(['default_for_sms' => $id]);
		} elseif($type=='mms') {
			DB::table('gateway_default')->update(['default_for_mms' => $id]);
		} elseif($type=='unicode') {
			DB::table('gateway_default')->update(['default_for_unicode' => $id]);
		} elseif($type=='incoming') {
			DB::table('gateway_default')->update(['default_for_incoming' => $id]);
		}
		return redirect()->route('Laralum::getway')->with('success', "Default set successfully!");
    }
	
	public function createContact($id)
    {
        Laralum::permissionToAccess('laralum.groups.access');

        # Check permissions
        Laralum::permissionToAccess('laralum.groups.create');

        # Get all the data
        $data_index = 'contacts';
        require('Data/Create/Get.php');

        # Return the view
        return view('laralum/groups/contacts/create', [
            'fields'    =>  $fields,
            'confirmed' =>  $confirmed,
            'encrypted' =>  $encrypted,
            'hashed'    =>  $hashed,
            'masked'    =>  $masked,
            'table'     =>  $table,
            'code'      =>  $code,
            'wysiwyg'   =>  $wysiwyg,
            'relations' =>  $relations,
			'group_id' =>  $id,
        ]);
    }
	
	public function storeContact(Request $request)
    {  
	   
        Laralum::permissionToAccess('laralum.groups.access');

        # Check permissions
        Laralum::permissionToAccess('laralum.groups.create');

        # create the user
        $row = Laralum::newContact();
        #check mobile exist
		$mobile_exists = DB::table('contacts')->where(['mobile'=> $request->mobile,'group_id'=> $request->group_id])->first();
		if(!$mobile_exists){
			# Save the data
			$data_index = 'contacts';
			require('Data/Create/Save.php');
			$row->group_id = $request->group_id;
			$row->user_id = Laralum::loggedInUser()->id;
			$row->save();

			# Return the admin to the blogs page with a success message
			return redirect()->route('Laralum::contacts', ['id' => $request->group_id])->with('success', "The contact has been created");
		}
		else{
			return redirect()->route('Laralum::contacts', ['id' => $request->group_id])->with('error', "The mobile no. ".$request->mobile." already exist in your group");
		}
    }

	
	 public function showImport($id)
     {
        Laralum::permissionToAccess('laralum.groups.access');

        # Check permissions
        

        return view('laralum/groups/contacts/import', ['id' => $id]);
    }
	
	
	
	public function storeSheet(Request $request)
    {  
	       $group_id = $request->group_id;
		   
		   \Session::put('group_id', $request->group_id);
		   $file_ext = 0;
		   $allmobile = [];
		   if($request->hasFile('files')){
			   $files_rows = $request->file('files');
			   $ext_mime = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel', 'application/msexcel', 'application/xls', 'application/x-xls','text/plain');
			   
			   foreach ($files_rows as $files_row) {
				   
				   $files[] = $files_row->getRealPath();
				   $ext = $files_row->getMimeType();
				   if(in_array($ext, $ext_mime)) $file_ext = 1; else $file_ext = 0;  
			   }
			  if($file_ext == 1)  {
				  
			   \Excel::batch($files, function($rows, $file) {
				   
					$rows->each(function($row) {
						if($row->mobile=='') { 
						
							return redirect()->route('Laralum::import', ['id' => \Session::get('group_id')])->with('error', "Please put respective header as sample sheet");
						}
						$allmobile[] = '99999999999';
						if(!in_array($row->mobile, $allmobile)) {
						\DB::table('contacts')->insert(['mobile' => $row->mobile, 'name' => $row->name, 'contact_id' => $row->contact_id, 'user_id' => Laralum::loggedInUser()->id, 'group_id' =>  \Session::get('group_id')]);
						$allmobile[] = $row->mobile;
						
						}
						
						
					});

				});
				 \Session::forget('group_id');
				return redirect()->route('Laralum::contacts', ['id' => $group_id])->with('success', "The contact has been imported");
				
		   } else {
			   
			   return redirect()->route('Laralum::import', ['id' => $group_id])->with('error', "Invalid file extension. Allowed extension csv,xls,xlsx");
		   }
              
        }
		return redirect()->route('Laralum::import', ['id' => $group_id])->with('error', "Request data does not have any files to import.");
        
    }
	
	 public function contactEdit($id , $cid)
     {
        Laralum::permissionToAccess('laralum.groups.access');

        # Check permissions
        Laralum::permissionToAccess('laralum.groups.edit');

        # Check if blog owner
        Laralum::mustOwnContact($cid);

        # Find the blog
        $row = Laralum::contactUP('id', $cid)[0];
       //echo '<pre>';print_r($row);die;
        # Get all the data
        $data_index = 'contacts';
        require('Data/Edit/Get.php');

        # Return the edit form
        return view('laralum/groups/contacts/edit', [
            'row'       =>  $row,
            'fields'    =>  $fields,
            'confirmed' =>  $confirmed,
            'empty'     =>  $empty,
            'encrypted' =>  $encrypted,
            'hashed'    =>  $hashed,
            'masked'    =>  $masked,
            'table'     =>  $table,
            'code'      =>  $code,
            'wysiwyg'   =>  $wysiwyg,
            'relations' =>  $relations,
			'group_id'  => $id,
        ]);
    }
	
	    public function contactUpdate(Request $request)
		{
			
		    $input = array_slice($request->all(), 1, -1);
			//echo $request->group_id;die;
			Laralum::permissionToAccess('laralum.groups.access');
            if($request->action=='edit')
			{
				
				# Check permissions
				Laralum::permissionToAccess('laralum.groups.edit');

				# Check if Contact owner
				Laralum::mustOwnContact($request->id);

				# Find the contact
				$row = Laralum::contact('id', $request->id)[0];
				 //echo '<pre>';print_r($row);die;
				if($row->user_id == Laralum::loggedInUser()->id or Laralum::loggedInUser()->su) {
					# The user who's trying to modify the post is able to do such because it's the owner or it's su
                #check mobile
				$mobile_exists = DB::table('contacts')->where(['mobile'=> $request->mobile,'group_id'=> $request->id])->first();
				
				# Save the data
			    DB::table('contacts')->where('id', $request->id)->update($input);
					

					# Return the admin to the blogs page with a success message
					echo json_encode($request->all());
				} else {
					#The user is not allowed to delete the blog
					abort(403, trans('laralum.error_not_allowed'));
				}
			} elseif ($request->action=='delete') {
				
				
				# Check permissions
			Laralum::permissionToAccess('laralum.groups.delete');

			# Check if group owner
			Laralum::mustOwnContact($request->id);

			# Find The Group
			$row = Laralum::contact('id', $request->id)[0];
			
			if($row->user_id == Laralum::loggedInUser()->id or Laralum::loggedInUser()->su) {
				# The user who's trying to delete the post is able to do such because it's the owner or it's su
			
				# Delete contacts
				
				
				# Delete contact
				$row->delete();

				# Return a redirect
				echo json_encode($request->all());
			} else {
				#The user is not allowed to delete the blog
				abort(403, trans('laralum.error_not_allowed'));
			}
			}
		}
		
		 public function contactDestroy($id , $cid)
		{
			Laralum::permissionToAccess('laralum.groups.access');
			
			# Check permissions
			Laralum::permissionToAccess('laralum.groups.delete');

			# Check if group owner
			Laralum::mustOwnContact($cid);

			# Find The Group
			$row = Laralum::contact('id', $cid)[0];
			
			if($row->user_id == Laralum::loggedInUser()->id or Laralum::loggedInUser()->su) {
				# The user who's trying to delete the post is able to do such because it's the owner or it's su
			
				# Delete contacts
				
				
				# Delete contact
				$row->delete();

				# Return a redirect
				return redirect()->route('Laralum::contacts',['id' =>$id])->with('success', "The contact has been deleted");
			} else {
				#The user is not allowed to delete the blog
				abort(403, trans('laralum.error_not_allowed'));
			}
		}
	#Ajax contact search

       public function Search(Request $request){
		 
        $read = "";
        $keyword = $request->search; 
        $groupid = $request->groupid;
        
        if($keyword) {
            $results = DB::table('contacts')->where('group_id',$groupid)->where('mobile','LIKE','%'.$keyword.'%')->orWhere('name','LIKE','%'.$keyword.'%')->orWhere('contact_id','LIKE','%'.$keyword.'%')->groupBy('mobile')->get();
	   }
	   else{
		  $results = DB::table('contacts')->where('group_id',$groupid)->where('mobile','LIKE','%'.$keyword.'%')->orWhere('name','LIKE','%'.$keyword.'%')->orWhere('contact_id','LIKE','%'.$keyword.'%')->groupBy('mobile')->paginate(100); 
	   }
		//echo '<pre>';print_r($results);die;
		 foreach($results as $result) {
			 
			 $read .="
			 
			 
			         <tr id='$result->id'>
					
						<td align='center'>
						<span class=''>$result->id</span>
						<input class='tabledit-input tabledit-identifier' name='id' value='$result->id' disabled='' type='hidden'>
						</td>
						
						<td style='cursor: pointer;' class='tabledit-view-mode' align='center'>
						<p class='tabledit-span'>$result->mobile</p>
						<input class='tabledit-input inp' name='mobile' value='$result->mobile' style='display: none;' disabled='' type='text'>
						</td>
						
						<td style='cursor: pointer;' class='tabledit-view-mode' align='center'>
						<p class='tabledit-span'>$result->name</p>
						<input class='tabledit-input inp' name='name' value='$result->name' style='display: none;' disabled='' type='text'>
						</td>
						<td style='cursor: pointer;' class='tabledit-view-mode' align='center'>
						<p class='tabledit-span'>$result->contact_id</p>
						<input class='tabledit-input inp' name='contact_id' value='$result->contact_id' style='display: none;' disabled='' type='text'>
						</td>


						<td style='width: 18%;'><div class='tabledit-toolbar btn-toolbar' style='text-align: left;'>
						<div class='btn-group btn-group-sm'><button type='button' class='tabledit-delete-button ui teal top icon left pointing dropdown button' style='float: none;' tabindex='0'><span class='fa fa-trash-o'>
						</span><div class='menu' tabindex='-1'>
						</div>
						</button>
						</div>

						<button type='button' class='tabledit-confirm-button ui teal icon button red_bg' style='display: none; float: none;'>Confirm</button>

						</div>
						</td>
						
					</tr>";
		 }
		 
		return $read;
         

	 }	
		
		
		public function downloadExcelFile($gid,$type) {
			
			$contacts = DB::table('contacts')->select(array('mobile', 'name', 'contact_id'))->where('group_id',$gid)->distinct('mobile')->get(); 
			$contacts = json_decode(json_encode($contacts), True);
			\Excel::create($gid, function($excel) use ($contacts) {
				$excel->sheet('sheet name', function($sheet) use ($contacts)
				{
					$sheet->fromArray($contacts);
				});
				
				
			})->download($type);
			return \Response::json('success');
		}      
	
}
