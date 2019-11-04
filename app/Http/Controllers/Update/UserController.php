<?php

namespace App\Http\Controllers\Update;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $locations = DB::table('locations')->get();
        return view('pro_update')->with('locations', $locations);
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


    public function getStore(Request $request, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!empty($request->sort)) {
            if($request->sort=='new_ads'){
                $products = DB::table('posts')->where('user_id', $id)->orderby('id','desc')->paginate(15);
            }
            if($request->sort=='most_view'){
                $products = DB::table('posts')->where('user_id', $id)->orderby('views')->paginate(15);
            }
        }

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
            return redirect()->back()->withInput()->withErrors(['error' => 'Fail to create product']);
        }
    }


    public function getUpdateProduct($id)
    {
        $product = DB::table('posts')->where('id', $id)->first();
        $categories = DB::table('categories')->where('status', 'Publish')->where('parent_id', '=', 0)->get();
        $locations = DB::table('locations')->get();
        return view('update_pro')->with('product', $product)->with('categories', $categories)->with('locations', $locations);
    }

    public function postUpdateProduct(Request $request)
    {
        $image = $request->file('images');
        $data = $request->all();
        unset($data['_token']);
        $imgResource = DB::table('posts')->where('id', $request->id)->select('images')->first();
        $field_image = json_decode($imgResource->images);
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
        if (DB::table('posts')->where('id', $request->id)->update($data)) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Product has been updated']);
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Fail to create product']);
        }
    }

    public function postUpdateProfile(Request $request)
    {
        $image = $request->file('image');
        $data = $request->all();
        unset($data['_token']);
        if (!empty($image)) {
            $image_file_name = rand(1, 1000) . date('ymd') . $image->getClientOriginalName();
            $image->move('images', $image_file_name);
            $data['image'] = $image_file_name;
        }
        if (DB::table('users')->where('id', Auth::user()->id)->update($data)) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Product has been created']);
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Fail to create product']);
        }
    }

    public function postForgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(['errForgot' => "Email doesn't exist in the database"]);
        }
        $subject = 'Forgot your password';
        $email = $request->email;
        $name = explode("@", $email);
        $name = $name[0];
        $user = User::where('email', $email)->first();
        $verification_code = $this->quickRandom();
        $user->verification_code = $verification_code;
        $user->save();
        Mail::send('email.forgot', ['name' => $name, 'verification_code' => $verification_code],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(getenv('FROM_EMAIL_ADDRESS'), "channvuthyit@gmail.com");
                $mail->to($email, $name);
                $mail->subject($subject);
            });
        return redirect()->back()->withInput()->withErrors(
            [
                'msg' => '<p>We have sent an email with a link to reset your password to the email address ready.</p>',
                'btn' => 'success'
            ]);
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function getReset($code)
    {
        $user = User::where('verification_code', $code)->first();
        if (empty($user)) {
            return redirect('/')->withErrors(['errForgot' => "Email doesn't exist in the database"]);
        }
        return redirect('/')->withErrors(["verification_code" => $code]);

    }

    public function postReset(Request $request)
    {
        $verification_code = $request->verification_code;
        $user = User::where('verification_code', $verification_code)->first();
        if (empty($user)) {
            return redirect('/')->withErrors(['errForgot' => "Verification code doesn't exist in the database"]);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('/')->withErrors(['login' => "Verification code doesn't exist in the database"]);
    }
}
