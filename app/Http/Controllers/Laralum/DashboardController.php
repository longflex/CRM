<?php

namespace App\Http\Controllers\Laralum;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;

class DashboardController extends Controller
{
    public function index()
    {
        Laralum::permissionToAccess('laralum.sms.dashboard');
    	return view('laralum/dashboard/index');
    }
}
