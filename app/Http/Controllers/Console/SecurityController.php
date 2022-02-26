<?php

namespace App\Http\Controllers\console;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    public function confirm()
    {//console/security/confirm
    	return view('hyper/organize/security/confirm');
    }
}
