<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class PostController extends Controller
{
    //

    public function updatePost(Post $post, Request $request){
      $incomingFields = $request->validate([
        'title' => 'required',
        'body' => 'required'
      ]);
      $incomingFields['title'] = strip_tags($incomingFields['title']);
      $incomingFields['body'] = strip_tags($incomingFields['body']);

      $post->update($incomingFields);

      return back()->with('success', 'Post updated successfully');

    }

    public function showEditForm(Post $post){
        return view('edit-post', ['post' => $post]);
    }

    public function delete(Post $post){
     
        $post->delete();
        return Redirect('/profile/'.auth()->user()->username)->with('success', 'Post deleted successfully');
    }

    public function viewSinglePost(Post $post){

        //Str use static method that belong to a class
       //overwriting the body with markdown / use strip_tags to allow certain tags eg. strip_tags(value, allowed tags(<h1><p1>etc...))
        $post['body'] = Str::markdown($post->body);
        return view('single-post',['post' => $post]);
      
    }


    //
    public function showCreateForm(){
        return view('create-post');
    }

    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            // 'tags' => $request->tags,
            // 'user_id' => $request->user_id
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->user()->id;
        
        // model validation
        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'Post created successfully');
    }

   
}
