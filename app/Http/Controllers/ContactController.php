<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'sometimes|regex:/[0-9]{9}/',
            'message' => 'required'
        ], [
            'phone.regex' => 'The phone number must be a valid number.'
        ]);

        if ($validator->errors()->isNotEmpty()) {
            return redirect(URL::to('/#contact'))->withErrors($validator->errors());
        }

        // Store in the db

        // Send the email
    }
}