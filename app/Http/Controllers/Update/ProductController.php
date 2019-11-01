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

    public function getFilter(Request $request)
    {

        $products = DB::table('posts');
        if (!empty($request->location)) {
            $products = $products->where('location_name', $request->location);
        }
        if (!empty($request->category)) {
            $products = $products->where('sub_category_name', $request->category);
        }
        if (!empty($request->from)) {
            $products = $products->where('price', '>=', $request->from);
        }
        if (!empty($request->to)) {
            $products = $products->where('price', '<=', $request->to);
        }
        if (!empty($request->name)) {
            $name = $request->name;
            $products = $products->where('name', 'LIKE', "%$name%");
        }
        $products = $products->paginate(15);
        $categories = DB::table('categories')->where('status', 'Publish')->where('parent_id', '!=', 0)->get();
        $locations = DB::table('locations')->get();
        return view('pro_by_cat')->with('products', $products)->with('name', $request->category)->with('categories', $categories)->with('locations', $locations);
    }
}
