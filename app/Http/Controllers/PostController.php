<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Share;
use App\Models\User;

class PostController extends Controller
{

    public function show($id)
    {
        $post = Post::with('likes')->findOrFail($id);
        // Load comments with newest first
        $post->load(['comments' => function ($query) {
            $query->with('user')->orderBy('created_at', 'desc');
        }]);
        return view('post.show', compact('post'));
    }
    public function create()
    {
        $users = User::all();
        return view('post.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'caption' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        $post = Auth::user()->posts()->create([
            'image' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('profile', Auth::user());
    }

    public function addComment(Request $request, Post $post)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Please login first.',
                ], 401);
            }

            $request->validate([
                'content' => 'required|string|max:255',
            ]);

            $comment = new Comment();
            $comment->content = $request->input('content');
            $comment->user_id = auth()->user()->id;
            $comment->post_id = $post->id;
            $comment->save();

            // Load user relationship
            $comment->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully.',
                'comment' => [
                    'content' => $comment->content,
                    'user_id' => $comment->user->id,
                    'user_username' => $comment->user->username,
                    'user_name' => $comment->user->name,
                    'created_at' => $comment->created_at->diffForHumans()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

 

    public function addShare(Request $request, $id)
        {
            if ($request->header('HX-Request')) {
                Share::create([
                    'user_id' => auth()->id(),
                    'post_id' => $id
                ]);

                $post = Post::findOrFail($id);
                $sharesCount = $post->shares()->count();

                return response()->json([
                    'success' => true,
                    'shares_count' => $sharesCount,
                    'message' => 'Post shared successfully.'
                ]);
            }

            Share::create([
                'user_id' => auth()->id(),
                'post_id' => $id
            ]);

            return redirect()->back()->with('success', 'Post shared successfully');
        }


   // Edit - Update
   public function edit(Post $post)
    {
        $users = User::all();
        return view('post.edit', compact('post', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('images', 'public');
        }

        $post->caption = $request->caption;
        $post->save();

        return redirect()->route('profile', Auth::user())->with('status', 'Post updated successfully!');
    }
    // End edit update

    // Delete post
    public function destroy(Post $post)
    {
    
        $post->delete();

        return redirect()->route('profile', auth()->user());
    }
    // End Delete post

    // Delete shared
    public function sharedestroy($id)
        {
            $share = Share::find($id);

            if ($share && $share->user_id === auth()->user()->id) {
                $share->delete();
                return redirect()->back()->with('success', 'Post removed from your profile.');
            } else {
                return redirect()->back()->with('error', 'You do not have permission to delete this post.');
            }
        }
     // End Delete shared

     public function fetchComments($postId)
        {
            $post = Post::findOrFail($postId);
            $comments = $post->comments()->with('user')->get();
            return response()->json($comments);
        }

    // Admin posts
    public function discuss()
        {
            $posts = Post::with('user')->paginate(10);

            return view('admin.discuss', ['posts' => $posts]);
        }

    // Admin posts delete
    public function admindestroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
    
        return redirect()->route('admin.discuss')->with('success', 'Post deleted successfully');
    }
 

}