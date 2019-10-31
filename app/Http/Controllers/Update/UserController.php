<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return view('post');
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
        return view('store')->with('user', $user);
    }
}
