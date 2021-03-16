<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller
{
    public function store($id){
        Auth::user()->follow($id);
        return back();
    }

    public function delete($id){
        Auth::user()->unfollow($id);
        return back();
    }
}
