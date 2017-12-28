<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;//do
use App\User;//do


class RegisterController extends Controller
{
    
    public function register(UserRequest $request){//do
        $user=new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user ->save();
        
    }
}
