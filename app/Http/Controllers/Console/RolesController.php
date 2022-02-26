<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use App\Role_User;
use App\User;
use App\Users_Settings;
use App\Permission;
use App\Permission_Role;
use Schema;
use Auth;
use Hash;
use Crypt;
use Mail;
use Laralum;

class RolesController extends Controller
{

    public function index()
    {
        Laralum::permissionToManage();
        # Get all the roles
        $roles = Role::whereNotIn('id', [1])->get();

        # Get Default Role
        $default_role = Role::findOrFail(Users_Settings::first()->default_role);
        $users=User::where('isReseller', '=', '1')->get();
		$permissions=Permission::all();
        # Return the view
        return view('console/roles/index', ['roles' => $roles,'permissions'=>$permissions,
        'users'=>$users, 'default_role' => $default_role]);
    }

    public function show($id)
    {
        Laralum::permissionToManage();
        # Get the role
        $role = Role::findOrFail($id);

        # Return the view
        return view('console/roles/show', ['role' => $role]);
    }

    public function edit($id)
    {

        # Find the role
        $row = Role::findOrFail($id);

        // if (!$row->allow_editing and !Laralum::loggedInuser()->su) {
        //     abort(403, trans('laralum.error_editing_disabled'));
        // }

        # Get all the data
        $data_index = 'roles';
        require('Data/Edit/Get.php');

        # Return the view  console/roles/edit
        return view('hyper/organize/roles/edit', [
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

        # Find the row
        $row = Role::findOrFail($id);


        # Save the data
        $data_index = 'roles';
        require('Data/Edit/Save.php');

        # Return the admin to the users page with a success message
        return redirect()->to($request->url . '#Roles')->with('success', trans('laralum.msg_role_edited'));
    }

    public function create()
    {
        $permissions = [];

        # Get all the data
        $data_index = 'roles';
        require('Data/Create/Get.php');
        $permissions=$this->addPermissions();

        return view('hyper.organize.roles.create', [
            'permissions'   =>  $permissions,
            'fields'        =>  $fields,
            'confirmed'     =>  $confirmed,
            'encrypted'     =>  $encrypted,
            'hashed'        =>  $hashed,
            'masked'        =>  $masked,
            'permissions'   =>  $permissions,
            'table'         =>  $table,
            'code'          =>  $code,
            'wysiwyg'       =>  $wysiwyg,
            'relations'     =>  $relations,
        ]);
    }

    public function store(Request $request)
    {
        # create new role
        $row = new Role;

        # Save the data
        $data_index = 'roles';
        require('Data/Create/Save.php');
        # Set the permissions
        $this->setPermissions($row->id, $request);

        # Return the admin to the roles page with a success message
        return redirect()->to($request->url . '#Roles')->with('success', trans('laralum.msg_role_created'));
    }

    public function editPermissions($id)
    {
        $permissions = [];

        # Find the role
        $role = Laralum::role('id', $id);


       $permissions=$this->addPermissions();
        //    $givenPermission= Permission_Role::whereRole_id($id)->get();
        foreach ($permissions as $perms) {
            foreach ($perms->module as $perm) {
                $perm->selected = $this->checkPerm($perm->id, $role->id);
            }
        }

        # Return the view  console/roles/permissions
        return view('hyper/organize/roles/permissions', [
            'role' => $role,
            'permissions' => $permissions,

        ]);
    }

    public function setPermissions($id, Request $request)
    {

        # Find the role
        $role = Laralum::role('id', $id);

        # All permissions
        $permissions = Laralum::permissions();

        # Edit the permission
        foreach ($permissions as $perm) {
            // dd($request->all()); die;
            if ($this->checkPerm($perm->id, $role->id)) {
                # The role had this permission, so we need to delete it
                $this->deletePerm($perm->id, $role->id);
            }
            if ($request->input($perm->id)) {
                $this->addPerm($perm->id, $role->id);
            }
        }

        # Return a redirect
        return redirect()->to($request->url . '#Roles')->with('success', trans('laralum.msg_role_perms_updated'));
    }

    public function checkPerm($perm_id, $role_id)
    {

        # This function returns true if the specified permission is found in the specified role and false if not

        if (Permission_Role::wherePermission_idAndRole_id($perm_id, $role_id)->first()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePerm($perm_id, $role_id)
    {

        $rel = Permission_Role::wherePermission_idAndRole_id($perm_id, $role_id)->first();
        if ($rel) {
            $rel->delete();
        }
    }

    public function addPermissions()
    {
        $permissions = [];
         # All permissions
         array_push($permissions, ((object)['name' => 'Super Admin Dashboard', 'module' => Permission::where('module', '=', 'SuperAdmin')->get()]));
         array_push($permissions, ((object)['name' => 'Member Module', 'module' => Permission::where('module', '=', 'Member')->get()]));

         array_push($permissions, ((object)['name' => 'Lead Module', 'module' => Permission::where('module', '=', 'Lead')->get()]));
         array_push($permissions, ((object)['name' => 'Staff Module', 'module' => Permission::where('module', '=', 'Staff')->get()]));

         array_push($permissions, ((object)['name' => 'Attendance Module', 'module' => Permission::where('module', '=', 'Attendance')->get()]));
         array_push($permissions, ((object)['name' => 'Holiday Module', 'module' => Permission::where('module', '=', 'Holiday')->get()]));
         array_push($permissions, ((object)['name' => 'Leave Module', 'module' => Permission::where('module', '=', 'Leave')->get()]));
         array_push($permissions, ((object)['name' => 'Department Module', 'module' => Permission::where('module', '=', 'Department')->get()]));
         array_push($permissions, ((object)['name' => 'Designation Module', 'module' => Permission::where('module', '=', 'Designation')->get()]));

         array_push($permissions, ((object)['name' => 'Campaign Module', 'module' => Permission::where('module', '=', 'Campaign')->get()]));
         array_push($permissions, ((object)['name' => 'Activity Module', 'module' => Permission::where('module', '=', 'Activity')->get()]));


         array_push($permissions, ((object)['name' => 'Donation Module', 'module' => Permission::where('module', '=', 'Donation')->get()]));
         array_push($permissions, ((object)['name' => 'Appointment Section', 'module' => Permission::where('module', '=', 'Appointments')->get()]));
         array_push($permissions, ((object)['name' => 'Prayer Section', 'module' => Permission::where('module', '=', 'prayer')->get()]));
         array_push($permissions, ((object)['name' => 'Telemarketing Section', 'module' => Permission::where('module', '=', 'telemarketing')->get()]));
         array_push($permissions, ((object)['name' => 'Vehicle Module', 'module' => Permission::where('module', '=', 'Vehicles')->get()]));
         array_push($permissions, ((object)['name' => 'Sms Module', 'module' => Permission::where('module', '=', 'Sms')->get()]));
         array_push($permissions, ((object)['name' => 'Ivr Module', 'module' => Permission::where('module', '=', 'ivr')->get()]));
        return $permissions;
    }

    public function addPerm($perm_id, $role_id)
    {

        $rel = Permission_Role::wherePermission_idAndRole_id($perm_id, $role_id)->first();
        if (!$rel) {
            $rel = new Permission_Role;
            $rel->permission_id = $perm_id;
            $rel->role_id = $role_id;
            $rel->save();
        }
    }

    public function destroy(Request $request, $id)
    {

        # Select Role
        $role = Laralum::role('id', $id);


        # Permission Relation
        $rels = Permission_Role::where('role_id', $id)->get();
        foreach ($rels as $rel) {
            $rel->delete();
        }
        # Users Relation
        $rels = Role_User::where('role_id', $id)->get();
        foreach ($rels as $rel) {
            $rel->delete();
        }

        # Delete Role
        $role->delete();

        # Redirect the admin
        return redirect()->to($request->url . '#Roles')->with('success', trans('laralum.msg_role_deleted'));
    }
}
