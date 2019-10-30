<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use App\User;
use Illuminate\Support\Facades\Validator;
use URL;
use Mail;
use App\Store;

class SingUpController extends Controller
{
    public function postSignUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $fileUpload = null;
        $image = $request->file("image");
        $file_random = md5(rand(1, 1000));
        if (!empty($image)) {
            $fileName = $image->getClientOriginalName();
            $file_allow = array("jpg", "png", "gif");
            $extension = $image->getClientOriginalExtension();
            if (!in_array($extension, $file_allow)) {
                return Response::json(array(
                    'error' => 'File is invalid extension',
                ),
                    404
                );
            }
            $fileUpload = $file_random . $fileName;
            $image->move("images", $fileUpload);
        }
        $verification_code = str_random(30);
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;
        $sex = $request->sex;
        $email = $request->email;
        $location = $request->location;
        $password = $request->password;
        $password = bcrypt($password);
        $name = $last_name . " " . $first_name;
        $user = new User();
        $user->name = $name;
        $user->last_name=$last_name;
        $user->first_name=$first_name;
        $user->email = $email;
        $user->password = $password;
        $user->image = URL::to('/') . "/images/" . $fileUpload;
        $user->location = $location;
        $user->phone = $phone;
        $user->sex = $sex;
        $user->verification_code = $verification_code;
        if ($user->save()) {
            $subject = "Please verify your email address.";
            Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
                function ($mail) use ($email, $name, $subject) {
                    $mail->from(getenv('FROM_EMAIL_ADDRESS'), "info@365daymarket.com");
                    $mail->to($email, $name);
                    $mail->subject($subject);
                });
        }
        $store=new Store();
        $store->name=$name;
        $store->address="";
        $store->phone=$phone;
        $store->google_map="";
        $store->verification_code=  $verification_code;
        $store->save();
        return response()->json(['success' => true, 'message' => 'Thanks for signing up! Please check your email to complete your registration.']);
    }

    public function getVerify($code)
    {
        $user = User::where('verification_code', $code)->first();
        $store=Store::where('verification_code',$code)->first();
        $store->user_id=$user->id;
        $store->save();
        if (!is_null($user)) {
            if ($user->verified == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account already verified..'
                ]);
            }
            $user->verified = 1;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'You have successfully verified your email address.'
            ]);
        }
        return response()->json(['success' => false, 'error' => "Verification code is invalid."]);
    }

    function register()
    {
        return view('register');
    }
}
