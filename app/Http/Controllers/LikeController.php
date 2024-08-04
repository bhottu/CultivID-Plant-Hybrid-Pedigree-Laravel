<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function addLike($postId)
    {
        $post = Post::findOrFail($postId);

        if ($post->likes()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'You have already liked this post.');
        }

        $like = new Like();
        $like->user_id = Auth::id();
        $post->likes()->save($like);

        return redirect()->back()->with('success', 'Post liked successfully.');
    }
}
