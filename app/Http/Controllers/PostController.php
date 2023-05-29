<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function storePost(PostRequest $postRequest): RedirectResponse
    {
        Post::create([
            "user_id" => $postRequest->user()->id,
            "title" => $postRequest->input("title"),
            "body" => $postRequest->input("message")
        ]);

        return back();
    }
}