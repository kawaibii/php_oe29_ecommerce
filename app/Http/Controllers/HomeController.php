<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ChangeInformationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function home()
    {
        return view('users.pages.home');
    }

    public function changeInformation(ChangeInformationRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->username,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('user.home')->with('message_success', trans('message_success'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);

            return redirect()->route('user.homer')->with('message_success', trans('message_success'));
        } else {

            return redirect()->route('user.home')->withErrors(['show_modal' => $request->define, 'old_password' => trans('wrong_password')]);
        }
    }
}
