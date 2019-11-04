<?php

namespace App\Http\Controllers\Update;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use  Response;

class ProductController extends Controller
{
    public function getProductByCat($name)
    {
        $products = DB::table('posts')->where('sub_category_name', $name)->orderby('id', 'desc')->paginate(15);
        return view('pro_by_cat')->with('name', $name)->with('products', $products);
    }

    public function getDetail($id)
    {
        $products = Post::find($id);
        $view = $products->views + 1;
        $products->views = $view;
        $products->save();
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
        if (!empty($request->sort)) {
            if ($request->sort == 'new_ads') {
                $products = $products->orderby('id', 'desc');
            }
            if ($request->sort == 'most_view') {
                $products = $products->orderby('views');
            }
        }else{
            $products = $products->orderby('id', 'desc');
        }
        if ($request->home) {
            if (empty($request->location) && empty($request->category) && empty($request->name)) {
                return redirect()->back();
            }
        }
        $products = $products->paginate(15);
        $categories = DB::table('categories')->where('status', 'Publish')->where('parent_id', '!=', 0)->get();
        $locations = DB::table('locations')->get();
        return view('pro_by_cat')->with('products', $products)->with('name', $request->category)->with('categories', $categories)->with('locations', $locations);
    }

    public function getDeleteProImage(Request $request)
    {
        $product = Post::find($request->pid);
        $images = json_decode($product->images);
        $key = $request->key;
        $arr = explode("/", $images[$key]);
        $imgFile = $arr;
        unset($images[$key]);
        $imgFile = end($imgFile);
        File::delete('images/' . $imgFile);
        $product->images = json_encode($images);
        $product->save();
        return Response::json(array(
            'img' => $imgFile),
            200
        );
    }

}
