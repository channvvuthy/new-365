<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use File;
use Illuminate\Support\Facades\Response;
use URL;

class ProfileController extends Controller
{
    public function getProfile(Request $request){

        $user= User::find($request->id);
        if(empty($user->id)){
            return response()->json(['message'=> 'User not found!',404]);
        }
        return view('profile')->with('user',$user);
    }

    public function postProfile(Request $request){

//        $this->validate($request, [
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required|email',
//            'password' => 'required|min:6'
//        ]);
//        $fileUpload = null;
//        $image = $request->file("image");
//        $file_random = md5(rand(1, 1000));
//        if (!empty($image)) {
//            $fileName = $image->getClientOriginalName();
//            $file_allow = array("jpg", "png", "gif");
//            $extension = $image->getClientOriginalExtension();
//            if (!in_array($extension, $file_allow)) {
//                return Response::json(array(
//                    'error' => 'File is invalid extension',
//                ),
//                    404
//                );
//            }
//            $fileUpload = $file_random . $fileName;
//            $image->move("images", $fileUpload);
//        }
//        $verification_code = str_random(30);
//        $first_name = $request->first_name;
//        $last_name = $request->last_name;
//        $phone = $request->phone;
//        $sex = $request->sex;
//        $email = $request->email;
//        $location = $request->location;
//        $password = $request->password;
//        $password = bcrypt($password);
//        $name = $last_name . " " . $first_name;
//        $user = User::find($request->id);
//        if(empty($user)){
//            return response()->json(['message'=> 'User not found!',404]);
//
//        }
//
//        $user->name = $name;
//        $user->email = $email;
//        $user->password = $password;
//        if($fileUpload !=null){
//            $user->image = URL::to('/') . "/images/" . $fileUpload;
//        }
//        $user->location = $location;
//        $user->phone = $phone;
//        $user->sex = $sex;
//        $user->first_name=$first_name;
//        $user->last_name=$last_name;
//        $user->verification_code = $verification_code;
//        $user->save();
//        return response()->json(['success'=> true, 'message'=> 'Your profile has been updated!']);
    }
}
