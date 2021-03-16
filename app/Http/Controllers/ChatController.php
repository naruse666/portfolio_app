<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;

class ChatController extends Controller
{
    public function store(Request $request, $id){
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $request->user()->chats()->create([
            'content' => $request->content,
            'group_id' => $id,
        ]);
        return back();
    }

    public function delete($id){
        Chat::findOrFail($id)->delete();

        return back();
    }
}
