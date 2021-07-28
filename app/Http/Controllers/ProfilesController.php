<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show')
            ->withProfileUser($user)
            ->withThreads($user->threads()->paginate(30));
    }
}
