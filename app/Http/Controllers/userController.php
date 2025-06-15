<?php

namespace App\Http\Controllers;

use App\Actions\AuthAction;
use App\Actions\UserAction;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function loginUser( Request $request, AuthAction $authAction){
        // return $request;
        if (!isset($request['email'], $request['password'])) {
            return $authAction->loginWithToken($request);
        }
           return $authAction->authenticate($request);
    }

    public function getUser(AuthAction $authAction){
        return $authAction->getUser();
    }

    public function register(Request $request, UserAction $userAction){
        return $userAction->store($request);
    }

    public function logout(AuthAction $authAction){
        return $authAction->logout();
    }
}
