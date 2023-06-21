<?php

use App\Events\ChatMessage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate; // Add this line

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use Illuminate\Http\Request;

// use GuzzleHttp\Psr7\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admins-only', function () {
    // return 'only admin can only view this page';
    // if(Gate::allows('visitAdminPages')){ //from the Providers/AuthServiceProvider.php
    //     return 'You are admin';
    // }else
    // {
    //     return 'only admin can only view this page';
    // }
        return 'only admin can only view this page';
})->middleware('can:visitAdminPages'); // from the Providers/AuthServiceProvider.php

// User Related Routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('auth');
route::get('/manage-avatar', [UserController::class, "showAvatarForm"])->middleware('auth');
route::post('/manage-avatar', [UserController::class, "storeAvatar"])->middleware('auth');


// Follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, "createFollow"])->middleware('auth');
Route::post('/remove-follow/{user:username}', [FollowController::class, "removeFollow"])->middleware('auth');
// Route::get('/unfollow', [UserController::class, "unfollow"])->middleware('auth');

// Blog post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('auth');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'updatePost'])->middleware('can:update,post');
Route::get('/search/{term}',[PostController::class, 'search']);

// Profile Relates Routes / lookup based on the username, by default is id
Route::get('/profile/{user:username}', [UserController::class, 'profile'] );
Route::get('/profile/{user:username}/followers', [UserController::class, 'profileFollowers'] );
Route::get('/profile/{user:username}/following', [UserController::class, 'profileFollowing'] );


// CHat Route
Route::post('/send-chat-message', function (Request $request){
    $formFields = $request->validate([
        'textvalue' => 'required'
    ]);


    if(!trim(strip_tags($formFields['textvalue']))){
        return response()->noContent();
    }

    broadcast(new ChatMessage([
        'username' => auth()->user()->username,
        'avatar' => auth()->user()->avatar,
        'textvalue' => strip_tags($formFields['textvalue']),
    ]))->toOthers();

    return response()->noContent();
});



