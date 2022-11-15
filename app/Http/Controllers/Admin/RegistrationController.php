<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clients;
use App\User;

class RegistrationController extends Controller
{
    public function registration(Request $request)
    {
        return view('auth.registration');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6'
        ]);

        $input = $request->all();
        Clients::create($input);
        $fullname = $request->first_name.' '.$request->middle_name.' '.$request->last_name;
        $user = User::create([
            'name' => $fullname,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $user->roles()->sync(2);

        return redirect()->route('auth.registration')->with('success','Successfully Registered! You may now login to your account.');
    }
}
