<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // group function
    
    public function groups(){
        return $this->hasMany(Group::class, 'created_by');
    }
    
    public function users_group(){
        return $this->belongsToMany(Group::class, 'group_users', 'user_id', 'group_id');
    }

    public function joining_group($id){
        $ids =  $this->users_group()->select('group_id')->where([['user_id', '=', $id]]);

        return Group::whereIn('id', $ids);
    }

    // mutter function
    public function mutters(){
        return $this->hasMany(Mutter::class);
    }

    //chat function
    public function chats(){
        return $this->hasMany(Chat::class);
    } 

    // follow function
    public function followings(){
        return $this->belongsToMany(User::class,'follow_user', 'user_id', 'follow_id')->withTimestamps();
    }
    
    public function followers(){
        return $this->belongsToMany(User::class, 'follow_user', 'follow_id', 'user_id')->withTimestamps();
    }


    
    public function follow($uid){
        $my_id = $this->id == $uid;
        $allready = $this->following($uid);
        if($my_id || $allready){
            return false;
        } else{
            $this->followings()->attach($uid);
            return true;
        }
    }
    
    public function unfollow($uid){
        $my_id = $this->id == $uid;
        $allready = $this->following($uid);
        if(!$my_id && $allready){
            $this->followings()->detach($uid);
            return true;
        }else {
            return false;
        }
    }
    
    public function following($uid){
        return $this->followings()->where('follow_id', $uid)->exists();
    }
    
    public function following_users(){
        $user_ids =  $this->followings()->pluck('users.id')->toArray();
        $user_ids [] = $this->id;
        return Mutter::whereIn('user_id', $user_ids);
    }
    
    public function both_following($id, $opid){
        if($this->followers()->where([
            ['follow_id', '=', $id],
            ['user_id', '=', $opid]
            ])->exists() && $this->followings()->where([
                ['user_id', '=', $id],
                ['follow_id', '=', $opid]
                ])->exists()){
                    return true;
                } else {
                    return false;
                }
            }
            
    // like function
    public function like_to_mutter(){
        return $this->belongsToMany(Mutter::class, 'like_mutter', 'like_user_id', 'like_mutter_id');
    }

    public function likes($id){
        $ids = $this->like_to_mutter()->select('like_mutter_id')->where([['like_user_id', '=',  $id]]);
        return Mutter::whereIn('id', $ids);
    }

}
