<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;

class RegisterController extends Controller
{
    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        unset($data['_token']);
        $data['password'] = bcrypt($request->password);
        $name = head(explode("@", $request->email));
        $data['name'] = $name;
        $data['verification_code'] = rand(1, 10000) . date('mdy');
        if (User::create($data)) {
            return redirect()->back()->withInput()->withErrors(['confirm' => 'Please confirm your email address']);
        }
        return redirect()->back()->withInput()->withErrors(['error' => 'Cannot register']);


    }
}
