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

    public function LoadChat($id)
    {
        return view('chat');
    }
}
