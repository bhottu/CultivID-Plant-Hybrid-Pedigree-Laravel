<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Post;
use App\Models\Share;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari Produk
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        // Cari Pengguna
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        // Cari Postingan berdasarkan caption
        $posts = Post::where('caption', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results', compact('products', 'users', 'posts', 'query'));
    }
}
