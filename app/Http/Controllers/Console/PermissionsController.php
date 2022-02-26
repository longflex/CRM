<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Permission_Role;
use App\Permission;
use Laralum;

class PermissionsController extends Controller
{
    public function index()
    {
        
    	# Get all the permissions
    	$permissions = Permission::all();

    	# Return the view
    	return view('console/permissions/index', ['permissions' => $permissions]);
    }

    public function create()
    {
       
        $data_index = 'permissions';
        require('Data/Create/Get.php');

    	# Return the creation view
    	return view('console/permissions/create', [
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
       
		$row = Laralum::newPermission();
        $data_index = 'permissions';
		require('Data/Create/Save.php');

		# return a redirect
		return redirect()->route('console::permissions')->with('success', trans('laralum.msg_permission_created'));
    }

    public function edit($id)
    {
        
    	$row = Laralum::permission('id', $id);

        $data_index = 'permissions';
		require('Data/Edit/Get.php');


    	# Return the view
    	return view('console/permissions/edit', [
            'row'       =>  $row,
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

    public function update($id, Request $request)
    {
        
    	$row = Laralum::permission('id', $id);

        $data_index = 'permissions';
		require('Data/Edit/Save.php');

		# return a redirect
		return redirect()->route('console::permissions')->with('success', trans('laralum.msg_permission_updated'));
    }

    public function destroy($id)
    {
        
    	$perm = Laralum::permission('id', $id);

    

    	# Delete relationships
    	$rels = Permission_Role::where('permission_id', $perm->id)->get();
    	foreach($rels as $rel) {
    		$rel->delete();
    	}

    	# Delete Permission
    	$perm->delete();

    	# Return a redirect
    	return redirect()->route('console::permissions')->with('success', trans('laralum.msg_permission_deleted'));
    }

}
