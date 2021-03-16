<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(){
        $groups = Group::orderBy('created_at', 'desc')->get();
        return view('groups.index', compact('groups'));
    }

    public function show($id){
        $group = Group::findOrFail($id);

        return view('groups.show', compact('group'));
    }

    public function talk($id){
        $group = Group::findOrFail($id);
        $chats = $group->get_chats($id)->orderBy('created_at', 'desc')->get();
        return view('groups.talk', compact(['group', 'chats']));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $request->user()->groups()->create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ])->group_users()->attach(Auth::id());

        return redirect()->route('groups.index');
    }

    public function edit($id){
        $group = Group::findOrFail($id);
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, $id){
        $group = Group::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();
        return back();
    }

    public function delete($id){
        Group::findOrFail($id)->delete();
        return redirect()->route('groups.index');
    }

    public function join($id, $gid){
        Group::findOrFail($gid)->join_group($id, $gid);
        return back();
    }
 
    public function exit($id, $gid){
        Group::findOrFail($gid)->exit_group($id, $gid);
        return back();
    }
}
