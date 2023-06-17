<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','body','user_id'
    ];

    public function user(){
        // from Post model get the class from the User Model. Lookup column id to id of user
        return $this->belongsTo(User::class, 'user_id');
    }
}
