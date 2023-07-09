<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class PublicMessageController extends Controller
{

    public function index()
    {
        $contact = Contact::latest()->get();
        return view('admin.public_sms.index', compact('contact'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'sender_name' => 'required|max:50',
            'phone' => 'required|max:15',
            'email' => 'max:50',
            'subject' => 'max:150',
            'ip_address' => 'max:15',
        ]);

        $contact = new Message();
        $contact->sender_name = $request->sender_name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->ip_address = $request->ip();
        $contact->save();
        if ($contact) {
            session()->flash('message', 'Successfully Submit Your Message');
            return redirect()->back();
        } else {
            session()->flash('error', 'Successfully Submit Your Message');
            return redirect()->back();
        }
    }
}
