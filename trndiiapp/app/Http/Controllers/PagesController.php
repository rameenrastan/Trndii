<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function getContact(){
        return view('contact');
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

        session()->flash('success','Email has been sent successfully!');

        if (Auth::check()) {
            return redirect()->route('home');
        }
        else{
            return redirect()->route('login');
        }



    }
}
