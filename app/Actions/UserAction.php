<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;


class UserAction
{
    /**
     * @param \Illuminate\Http\Request
     * @return false|string $token
     */


    public function store(Request $request)
    {
       $user = new User();
       $user->name=$request['name'];
        $user->email=$request['email'];
        $user->password= Hash::make($request['password']);

        $user->save();
    }
}