<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Alert::success('Login Success', 'Welcome ' . $user->name);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.dashboard'); // Redirect to user dashboard if exists
            }
        }

        Alert::error('Login Failed', 'Invalid credentials');
        return redirect()->back()->withInput();
    }

    public function logout()
    {
        Auth::logout();
        Alert::success('Logged Out', 'You have been logged out successfully');
        return redirect()->route('login');
    }
}
