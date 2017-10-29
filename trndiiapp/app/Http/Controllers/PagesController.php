<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    }
}
