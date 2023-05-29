<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function storePost(PostRequest $postRequest): RedirectResponse
    {
        Post::create([
            "user_id" => $postRequest->user()->id,
            "title" => $postRequest->input("title"),
            "message" => $postRequest->input("message")
        ]);

        return back();
    }

    public function likePost(Post $post): RedirectResponse
    {
        if ($this->checkPostLikes($post) === false) {
            Like::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id
            ]);

            return back();
        }

        $like = $post->likes->filter(function (object $like, int $key) {
            return $like->user_id === auth()->user()->id;
        });

        $like->first()->delete();
        return back();
    }

    public function checkPostLikes($post)
    {
        return $post->likes->contains(function (object $like, int $key) {
            return $like->user_id === auth()->user()->id;
        });
    }
}