<?php
namespace App\Http\Controllers\Ivr;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laralum;

class FollowupController extends Controller
{
    public function index()
    {
    	return view('ivr/followup/index');
    }
}
