<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getProfile()
    {
        return view('profile');
    }

    public function getUpdateProfile()
    {
        return view('pro_update');
    }

    public function getPost()
    {
        $categories = DB::table('categories')->where('status', 'Publish')->where('parent_id', '=', 0)->get();
        $locations = DB::table('locations')->get();
        return view('post')->with('categories', $categories)->with('locations', $locations);
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(['err' => 'Incorrect email or password. please try again']);
        }
        $credential = array('email' => $request->email, 'password' => $request->password);
        if (Auth::attempt($credential)) {
            return redirect('profile');
        }
        return redirect()->back()->withInput()->withErrors(['err' => 'Incorrect email or password. please try again']);
    }


    public function getStore($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $products = DB::table('posts')->where('user_id', $id)->paginate(15);
        return view('store')->with('user', $user)->with('products', $products);
    }


    public function postCreatePost(Request $request)
    {
        $image = $request->file('images');
        $data = $request->all();
        unset($data['_token']);
        $field_image = [];
        if (!empty($image)) {
            foreach ($image as $img) {
                $image_file_name = rand(1, 1000) . date('ymd') . $img->getClientOriginalName();
                $img->move('images', $image_file_name);
                $field = URL::to('/') . '/images/' . $image_file_name;
                array_push($field_image, $field);
            }
        }
        $data['images'] = json_encode($field_image);
        $data['user_id'] = Auth::user()->id;
        if (DB::table('posts')->insert($data)) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Product has been created']);
        } else {

        }
    }
}
