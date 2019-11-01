<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProductByCat($name)
    {
        $products = DB::table('posts')->where('sub_category_name', $name)->orderby('id', 'desc')->paginate(15);
        return view('pro_by_cat')->with('name', $name)->with('products', $products);
    }

    public function getDetail($id)
    {
        $products = DB::table('posts')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $products->user_id)->first();
        return view('pro_detail')->with('products', $products)->with('user', $user);
    }
}
