<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        User::create($user);

        return view('/login');
    }
}
