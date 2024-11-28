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

    public function adminProfiles()
    {
        $users = User::all();
        return view('profiles', compact('users'));
    }
}
