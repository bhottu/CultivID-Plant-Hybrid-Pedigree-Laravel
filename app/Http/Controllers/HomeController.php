<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; 
use App\Models\Comment;
use App\Models\Like;
use App\Models\Share;
use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes'])->withCount(['likes', 'comments'])->orderBy('created_at', 'desc')->paginate(10);

        if (request()->header('HX-Request')) {
            return view('partials.posts-list', ['posts' => $posts]);
        }

        return view('home', ['posts' => $posts]);
    }
    
    public function anyOtherMethod()
    {
        $user = Auth::user(); 
        return view('any-view', compact('user'));
    }

    public function addComment(Request $request, Post $post) 
    {
        $request->validate([
        'content' => 'required',
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id;
        $post->comments()->save($comment);

        return redirect()->back();
    }

    public function addLike(Post $post)
    {
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $post->likes()->save($like);

        return redirect()->back();
    }

    public function addShare(Post $post)
    {
        $share = new Share();
        $share->user_id = auth()->user()->id;
        $post->shares()->save($share);

        return redirect()->back();
    }

// Load more profil
public function loadMore(Request $request)
{
    try {
        $posts = Post::with(['user'])->orderBy('created_at', 'desc')
                     ->paginate(5, ['*'], 'page', $request->page);

        if ($request->ajax()) {
            $view = view('partials.posts', compact('posts'))->render();
            return response()->json(['html' => $view, 'hasMorePages' => $posts->hasMorePages()]);
        }

        return back();
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}
