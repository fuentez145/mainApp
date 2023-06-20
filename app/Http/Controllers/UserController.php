<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use SebastianBergmann\CodeUnit\FunctionUnit;

class UserController extends Controller
{


    public function showCorrectHomepage(){
        if (auth()-> check()){
            // auth-usermodel-usermodelfunction-filter          | change the (->get) to (->paginate(5)) to paginate the posts
            return view('homepage-feed', ['posts' => auth()->user()->feedPosts()->latest()->paginate(4)]);
        }else{
            return view('homepage');
        }
    }

    public function login(Request $request){
        $incomingFields = $request->validate([
            'loginusername' =>  ['required'],
            'loginpassword' => ['required','min:8'],
           
        ]);
        // attemp to login usin auth(); array of [tablename => name from Request Form array]
        if(auth()->attempt(['username'=> $incomingFields['loginusername'], 'password'=> $incomingFields['loginpassword']])){
            $request->session()->regenerate();
            return  redirect('/')->with('success', 'Logged in successfully');
        }else{
            return  redirect('/')->with('failure', 'Invalid credentials');
        }

    }

    

    //
    public function register(Request $request){
        $incomingFields = $request->validate([
            'username' => 'required|min:3|max:20|'. Rule::unique('users', 'username'),
            'email' =>  ['required','email',Rule::unique('users', 'email')],
            'password' => ['required','min:8','confirmed'],
           
        ]);
        $user = User::create($incomingFields);
        auth()->login($user); // login the user with the given credentials to automatically login after register
        return redirect('/')->with('success', 'Account successfully created.');
    }

    public function logout(){
        auth()->logout();
        return redirect('/')->with('success', 'Logged out successfully');
    }


    private function getSharedData($user){
        $currentlyFollowing = 0;

        if(auth()->check()){
            $currentlyFollowing = Follow::where([['user_id', '=' , auth()->user()->id],
            ['followeduser', '=' , $user->id]])->count();
        }

        // FROM User get the Post Model from the User Model;
        // $thePosts = $user->posts()->get(); //return json
        View::share('sharedData', ['username' => $user->username,
        'postCount' => $user->posts()->count(), // count the number of posts
        'avatar' => $user->avatar,
        'currentlyFollowing' => $currentlyFollowing,  
        'followerCount' => $user->followers()->count(),
        'followingCount' => $user->followingTheseUsers()->count(),
    ]);

    }

    // get the username from the url and pass it to the view
    public function profile(User $user){
        $this->getSharedData($user); //pass the user to the function to get the shared data
        return view('profile-posts', ['posts' => $user->posts()->latest()->get()]);
    }


    public function profileFollowers(User $user){
        $this->getSharedData($user);
        // return $user->followers()->latest()->get();
        return view('profile-followers', ['followers' => $user->followers()->latest()->get()]);
    }


    public function profileFollowing(User $user){
        $this->getSharedData($user);
        //fro the Model User get the function of followingTheseUsers
        return view('profile-following', ['following' => $user->followingTheseUsers()->latest()->get()]);}


    public function showAvatarForm(){
        return view('avatar-form');
    }
   
    public function storeAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|image|max:3000',

        ]);
        $user = auth()->user();
        $filename = $user->id . '-' . uniqid();

        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        Storage::put('public/avatars/'.$filename.'.jpg', $imgData);
        
        // check DB for old avatar and delete it

        $oldAvatar = $user->avatar;

        // save to DB  
       
        
        $user->avatar = $filename .'.jpg';
        $user->save();

        //detele old avatar
        if($oldAvatar != 'default.jpg'){
            Storage::delete(str_replace('/storage/', 'public/', $oldAvatar));
        }

        return back()->with('success', 'Avatar updated successfully');
    }
}
