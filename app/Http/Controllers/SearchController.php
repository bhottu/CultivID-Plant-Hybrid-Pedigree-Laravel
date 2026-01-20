<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Post;
use App\Models\Share;
use App\Models\PlantSubmission;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(10);

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->paginate(10);

        $posts = Post::where('caption', 'LIKE', "%{$query}%")
            ->paginate(10);

        $plantSubmissions = PlantSubmission::where('plant_id', 'LIKE', "%{$query}%")
            ->orWhere('induk_jantan', 'LIKE', "%{$query}%")
            ->orWhere('induk_betina', 'LIKE', "%{$query}%")
            ->orWhere('penyilang', 'LIKE', "%{$query}%")
            ->orWhere('keterangan', 'LIKE', "%{$query}%")
            ->paginate(10);

        if (request()->header('HX-Request')) {
            return view('partials.search-results', compact('products', 'users', 'posts', 'plantSubmissions', 'query'));
        }

        return view('search.results', compact('products', 'users', 'posts', 'plantSubmissions', 'query'));
    }
}
