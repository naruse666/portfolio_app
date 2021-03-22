<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mutter;

class MuttersController extends Controller
{
    public function index(){
        $user = Auth::user();
        $mutters = Mutter::orderBy('created_at', 'desc')->get();
        
        $count = count($mutters);
        return view('mutters.index', compact(['user', 'mutters', 'count']));
    }

    public function store(Request $request){
        $request->validate([
            'mutter' => 'required|string|max:255'
        ]);
        
        $request->user()->mutters()->create([
            'mutter' => $request->mutter,
        ]);
        return back();
    }

    public function edit($id){
        $mutter = Mutter::findOrFail($id);
        return view('mutters.edit', compact('mutter'));
    }

    public function update(Request $request, $id){
        $mutter = Mutter::findOrFail($id);
        $request->validate([
            'mutter' => 'required|max:255'
        ]);
        $mutter->mutter = $request->mutter;
        $mutter->save();
        return redirect()->route('mutters.index');
    }

    public function delete($id){
        $mutter = Mutter::findOrFail($id);
        $mutter->delete();
        return back();
    }

    public function like_mutter($id){
        $mutter = Mutter::findOrFail($id);
        $uid = Auth::id();
        $mutter->like($uid);
        return back();
    }

    public function unlike_mutter($id){
        $mutter = Mutter::findOrFail($id);
        $uid = Auth::id();
        $mutter->unlike($uid);
        return back();
    }
    
}
