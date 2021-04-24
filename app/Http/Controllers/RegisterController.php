<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Email;

class RegisterController extends Controller
{
    /**
     * Create a new email, set the verification code and send an email with it
     * Receive an email
     */
    public function registerEmail(Request $request)
    {
        // validate email before continuing
        $validated = $request->validate([
            'email' => ['required', 'email:filter', 'email:dns', 'unique:emails']
        ]);

        // generate the verification code
        $verificationCode = Str::random(6);

        // get the email from the request
        $email = $request->input('email');
        
        // create and insert a new email
        $email = Email::create([
            'email'=> $email,
            'verification_code' => $verificationCode,
        ]);

        // send the email with the verification code

        // send the response with status code 201 (created a new resource)
        return response('registered', 201);
    }

    /**
     * Receive an email and a verification code
     * Compare the code set for the email and the code received
     */
    public function validateEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:filter', 'exists:emails']
        ]);

        // get the verification code sent
        $verificationCode = $request->input('verification_code');

        // search and get the email on the database
        $email = Email::where('email', $request->input('email'))->firstOrFail();

        // compare if code sent is the same as the code for the email
        if ($email->verification_code === $verificationCode) {
            // update the email
            $email->verified = true;
            $email->verified_at = Carbon::now();
            $email->save();
            
            $message = 'verified';
            $statusCode = 202;
        } else {
            $message = 'not_verified';
            $statusCode = 401;
        }
        
        // send the response with status code 200 and message
        return response($message, $statusCode);
    }

    /**
     * Receive and email, name, surnames, sex and password
     */
    public function registerUser(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:filter', 'exists:emails'],
            'name' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        // get the data from the request
        $email = $request->input('email');
        $name = $request->input('name');
        $surnames = $request->input('surnames');
        $sex = $request->input('sex');
        $password = $request->input('password');
        
        // set to null the data that can be null if its empty
        $surnames = $surnames === '' ? null : $surnames;
        $sex = $sex === '' ? null : $sex;

        // hash the password
        $hashedPassword = Hash::make($password);

        // search and get the email from the database
        $email = Email::where('email', $email)->firstOrFail();

        // create a new user
        $user = User::create([
            'name' => $name,
            'surnames' => $surnames,
            'sex' => $sex,
            'password' => $hashedPassword,
            'email_id' => $email->id,
        ]);

        // redirect to to home page
        return redirect()->route('login.view');
    }
}