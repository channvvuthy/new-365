<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
