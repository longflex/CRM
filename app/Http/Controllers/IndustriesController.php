<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class IndustriesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$industries = DB::table('industries')->get();
        return view('industries', compact('industries'));
    }
}
