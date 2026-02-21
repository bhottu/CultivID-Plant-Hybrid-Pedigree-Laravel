<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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

            if ($post->user_id != Auth::id()) {

                Notification::create([
                    'user_id' => $post->user_id,
                    'from_user_id' => Auth::id(),
                    'type' => 'post_liked',
                    'notifiable_id' => $post->id,
                    'notifiable_type' => 'Post',
                    'data' => [
                        'post_id' => $post->id,
                        'message' => Auth::user()->username . ' liked your post'
                    ]
                ]);
            }
            
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
