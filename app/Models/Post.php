<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Searchable;
    use HasFactory;

    protected $fillable = [
        'title','body','user_id'
    ];

    // exact name from SCout Provider
    public function toSearchableArray() {

        // search the title and body from DB
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    public function user(){
        // from Post model get the class from the User Model. Lookup column id to id of user
        return $this->belongsTo(User::class, 'user_id');
    }
}
