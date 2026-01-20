<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function addLike($postId)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Please login first.',
                    'redirect' => route('login')
                ], 401);
            }

            $post = Post::findOrFail($postId);
            $userId = Auth::id();

            $existingLike = $post->likes()->where('user_id', $userId)->first();
            
            if ($existingLike) {
                // Unlike
                $existingLike->delete();
                $likesCount = $post->likes()->count();
                return response()->json([
                    'success' => true,
                    'liked' => false,
                    'likes_count' => $likesCount,
                    'message' => 'Post unliked successfully.'
                ], 200);
            }

            // Like
            $like = new Like();
            $like->user_id = $userId;
            $post->likes()->save($like);
            
            $likesCount = $post->likes()->count();
            return response()->json([
                'success' => true,
                'liked' => true,
                'likes_count' => $likesCount,
                'message' => 'Post liked successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
