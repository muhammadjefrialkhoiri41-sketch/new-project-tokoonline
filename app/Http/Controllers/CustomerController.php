<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CustomerController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        $socialUser = Socialite::driver('google')->user();

        $customer = Customer::where('email', $socialUser->email)->first();

        if (!$customer) {
            $customer = Customer::create([
                'name'         => $socialUser->name,
                'email'        => $socialUser->email,
                'password'     => null,
                'google_id'    => $socialUser->id,
                'google_token' => $socialUser->token,
                'status'       => 'active',
            ]);
        } else {
            $customer->update([
                'google_id'    => $socialUser->id,
                'google_token' => $socialUser->token,
            ]);
        }

        Auth::guard('customer')->login($customer);
        request()->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}