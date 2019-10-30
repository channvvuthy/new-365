<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use URL;

class SignInController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $credentials['verified'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data' => ['token' => $token]]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message' => "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    public function getProfile()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public  function postProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|exists:users',
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
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;
        $sex = $request->sex;
        $email = $request->email;
        $location = $request->location;
        $password = $request->password;
        $password = bcrypt($password);
        $name = $last_name . " " . $first_name;
        $user = User::find($request->id);
        $user->name = $name;
        $user->last_name = $last_name;
        $user->first_name = $first_name;
        $user->email = $email;
        $user->password = $password;
        if($fileUpload !=null){
            $user->image = URL::to('/') . "/images/" . $fileUpload;
        }
        $user->location = $location;
        $user->phone = $phone;
        $user->sex = $sex;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Your profile has been updated!']);
    }
}
