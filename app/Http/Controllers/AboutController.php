<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AboutController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$content = DB::table('pages')->where('type', 1)->first();		
        return view('about', compact('content'));
    }
}
