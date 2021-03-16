<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutter extends Model
{
    protected $fillable = ['mutter'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    // like function 
    public function like_from_user(){
        return $this->belongsToMany(User::class, 'like_mutter', 'like_mutter_id', 'like_user_id');
    }

    public function like($uid){
        $already = $this->liked($uid);
        if($already == true){
            return false;
        } else {
            $this->like_from_user()->attach($uid);
            return true ;
        }
    }

    public function unlike($uid){
        $already = $this->liked($uid);
        if($already == true){
            $this->like_from_user()->detach($uid);
            return true;
        } else {
            return false;
        }

    }

    public function liked($uid){
        return $this->like_from_user()->where('like_user_id', $uid)->exists();
    }
}
