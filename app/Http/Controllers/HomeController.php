<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ChangeInformationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use Alert;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product::with('images')
            ->orderBy('created_at', 'DESC')
            ->take(config('setting.number_product'))
            ->get();

        return view('users.pages.home', compact('products'));
    }

    public function changeInformation(ChangeInformationRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->username,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        alert()->success(trans('user.sweetalert.updated'), trans('user.sweetalert.change_information'));

        return redirect()->route('user.home')->with('message_success', trans('message_success'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);
            alert()->success(trans('user.sweetalert.updated'), trans('user.sweetalert.change_password'));

            return redirect()->route('user.home')->with('message_success', trans('message_success'));
        } else {

            return redirect()->route('user.home')->withErrors(['show_modal' => $request->define, 'old_password' => trans('wrong_password')]);
        }
    }
}
