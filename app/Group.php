<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Group extends Model
{

    protected $fillable = ['name', 'description', 'created_by'];

    public function user(){
        return $this->belongsTo(User::class, 'id');
    }

    public function group_users(){
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id');
    }

    // join 
    public function join_group($id, $gid){

        if($this->joining($id, $gid) == true){
            return false;
        } else {
            $this->group_users()->attach($id);
            return true;
        }
    }
    // exit 
    public function exit_group($id, $gid){
        if($this->joining($id, $gid) == true){
            $this->group_users()->detach($id);
            return true;
        } else {
            return false;
        }
    }

    public function joining($id, $gid){
        return $this->group_users()->where([
            ['user_id', '=', $id],
            ['group_id', '=', $gid]
            ])->exists();
    }
    // number of people for group
    public function number_of_people(){
        return $this->group_users()->pluck('group_users.group_id')->toArray();
    }

    public function chats(){
        return $this->hasMany(Chat::class);
    }

    public function get_chats($id){
        return $this->chats()->where('group_id', '=', $id);
    }
}
