<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class TermsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
	    $content = DB::table('pages')->where('type', 2)->first();
        return view('terms', compact('content'));
    }
}
