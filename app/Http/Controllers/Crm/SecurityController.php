<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    public function confirm()
    {
    	return view('crm/security/confirm');
    }
}
