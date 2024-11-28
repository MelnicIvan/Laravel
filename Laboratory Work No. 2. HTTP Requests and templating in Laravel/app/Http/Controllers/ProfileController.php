<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

//    public function adminProfiles()
//    {
//        $this->authorize('viewAny', User::class);
//        $users = User::all();
//        return view('admin.profiles', compact('users'));
//    }

    public function adminProfiles()
    {
        $users = User::all();
        return view('profiles', compact('users'));
    }
}
