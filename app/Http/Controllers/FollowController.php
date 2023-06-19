<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    //

    public function createFollow(User $user){
        //you cannot follow yourself
      
        if($user->id == auth()->user()->id){
            return back()->with('failure', 'You cannot follow yourself');
        }

        //you cannot follow already follow | check if the user is already followed \ SQL Statement
        $existCheck = Follow::where([['user_id', '=' , auth()->user()->id],
        ['followeduser', '=' , $user->id]])->count();

        if($existCheck){
            return back()->with('failure', 'You are already following this user');
        }

        $newFollow = new Follow();
        $newFollow->user_id = auth()->user()->id;
        // based on the table name in the follows table,, 
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'You are now following this user');
    }


    public function removeFollow(User $user){
        // return view('follows');
        Follow::where([['user_id','=', auth()->user()->id ], ['followeduser','=', $user->id]])->delete();

        return back()->with('success', 'You have unfollowed this user');

    }
}
