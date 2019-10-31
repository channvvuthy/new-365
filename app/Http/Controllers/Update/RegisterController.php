<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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
        $data['verification_code'] = rand(1, 100000) . date('mdy');
        if (User::create($data)) {
            $subject = 'Confirm your email address';
            $email = $data['email'];
            Mail::send('email.mail', ['name' => $name, 'verification_code' => $data['verification_code']],
                function ($mail) use ($email, $name, $subject) {
                    $mail->from(getenv('FROM_EMAIL_ADDRESS'), "channvuthyit@gmail.com");
                    $mail->to($email, $name);
                    $mail->subject($subject);
                });

            return redirect()->back()->withInput()->withErrors(
                [
                    'msg' => '<p>We have sent an email with a confirmation link to your email address.</p><p>Please verify that you entered a valid email address</p>',
                    'btn' => 'success'
                ]);
        }
        return redirect()->back()->withInput()->withErrors(['msg' => '<p>Registration failed please try again later</p>', 'btn' => 'danger']);

    }

    public function getVerify($code)
    {
        $user = User::where('verification_code', $code)->first();
        if (empty($user)) {
            return redirect()->back()->withInput()->withErrors(['msg' => '<p>Verify code not exists</p>', 'btn' => 'danger']);
        }
        $user->verified = 1;
        $user->save();
        Auth::login($user);
        return redirect('profile');
    }
}
