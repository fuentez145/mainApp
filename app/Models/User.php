<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    // filter the avatar attribute to return the path to the image
    protected function getAvatarAttribute($value)
    {
        return $value ? '/storage/avatars/' . $value : '/default.jpg';
    }

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function feedPosts() {
            // model we wanna end up with | User they followed | m1,m2,m1fk,m2fk,local_id,intermediate_id(u want to get/fk)
            return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser');
    }

    public function followers(){
        // a user has many follows
        //a.b = b is a foreign key powering ;
        //for short, in the User, get the data with the foreign key 'followeduser' from the Follows table
        return $this->hasMany(Follow::class, 'followeduser');
    }
    
    public function followingTheseUsers(){

        return $this->hasMany(Follow::class, 'user_id');
    }

    public function posts(){
        //relationship in the Datbase model, to  POST 'user_id' which is powering the relationship
        // relation between the user and the post
        return $this->hasMany(Post::class, 'user_id');
    }
}
