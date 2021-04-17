<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Email;

class LoginController extends Controller
{
    /**
     * Try to log in a user
     */
    public function authenticate(Request $request)
    {
        // validate email
        $validated = $request->validate([
            'email' => ['required', 'email:filter'],
        ]);

        // get the credentials from the request
        $email = $request->input('email');
        $password = $request->input('password');

        // search and get the email from the database
        $userEmail = Email::where('email', $email)->first();

        // check if an email was found
        if ($userEmail !== null) {
            // test if password sent and hashed password match
            if (Hash::check($password, $userEmail->user->password)) {
                // start a new session
                $request->session()->regenerate();
                // login manually the user
                Auth::login($userEmail->user);
                               
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'credentials' => 'The provided credentials do not match our records.',
        ]);
    }
}
