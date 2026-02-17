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
            'image' => 'required|image|max:5120', // Maksimal 5MB sebelum dikompres
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // 1. Buat nama file unik
            $filename = time() . '_' . uniqid() . '.jpg';
            
            // 2. Tentukan folder tujuan (Folder: public/storage/uploads)
            $destinationPath = public_path('storage/uploads');

            // 3. Pastikan folder 'uploads' sudah ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // 4. Proses Kompresi
            // Resize lebar ke 1080px (standar sosial media), kualitas 75%
            $imageResized = \Image::make($file)->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75);

            // 5. Simpan file fisik
            $imageResized->save($destinationPath . '/' . $filename);

            // 6. Path untuk disimpan di Database
            $imagePath = 'uploads/' . $filename;
        }

        // Buat postingan dengan path gambar yang sudah dikompres
        $post = Auth::user()->posts()->create([
            'image' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('posts.by.username', Auth::user()->username)
                        ->with('success', 'Your post is now live — thanks for sharing!');
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
            'image' => 'nullable|image|max:5120', // Izinkan hingga 5MB sebelum dikompres
        ]);

        if ($request->hasFile('image')) {
            // 1. Hapus Gambar Lama dari Storage
            if ($post->image && \Storage::disk('public')->exists($post->image)) {
                \Storage::disk('public')->delete($post->image);
            }

            // 2. Proses Gambar Baru
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.jpg';
            $destinationPath = public_path('storage/uploads');

            // Pastikan folder ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // 3. Kompresi (Sama dengan fungsi Store)
            $imageResized = \Image::make($file)->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75);

            // 4. Simpan ke Fisik & Update Path di Database
            $imageResized->save($destinationPath . '/' . $filename);
            $post->image = 'uploads/' . $filename;
        }

        // Update Caption
        $post->caption = $request->caption;
        $post->save();

        return redirect()->route('posts.by.username', Auth::user()->username)
                        ->with('status', 'Post updated successfully!');
    }
    // End edit update

    // Delete post
    public function destroy(Post $post)
    {
    
        $post->delete();

        return redirect()->route('posts.by.username', auth()->user()->username)
                 ->with('delete', 'Post deleted successfully!');
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