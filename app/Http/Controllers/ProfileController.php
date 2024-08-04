<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Post;
use App\Models\Share;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return view('admin.users', ['users' => $users]);
    }

    public function adminDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User has been deactivated.');
    }

    

    public function adminShowUsers($id)
    {
        $user = User::findOrFail($id);
        $totalPosts = $user->posts()->count();
        $totalProducts = $user->products()->count();

        return view('admin.user_detail', compact('user', 'totalPosts', 'totalProducts'));
    }

    public function adminDashboardStatistic()
    {
        $totalUsers = User::count(); 
        $totalPosts = Post::count();
        $totalProducts = Product::count();
        $latestUsers = User::latest()->take(5)->get();
        $latestProducts = Product::latest()->take(5)->get();
    
        return view('admin.home', [
            'totalUsers' => $totalUsers, 
            'totalPosts' => $totalPosts, 
            'totalProducts' => $totalProducts,
            'latestUsers' => $latestUsers,
            'latestProducts' => $latestProducts,
        ]);
       
    }

    public function show(User $user)
    {
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(3);
        $shares = $user->shares()->orderBy('created_at', 'desc')->get();
        $products = $user->products()->paginate(6);
        

        return view('profile.show', compact('user', 'shares', 'posts', 'products'));
    }

    public function edit()
    {
        $user = auth()->user();
        $currencies = Currency::all();
        return view('profile.edit', compact('user', 'currencies'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'currency' => 'nullable|string|max:3',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->latitude = $request->input('latitude');
        $user->longitude = $request->input('longitude');
        $user->currency = $request->input('currency'); 

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('profile_photo')) {
            $currentPhoto = $user->profile_photo_path;

            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $profilePhotoPath;

            if ($currentPhoto) {
                Storage::disk('public')->delete($currentPhoto);
            }
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }


    public function follow(Request $request, User $user)
    {
        $request->user()->following()->attach($user->id);

        return response()->json([
            'status' => 'followed',
            'followers_count' => $user->followers()->count()
        ]);
    }

    public function unfollow(Request $request, User $user)
    {
        $request->user()->following()->detach($user->id);

        return response()->json([
            'status' => 'unfollowed',
            'followers_count' => $user->followers()->count()
        ]);
    }

    public function loadMore(Request $request, User $user)
    {
        try {
            $posts = $user->posts()->orderBy('created_at', 'desc')
                         ->paginate(5, ['*'], 'page', $request->page);
    
            if ($request->ajax()) {
                $view = view('partials.posts', compact('posts'))->render();
                return response()->json(['html' => $view, 'nextPageUrl' => $posts->nextPageUrl()]);
            }
    
            return back();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
