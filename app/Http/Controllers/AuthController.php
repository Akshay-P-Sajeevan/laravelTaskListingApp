<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/tasks');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::attempt($request->only('email', 'password'));

        return redirect('/tasks');
    }

    
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return redirect()->back()->with('status', __($response));
        }

        return redirect()->back()->withErrors(['email' => __($response)]);
    }

    
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $response = Password::reset($request->only('email', 'password', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($response === Password::PASSWORD_RESET) {
            return redirect('/login')->with('status', __('Your password has been reset!'));
        }

        return back()->withErrors(['email' => __($response)]);
    }
}
