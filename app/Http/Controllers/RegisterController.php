<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Hash;

class RegisterController extends Controller
{
    public function getRegister()
    {
        return view('users.pages.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => config('role.user'),
            'status' => config('user.status.on'),
        ]);

        return redirect()->route('user.getLogin');
    }
}
