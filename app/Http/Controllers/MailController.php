<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request,$token){
    $user = User::where('info_token', $token)->first();
    $mailData=[
    'title'=>$request->subject,
    'body'=>$request->body
    ];
    // Mail::alwaysFrom($request->email,$request->lastName);
    // Mail::to($user->email)->send(new ContactMail($mailData));

$mail = new ContactMail($mailData);
$mail->from($request->email, $request->lastName);

// Send the email
Mail::to($user->email)->send($mail);
    return response()->json(['message' => 'Email sent successfully.', 'error' => false]);
    }

    
}
