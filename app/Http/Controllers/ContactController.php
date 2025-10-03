<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'userMessage' => $request->message,
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->to('sparkeducationpalestine@gmail.com')
                ->subject('New Contact Message from ' . $data['name'])
                ->replyTo($data['email']);
        });

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
