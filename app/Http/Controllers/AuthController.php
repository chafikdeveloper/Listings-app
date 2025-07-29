<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $credentails = $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'email' => ['required', 'email', 'lowercase', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create($credentails);

        //TODO: send a verification email

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'lowercase', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
