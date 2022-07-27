<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * 处理个人页面显示
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
}
