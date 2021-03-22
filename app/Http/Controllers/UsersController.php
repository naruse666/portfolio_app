<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index(Request $request){
        // 検索の有無
        if(isset($request->search)){
            $users = User::where('name', 'LIKE', '%' . $request->search . '%')->paginate(10);
            $result = $request->search;
            $len = count($users);
            $search = true;
            return view('users.index', compact(['users', 'search', 'result', 'len']));
        } else {
            $users = User::orderby('created_at', 'desc')->paginate(10);
            $search = false;
            $result = '';
            $len = 0;
            return view('users.index', compact(['users', 'search', 'result', 'len']));
        }
    }

    public function show($id){
        $user = User::findOrfail($id);
        // フォロー・フォロワーユーザ取得
        $followings = $user->followings()->get();
        $followers = $user->followers()->get();
        // つぶやき取得
        $mutters = $user->mutters()->orderBy('created_at', 'desc')->get();
        // いいねしたつぶやき取得
        $likes_mutter = $user->likes($user->id)->get();
        // グループ取得
        $groups = $user->joining_group($user->id)->get();
        return view('users.show', compact(['user', 'followings', 'followers', 'mutters', 'likes_mutter', 'groups']));
    }

    public function edit($id){
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            ]);
            
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->description = $request->description;
        
        $user->save();
        return redirect()->route('users.show', ['id' => $id]);
    }


}
