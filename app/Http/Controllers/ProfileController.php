<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Post;
use App\Models\Share;
use App\Models\Currency;
use App\Models\PlantSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::paginate(9);

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
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(9);
        $shares = $user->shares()->orderBy('created_at', 'desc')->get();
        $products = $user->products()->paginate(9);
        
        // Show approved plant submissions to all users
        $plantSubmissions = $user->plantSubmissions()
            ->where('status_review', 'approved')
            ->whereNotNull('induk_betina')
            ->whereNotNull('induk_jantan')
            ->where('induk_betina', '!=', '')
            ->where('induk_jantan', '!=', '')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        if (request()->header('HX-Request')) {
            return view('partials.profile-content', compact('user', 'shares', 'posts', 'products', 'plantSubmissions'));
        }

        return view('profile.show', compact('user', 'shares', 'posts', 'products', 'plantSubmissions'));
    }

    public function loadMorePlants(User $user)
    {
        $plantSubmissions = $user->plantSubmissions()
            ->where('status_review', 'approved')
            ->whereNotNull('induk_betina')
            ->whereNotNull('induk_jantan')
            ->where('induk_betina', '!=', '')
            ->where('induk_jantan', '!=', '')
            ->orderBy('created_at', 'desc')
            ->paginate(9); // Sesuaikan jumlahnya dengan show()

        // Kembalikan JSON agar dibaca oleh fetch() di JavaScript
        return response()->json([
            'html' => view('partials.plant_submissions', compact('plantSubmissions'))->render(),
            'hasMorePages' => $plantSubmissions->hasMorePages()
        ]);
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
            $image = $request->file('profile_photo');
            $filename = time() . '_' . uniqid() . '.webp';
            $profilePhotoPath = 'profile-photos/' . $filename;

            $imageResized = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 75);

            Storage::disk('public')->put($profilePhotoPath, $imageResized);
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

        $buttonHtml = '<button id="follow-button" hx-post="' . route('profile.unfollow', $user) . '" hx-target="#follow-button" hx-swap="outerHTML" hx-vals=\'{"_token": "' . csrf_token() . '"}\' class="w-full font-bold py-3 rounded-lg transition mb-6 text-white bg-red-500 hover:bg-red-600">Unfollow</button>';
        $followersHtml = '<div id="followers-count" hx-swap-oob="innerHTML"><i class="fas fa-users text-blue-500"></i> ' . $user->followers()->count() . ' Followers</div>';

        return $buttonHtml . $followersHtml;
    }

    public function unfollow(Request $request, User $user)
    {
        $request->user()->following()->detach($user->id);

        $buttonHtml = '<button id="follow-button" hx-post="' . route('profile.follow', $user) . '" hx-target="#follow-button" hx-swap="outerHTML" hx-vals=\'{"_token": "' . csrf_token() . '"}\' class="w-full font-bold py-3 rounded-lg transition mb-6 text-white bg-green-500 hover:bg-green-600">Follow</button>';
        $followersHtml = '<div id="followers-count" hx-swap-oob="innerHTML"><i class="fas fa-users text-blue-500"></i> ' . $user->followers()->count() . ' Followers</div>';

        return $buttonHtml . $followersHtml;
    }

    public function loadMore(Request $request, User $user)
    {
        try {
            $posts = $user->posts()->orderBy('created_at', 'desc')
                         ->paginate(9, ['*'], 'page', $request->page);

            if ($request->ajax()) {
                $view = view('partials.posts', compact('posts'))->render();
                return response()->json(['html' => $view, 'nextPageUrl' => $posts->nextPageUrl()]);
            }

            return back();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function loadMorePlantSubmissions(Request $request, User $user)
    {
        try {
            $plantSubmissions = $user->plantSubmissions()
                             ->where('status_review', 'approved')
                             ->whereNotNull('induk_betina')
                             ->whereNotNull('induk_jantan')
                             ->where('induk_betina', '!=', '')
                             ->where('induk_jantan', '!=', '')
                             ->orderBy('created_at', 'desc')
                             ->paginate(9, ['*'], 'page', $request->page);

            if ($request->ajax()) {
                $view = view('partials.plant_submissions', compact('plantSubmissions'))->render();
                return response()->json(['html' => $view, 'nextPageUrl' => $plantSubmissions->nextPageUrl()]);
            }

            return back();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
