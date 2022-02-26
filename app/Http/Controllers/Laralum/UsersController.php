<?php

namespace App\Http\Controllers\Laralum;
use Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role_User;
use App\User;
use Laralum;
use Auth;
use Gate;
use DB;
use Ixudra\Curl\Facades\Curl;

class UsersController extends Controller
{

    public function index()
    {
        // Laralum::permissionToAccess('laralum.users.access');

    	# Get all users
    	$users = Laralum::users();
    	# Get the active users
    	$active_users = Laralum::users('active', true);

    	# Get Banned Users
    	$banned_users = Laralum::users('banned', true);
		
		# Get isReseller Users
		if(Laralum::loggedInUser()->isReseller==1){ 
		    $users = Laralum::users('reseller_id', Laralum::loggedInUser()->id);
		}
    	

    	# Get all roles
    	$roles = Laralum::roles();

    	# Return the view
    	return view('laralum/users/index', [
    		'users' 		=> 	$users,
    		'roles'			=>	$roles,
    		'active_users'	=>	$active_users,
    		'banned_users'	=>	$banned_users,
		]);
    }

    public function show($id)
    {
        // Laralum::permissionToAccess('laralum.users.access');

    	# Find the user
    	$user = Laralum::user('id', $id);

    	# Return the view
    	return view('laralum/users/show', ['user' => $user]);
    }
    
	
    public function create()
    {
        Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        Laralum::permissionToAccess('laralum.users.create');

        # Get all roles
        $roles = Laralum::roles();

        # Get all the data
        $data_index = 'users';
        require('Data/Create/Get.php');

        # Return the view
        return view('laralum/users/create', [
            'roles'     =>  $roles,
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
        // Laralum::permissionToAccess('laralum.users.access');
		
        # Check permissions
        // Laralum::permissionToAccess('laralum.users.create');

        # create the user
        $row = Laralum::newUser();

        # Save the data
        $data_index = 'users';
        require('Data/Create/Save.php');

        # Setup a random activation key
        $row->activation_key = str_random(25);

        # Get the register IP
        $row->register_ip = $request->ip();

        # Activate the user if set
        if($request->input('active')){
            $row->active = true;
        }
		if(!Laralum::loggedInUser()->su){
          $row->reseller_id = Laralum::loggedInUser()->id;
		}
		
        # Save the user
        $row->save();
        #set initial balance
		if(!Laralum::loggedInUser()->su){
          $reseller_id = Laralum::loggedInUser()->id;
		}
		else{
		  $reseller_id = 0;	
		}
		$current_date = date('Y-m-d H:i:s');
		
		 DB::table('balance')->insert(['user_id' =>$row->id , 'reseller_id' => $reseller_id, 'promotional' => 0, 'transactional' => 0,'created_at' => $current_date]);
        # Send welcome email if set
        if($request->input('mail')) {
            # Send Welcome email
            $row->sendWelcomeEmail($row);
        }

        # Send activation email if set
        if($request->input('send_activation')) {
            $row->sendActivationEmail($row);
        }

        $this->setRoles($row->id, $request);
		
		
        # insert API keys
		 $activation_key = str_random(30);
	     DB::table('auth_key')->insert(['user_id' =>$row->id , 'api_key' => $activation_key,'created_at' => $current_date]);
	  
        # Return the admin to the users page with a success message
        return redirect()->route('Laralum::users')->with('success', trans('laralum.msg_user_created'));
    }

    public function edit($id)
    {
        // Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        // Laralum::permissionToAccess('laralum.users.edit');

        # Find the user
        $row = Laralum::user('id', $id);

        # Check if admin access
        Laralum::mustNotBeAdmin($row);

        # Get all the data
        $data_index = 'users';
        require('Data/Edit/Get.php');

        # Return the view
        return view('laralum/users/edit', [
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
        // Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        // Laralum::permissionToAccess('laralum.users.edit');

        # Find the user
        $row = Laralum::user('id', $id);

        # Check if admin access
        Laralum::mustNotBeAdmin($row);

        # Save the data
        $data_index = 'users';
        require('Data/Edit/Save.php');

        # Return the admin to the users page with a success message
        return redirect()->route('Laralum::users')->with('success', trans('laralum.msg_user_edited'));
    }

    public function editRoles($id)
    {
        // Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        // Laralum::permissionToAccess('laralum.users.roles');

    	# Find the user
    	$user = Laralum::user('id', $id);

        # Check if admin access
        Laralum::mustNotBeAdmin($user);

    	# Get all roles
    	$roles = Laralum::roles();

    	# Return the view
    	return view('laralum/users/roles', ['user' => $user, 'roles' => $roles]);
    }

    public function setRoles($id, Request $request)
    {
        // Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        // Laralum::permissionToAccess('laralum.users.roles');

		# Find the user
    	$user = Laralum::user('id', $id);

        # Check if admin access
        Laralum::mustNotBeAdmin($user);

    	# Get all roles
    	$roles = Laralum::roles();

    	# Change user's roles
    	foreach($roles as $role) {

            $modify = true;

            # Check for su
            if($role->su) {
                $modify = false;
            }

            # Check if it's assignable
            if(!$role->assignable and !Laralum::loggedInUser()->su) {
                $modify = false;
            }

            if($modify) {
                if($request->input($role->id)){
                    # The admin selected that role

                    # Check if the user was already in that role
                    if($this->checkRole($user->id, $role->id)) {
                        # The user is already in that role, so no change is made
                    } else {
                        # Add the user to the selected role
                        $this->addRel($user->id, $role->id);
                    }
                } else {
                    # The admin did not select that role

                    # Check if the user was in that role
                    if($this->checkRole($user->id, $role->id)) {
                        # The user is in that role, so as the admin did not select it, we need to delete the relationship
                        $this->deleteRel($user->id, $role->id);
                    } else {
                        # The user is not in that role and the admin did not select it
                    }
                }
            }
    	}

    	# Return Redirect
        return redirect()->route('Laralum::users')->with('success', trans('laralum.msg_user_roles_edited'));
    }

    public function checkRole($user_id, $role_id)
    {
        // Laralum::permissionToAccess('laralum.users.access');

    	# This function returns true if the specified user is found in the specified role and false if not

    	if(Role_User::whereUser_idAndRole_id($user_id, $role_id)->first()) {
    		return true;
    	} else {
    		return false;
    	}

    }

    public function deleteRel($user_id, $role_id)
    {
        // Laralum::permissionToAccess('laralum.users.access');

    	$rel = Role_User::whereUser_idAndRole_id($user_id, $role_id)->first();
    	if($rel) {
    		$rel->delete();
    	}
    }

    public function addRel($user_id, $role_id)
    {
        // Laralum::permissionToAccess('laralum.users.access');

    	$rel = Role_User::whereUser_idAndRole_id($user_id, $role_id)->first();
    	if(!$rel) {
    		$rel = new Role_User;
    		$rel->user_id = $user_id;
    		$rel->role_id = $role_id;
    		$rel->save();
    	}
    }

    public function destroy($id)
    {
        // Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        // Laralum::permissionToAccess('laralum.users.delete');

        # Find The User
        $user = Laralum::user('id', $id);

        # Check if admin access
        Laralum::mustNotBeAdmin($user);

        # Check if it's su
        if($user->su) {
            abort(403, trans('laralum.error_security_reasons'));
        }

    	# Check before deleting
    	if($id == Laralum::loggedInUser()->id) {
            abort(403, trans('laralum.error_user_delete_yourself'));
    	} else {

    		# Delete Relationships
    		$rels = Role_User::where('user_id', $user->id)->get();
    		foreach($rels as $rel) {
    			$rel->delete();
    		}

    		# Delete User
    		$user->delete();

    		# Return the admin with a success message
            return redirect()->route('Laralum::users')->with('success', trans('laralum.msg_user_deleted'));
    	}
    }

    public function editSettings()
    {
        // Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        // Laralum::permissionToAccess('laralum.users.settings');

    	# Get the user settings
    	$row = Laralum::userSettings();

        # Update the settings
        $data_index = 'users_settings';
        require('Data/Edit/Get.php');

    	return view('laralum/users/settings', [
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

    public function updateSettings(Request $request)
    {
        // Laralum::permissionToAccess('laralum.users.access');

        # Check permissions
        // Laralum::permissionToAccess('laralum.users.settings');

    	# Get the user settings
    	$row = Laralum::userSettings();

    	# Update the settings
        $data_index = 'users_settings';
        require('Data/Edit/Save.php');

    	# Return a redirect
        return redirect()->route('Laralum::users')->with('success', trans('laralum.msg_user_update_settings'));
    }
	#user switching method
	public function user_switch_start($new_user)
	{
	  $new_user = User::find($new_user);
	  Session::put( 'orig_user', Auth::id() );
	  Auth::login( $new_user );
	  return redirect()->route('Laralum::dashboard');
	}
	
	public function user_switch_stop()
	{
	  $id = Session::pull( 'orig_user' );
	  $orig_user = User::find( $id );
	  Auth::login( $orig_user );
	  return redirect()->route('Laralum::dashboard');
	}
	
	public function viewDetails($id)
    {
		
    //    Laralum::permissionToAccess('laralum.users.access');
	   //echo '<pre>';print_r($allcountry);die;
        # Get  all country
    	$allcountry = Laralum::countries();
		$industry = Laralum::getIndustries();
		
		$roles = DB::table('roles')->where('su', '!=', 1)->get();
		$rolesid = DB::table('role_user')->select('role_id')->where('user_id',$id)->first();
		$rid='';
		if($rolesid) {
			$rid = $rolesid->role_id;
		}
		
		
    	# Get  users
    	$users = DB::table('users')->where('id', $id)->first();
		
		# Get  users balance
    	$userBalance = DB::table('balance')->where('user_id', $id)->first();
		
		# Get  admin balance
		if(!Laralum::loggedInUser()->su){
			$adminBalance = DB::table('balance')->where('user_id',Laralum::loggedInUser()->id)->first();
			
		}else{
			
			$adminBal = explode(",",$this->getAdminBalance()); 
			$adminBalance = array('promotional'=> trim($adminBal[0]), 'transactional'=> trim($adminBal[1]), 'otp'=>0, 'Keyword'=>0, 'Inbox'=>0);
			$adminBalance = (object) $adminBalance;
			
		}
		// for example

          //get the current user
           $user = DB::table('users')->where('id',$id)->first();

         //get previous user id
           $previous = DB::table('users')->where('id', '<', $user->id)->max('id');
		   $previousName = DB::table('users')
                     ->select('name')
                     ->where('id',  $previous)
                     ->first();

         // get next user id
         $next = DB::table('users')->where('id', '>', $user->id)->min('id');
		 $nextName = DB::table('users')
                     ->select('name')
                     ->where('id',  $next)
                     ->first();
             
		$nextName = ($nextName) ? $nextName->name : '';
		$previousName = ($previousName) ? $previousName->name : '';
    	# Return the view
    	return view('laralum/users/details', [
    		'users' 	   =>  $users,
    		'balance'      =>  $userBalance,
			'adminBalance' =>  $adminBalance,
			'previous'     =>  $previous,
			'previousName'     =>  $previousName,
			
			'next'     =>  $next,
			'nextName'     =>  $nextName,
			'countries'   => $allcountry,
			'industries'   =>$industry,
			'roles'       => $roles,
			'role_id'     => $rid,
		]);
    	
    }
	
	 public function profileStatus(Request $request)
     {
    //    Laralum::permissionToAccess('laralum.users.access');
      //echo '<pre>';print_r($request->all());die;
    	# update  users
    	DB::table('users')->where('id', $request->user_id )->update(['active' => $request->user_status]);
    	# Return the view
    	 return response()->json(array('success' => true, 'status' => $request->user_status), 200);
    	
     }
	 
	 public function openidAction(Request $request)
     {
    //    Laralum::permissionToAccess('laralum.users.access');
    	# update  users
    	DB::table('users')->where('id', $request->userid )->update(['is_openid_access' => $request->openid]);
    	# Return the view
    	 return response()->json(array('success' => true, 'status' => 'success'), 200);
    	
     }
	 
	  public function changeRole(Request $request)
      {
    //    Laralum::permissionToAccess('laralum.users.access');
	   
    	# update  users
    	 DB::table('role_user')->where('user_id', $request->userid )->update(['role_id' => $request->roleid]);
		 
		 # update if users is reseller
		 if($request->roleid==3){
    	   DB::table('users')->where('id', $request->userid )->update(['isReseller' => 1]);
		 }else{
			DB::table('users')->where('id', $request->userid )->update(['isReseller' =>0]); 
		 }
    	# Return the view
    	 return response()->json(array('success' => true, 'status' => 'success'), 200);
    	
     }
	 
	  public function updateProfile(Request $request)
      {
        //  Laralum::permissionToAccess('laralum.users.access');
     
			$fullname = $request->fullname;
			$industry = $request->industry;
			$city = $request->city;
			$zipcode = $request->zipcode;
			$mobile = $request->mobile;
			$country = $request->country;
			$company = $request->company;
			$address = $request->address;
			$userid = $request->userid;
			$updated = date('Y-m-d H:i:s');
			# update  users
			DB::table('users')->where('id', $userid )->update(['name' => $fullname, 'mobile' => $mobile, 'city' => $city, 'zip' => $zipcode, 'address' => $address, 'industry' => $industry, 'company' => $company, 'country_code' => $country, 'updated_at' => $updated]);
    	# Return the view
    	 return response()->json(array('success' => true, 'status' => 'success'), 200);
    	
     }
	 
	  public function CRDRbalence(Request $request)
      {
        // Laralum::permissionToAccess('laralum.users.access');
        //echo '<pre>';print_r($request->all());die;
		$route = $request->route;
		$unit = $request->credit;
		$rate = $request->price;
		$description = $request->description;
		$action = $request->action;
		$user = $request->user;
		$amount = $unit*$rate;
		$current_date = date('Y-m-d H:i:s');
    	#update balance
		 if($route==1){
				 if($action=='credit'){
				   $updatecredit = DB::table('balance')->where('user_id', $user)->increment('promotional', $unit);
				 }else{
				   $updatecredit = DB::table('balance')->where('user_id', $user)->decrement('promotional', $unit); 
				 }
		 }else{
			  if($action=='credit'){
				   $updatecredit = DB::table('balance')->where('user_id', $user)->increment('transactional', $unit);
				 }else{
				   $updatecredit = DB::table('balance')->where('user_id', $user)->decrement('transactional', $unit); 
				 }
		 }
		 
		 DB::table('transaction')->insert(['user_id' =>$user , 'route' => $route, 'unit' => $unit, 'amount' => $amount, 'rate' => $rate, 'action' => $action, 'description' => $description, 'created_at' => $current_date]);
    	# Return the view
    	 return response()->json(array('success' => true, 'action' => $action), 200);
    	
      }
	
	protected function getAdminBalance()
	{
		
		$pbalance = Curl::to('https://control.msg91.com/api/balance.php')
						->withData(['authkey'=>'130199AKQsRsJy581b6dd5', 'type'=>1])
						->post();
		$tbalance = Curl::to('https://control.msg91.com/api/balance.php')
		   ->withData(['authkey'=>'130199AKQsRsJy581b6dd5', 'type'=>4])
		   ->post();
		return  $pbalance.','.$tbalance;
	}	
	
}
