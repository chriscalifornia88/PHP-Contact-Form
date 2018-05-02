<?php

namespace App\Http\Controllers;


use App\ContactSubmission;
use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $values = $request->only(['name', 'email', 'phone', 'message']);

        $validator = Validator::make($values, [
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => !empty($values['phone']) ? 'required|regex:/[0-9]{9}/' : '',
            'message' => 'required'
        ], [
            'phone.regex' => 'The phone number must be a valid number.'
        ]);

        if ($validator->errors()->isNotEmpty()) {
            return redirect(URL::to('/#contact'))
                ->withInput()
                ->withErrors($validator->errors());
        }

        // Send the email
        Mail::to(env('CONTACT_MAIL_TO'))->send(new Contact(
            $values['name'], $values['email'], $values['message'], $values['phone']
        ));

        // Store in the db
        $insert = $values;
        $insert['ip'] = $request->ip();
        ContactSubmission::create($insert);

        return redirect(URL::to('/#contact'))
            ->with('contact-success', 'Thank you for getting in touch!');
    }
}