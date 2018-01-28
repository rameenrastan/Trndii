<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Log;

class PagesController extends Controller
{
    public function getContact(){
        Log::info("A user is viewing the contact page.");
        return view('contact');
    }

    public function getFAQ(){
        Log::info("A user is viewing the FAQ page.");
        return view('help.faq');
    }

    public function getAboutUs(){
        Log::info("A user is viewing the About Us page.");
        return view('help.aboutUs');
    }

    public function postContact(Request $request){
        $this->validate($request, [
            'email'=>'required|email',
            'subject'=>'min:3',
            'message' =>'min:10'
            ]);

        $data=array(
            'email'=>$request->email,
            'subject'=>$request->subject,
            'bodyMessage'=>$request->message
        );

        Mail::send('mail.contact',$data,function ($message) use($data){
            $message->from($data['email']);
                $message->to('asdasd-a126ef@inbox.mailtrap.io');
                    $message->subject($data['subject']);
        });

        Log::info($request->email . " has sent a contact email.");
        session()->flash('success','Email has been sent successfully!');

        if (Auth::check()) {
            return redirect()->route('home');
        }
        else{
            return redirect()->route('login');
        }
    }
}
