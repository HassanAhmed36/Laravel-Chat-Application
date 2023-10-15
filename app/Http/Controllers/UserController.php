<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function searchUser(Request $request)
    {
        $users = null;

        if ($request->has('search')) {
            $search = $request->search;
            $current_user_id = Auth::user()->id;
            $users = User::where('name', 'LIKE', '%' . $search . '%')->where('id', '!=', $current_user_id)->get();
        }


        return view('search-user', compact('users'));
    }

    public function showProfile($id)
    {
        $User = User::findOrFail($id);

        if ($User->id == Auth::user()->id) {
            return view('profile', compact('User'));
        } else {
            return redirect()->back()->with('error', 'Not Authorized');
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'password' => 'confirmed',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->input('username');
        $user->email = $request->input('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        return redirect()->route('search.user')->with('success', 'Profile updated successfully.');
    }

}
