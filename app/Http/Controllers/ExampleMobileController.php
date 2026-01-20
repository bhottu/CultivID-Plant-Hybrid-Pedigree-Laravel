<?php

namespace App\Http\Controllers;

use App\Services\SPAResponseService;
use App\Models\Post;
use Illuminate\Http\Request;

/**
 * Example Controller showing SPA Navigation
 * 
 * This controller demonstrates how to use SPAResponseService
 * for smooth, AJAX-based page transitions
 */
class ExampleMobileController extends Controller
{
    /**
     * Home page with posts feed
     * 
     * Returns full page on initial load,
     * returns only content for SPA navigation
     */
    public function home()
    {
        $posts = Post::with('user', 'images')
            ->latest()
            ->paginate(10);

        return SPAResponseService::render('mobile.home', [
            'posts' => $posts,
        ]);
    }

    /**
     * Search/Explore page
     */
    public function search()
    {
        // You can add filtering logic here
        $query = request()->input('q', '');

        return SPAResponseService::render('mobile.search', [
            'query' => $query,
        ]);
    }

    /**
     * Messages page
     */
    public function messages()
    {
        $conversations = auth()->user()->conversations()
            ->with('latestMessage')
            ->latest('updated_at')
            ->paginate(10);

        return SPAResponseService::render('mobile.messages', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * Profile page
     */
    public function profile($userId)
    {
        $user = User::findOrFail($userId);
        $posts = $user->posts()
            ->with('images')
            ->latest()
            ->paginate(10);

        return SPAResponseService::render('mobile.profile', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    /**
     * Load more posts (partial content for infinite scroll)
     * 
     * Usage in blade:
     * <button onclick="loadMorePosts()">Load More</button>
     * 
     * JavaScript:
     * async function loadMorePosts() {
     *     const response = await fetch('/posts/load-more?page=2', {
     *         headers: { 'X-Requested-With': 'XMLHttpRequest' }
     *     });
     *     const html = await response.text();
     *     document.getElementById('posts').innerHTML += html;
     * }
     */
    public function loadMorePosts(Request $request)
    {
        $posts = Post::with('user', 'images')
            ->latest()
            ->paginate(10, ['*'], 'page', $request->input('page', 2));

        // Return only the posts HTML, not the full page
        return SPAResponseService::partial('components.post-feed', [
            'posts' => $posts,
        ]);
    }

    /**
     * Create post (AJAX endpoint)
     * 
     * Usage:
     * fetch('/posts/create', {
     *     method: 'POST',
     *     body: FormData,
     *     headers: { 'X-CSRF-TOKEN': token }
     * })
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $post = auth()->user()->posts()->create($validated);

        // Upload images if provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $post->images()->create([
                    'path' => $image->store('posts', 'public'),
                ]);
            }
        }

        if ($request->expectsJson() || SPAResponseService::isSPARequest()) {
            // Return JSON for API/AJAX
            return response()->json([
                'success' => true,
                'post' => $post->load('user', 'images'),
            ]);
        }

        // Redirect for traditional form submission
        return redirect()->route('home')->with('success', 'Post created!');
    }

    /**
     * Handle toggle like on post (AJAX)
     */
    public function toggleLike($postId)
    {
        $post = Post::findOrFail($postId);
        $user = auth()->user();

        if ($post->isLikedBy($user)) {
            $post->unlike($user);
            $liked = false;
        } else {
            $post->like($user);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
        ]);
    }

    /**
     * Example: Refresh specific content without full page reload
     * 
     * Usage: POST /refresh-feed
     */
    public function refreshFeed()
    {
        $posts = Post::with('user', 'images')
            ->latest()
            ->limit(5)
            ->get();

        // Return only post cards HTML
        $html = view('components.posts-list', ['posts' => $posts])->render();

        return response()->json([
            'html' => $html,
            'count' => $posts->count(),
        ]);
    }
}

/**
 * ROUTE EXAMPLES for routes/web.php:
 * 
 * Route::middleware(['auth'])->group(function () {
 *     Route::get('/home', [ExampleMobileController::class, 'home'])->name('home');
 *     Route::get('/search', [ExampleMobileController::class, 'search'])->name('search');
 *     Route::get('/messages', [ExampleMobileController::class, 'messages'])->name('messages');
 *     Route::get('/profile/{user}', [ExampleMobileController::class, 'profile'])->name('profile');
 * 
 *     Route::get('/posts/load-more', [ExampleMobileController::class, 'loadMorePosts'])->name('posts.load-more');
 *     Route::post('/posts/create', [ExampleMobileController::class, 'storePost'])->name('posts.store');
 *     Route::post('/posts/{post}/like', [ExampleMobileController::class, 'toggleLike'])->name('posts.like');
 *     Route::post('/feed/refresh', [ExampleMobileController::class, 'refreshFeed'])->name('feed.refresh');
 * });
 * 
 * Route::post('/api/dark-mode', function (Request $request) {
 *     session(['dark_mode' => $request->input('mode', 'light')]);
 *     return response()->json(['mode' => session('dark_mode')]);
 * });
 */
