<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class ResourceController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$content = DB::table('pages')->where('type', 5)->first();
        return view('resource', compact('content'));
    }
}
