<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AboutControllerr extends Controller
{
    public function getAbout()
    {
        return view('about');
    }

    public function postAbout(Request $request)
    {
        Mail::send('email.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function ($message) {
                $message->from('channvuthyit@gmail.com');
                $message->to('sengan.sor@gmail.com', 'Admin')->subject('Feedback from user');
            });
        return back()->withErrors(['success'=>'Thanks for contacting us!']);
    }
}
