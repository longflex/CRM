<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Banner;
use App\Product;
use App\Testimonial;
use App\Industries;
use App\Page;
use App\User;
use App\Users_Settings;
use App\Role;
use App\Permission;
use App\Enquiry;
use Laralum;
use DB;
class ManageController extends Controller
{
    public function index()
    {
		
		 $testimonial = Testimonial::count();
		 $industries = Industries::count();
		 $enquiry = Enquiry::count();
		 $banner = Banner::count();
		 $product = Product::count();
		 $page = Page::count();
		 $roles = Role::count();
		 $permissions = Permission::count();
		 $users = User::where('isReseller', 1)->count();
         return view('console/manage/index', [
		   'testimonial' => $testimonial,
		   'industries' => $industries,
		   'banner' => $banner,
		   'product' => $product,
		   'page' => $page,
		   'roles' => $roles,
		   'permissions' => $permissions,
		   'users' => $users,
		   'enquiry' => $enquiry,
		   
		   ]);
        
    }
}
