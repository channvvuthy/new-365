<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class HomeController extends Controller
{
    public function getIndex()
    {
        $categories = DB::table('categories')->where('status', 'Publish')->where('parent_id', '!=', 0)->get();
        $locations = DB::table('locations')->get();
        return view('home')->with('categories', $categories)->with('locations', $locations);
    }
}
