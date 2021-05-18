<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Email;

class ManageAccountController extends Controller
{
    /**
     * Return the manage account view
     */
    public function show()
    {
        return view('manage_account');
    }

    /**
     * Update the details from the current logged in user
     * @param Illuminate\Http\Request $request
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
        ]);

        // get the current logged user
        $user = \Auth::user();

        // get the data sent
        $name = $request->input('name');
        $surnames = $request->input('surnames');
        $sex = $request->input('sex');

        // set to null the data that can be null if its empty
        $surnames = empty($surnames) ? null : $surnames;
        $sex = empty($sex) ? null : $sex;

        // update the values
        $user->name = $name;
        $user->surnames = $surnames;
        $user->sex = $sex;

        // save the changes
        $user->save();

        return back();
    }

    /**
     * Change the password from the current logged user
     * @param Illuminate\Http\Request $request
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old-password' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        // get the old password (current)
        $old_pass = $request->input('old-password');

        // get the current logged user
        $user = \Auth::user();

        // check if passwords match before changing to the new one
        if (Hash::check($old_pass, $user->password)) {
            $hashedPass = Hash::make($request->input('password'));

            // update the password
            $user->password = $hashedPass;

            // save changes
            $user->save();
            
            return response(200);
        }
        return response()->json([
            'old-password' => 'The old password filed is not correct.',
        ]);
    }
}
