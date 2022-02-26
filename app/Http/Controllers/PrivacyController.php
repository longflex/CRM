<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class PrivacyController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$content = DB::table('pages')->where('type', 3)->first();
        return view('privacy', compact('content'));
    }
}
