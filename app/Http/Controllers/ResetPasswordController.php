<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Mail\ResetPassword;
use App\Models\Email;

class ResetPasswordController extends Controller
{
    /**
     * Receive an email from a user to recover the password
     * 
     * @param Illuminate\Http\Request $request
     */
    public function sendEmail(Request $request)
    {
        // validate the email is required, has a valid format and exists
        $validated = $request->validate([
            'email' => ['required', 'email:filter', 'email:dns', 'exists:emails'],
        ]);

        // validate the email exists in the database
        // try {
        //     // find and get the email
        //     $email = Email::where('email', $request->input('email'))->firstOrFail();
        // }
        // catch (ModelNotFoundException $exception) {
        //     return back()->withErrors([
        //         'email' => 'No user was found with this email.',
        //     ])->withInput();
        // }

        // find and get the email
        $email = Email::where('email', $request->input('email'))->first();

        // generate a uuid
        $uuid = (string) Str::uuid();

        // save the uuid in the verification_code column
        $email->verification_code = $uuid;
        $email->save();

        // send an email to the user to allow to reset the password
        Mail::to($email)->send(new ResetPassword($email));

        return back()->with([
            'success', 'We\'ve sent a message to this email address.'
        ]);
    }

    /**
     * Show the view to change the password from a user
     * Validate the email with the uuid to prevent changing passwords from other users knowing the email
     * @param Illuminate\Http\Request $request
     */
    public function changePasswordView(Request $request)
    {
        // get the email from the user to update the password and the uuid
        // validate the uuid and the email 
        $email = Email::
            where('verification_code', $request->input('uuid'))
            ->where('email', $request->input('email'))
            ->firstOrFail();
        
        return view('auth.password_reset')->with([
            'email' => $email->email,
            'uuid' => $email->verification_code
        ]);
    }
        
    /**
     * 
     * @param Illuminate\Http\Request $request
     */
    public function changePassword(Request $request)
    {
        // get the email from the user to update the password and the uuid
        // validate the uuid and the email 
        $email = Email::
            where('verification_code', $request->input('uuid'))
            ->where('email', $request->input('email'))
            ->firstOrFail();

        $validated = $request->validate([
            'password' => ['required', 'confirmed'],
        ]);

        // encrypt the password received
        $hashedPassword = Hash::make($request->input('password'));

        // change the password and save changes
        $email->user->password = $hashedPassword;
        $email->user->save();

        // reset the uuid to prevent reuse of it
        $email->verification_code = null;
        $email->save();

        // redirect to the login page sending the email to autocomplete
        return redirect()->route('login.view')->withInput([
            'email' => $email->email,
        ]);
    }
}
