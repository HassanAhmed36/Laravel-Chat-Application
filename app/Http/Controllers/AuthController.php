<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('auth.login');
    }

    public function rigester()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('auth.rigester');
    }

    public function SubmitRigester(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'User Rigester Successfully!');
    }
    public function SubmitLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid Credentials email');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('login')->with('error', 'Invalid Credentials password');
        }

        $user->update(['is_active' => 1]);

        Auth::login($user);

        return redirect()->route('search.user')->with('success', 'User logged in successfully!');
    }
    public function logout()
    {
        $user_id = Auth::user()->id;
        User::findOrFail($user_id)->update(['is_active' => 0]);
        Auth::logout();
        return redirect()->route('index')->with('success', 'User Logout Successfully!');
    }
}
