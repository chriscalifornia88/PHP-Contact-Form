<?php

namespace App\Http\Controllers;


use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $values = $request->all();

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

        // Store in the db

        // Send the email
        Mail::to(env('CONTACT_MAIL_TO'))->send(new Contact(
            $values['name'], $values['email'], $values['message'], $values['phone']
        ));
    }
}