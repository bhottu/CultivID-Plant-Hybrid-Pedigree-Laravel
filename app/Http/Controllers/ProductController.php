<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(3);
        $categories = Category::all();
        $discountedProducts = Product::where('discount', '>', 0)->latest()->take(4)->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);

        return view('products.index', compact('products', 'categories', 'posts', 'discountedProducts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function allproducts()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(9);
        return view('products.allproducts', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,flv|max:10240',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $product->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $product->image_path = $request->file('image')->store('images', 'public');
        }

        if ($request->hasFile('video')) {
            $product->video_path = $request->file('video')->store('videos', 'public');
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }


    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function loadMoreProducts(Request $request)
    {
        $page = $request->input('page', 1);
        $products = Product::with('category')->latest()->paginate(9, ['*'], 'page', $page);

        $html = view('products.load_more', compact('products'))->render();

        return response()->json([
            'html' => $html,
            'nextPageUrl' => $products->nextPageUrl()
        ]);
    }

    // Load More Discount

    public function discountedProducts()
    {
        $discountedProducts = Product::where('discount', '>', 0)->latest()->paginate(9);
        return view('products.discounted-products', compact('discountedProducts'));
    }


    public function loadMoreDiscountedProducts(Request $request)
    {
        $page = $request->input('page', 1);
        
        $discountedProducts = Product::where('discount', '>', 0)
            ->with('category')
            ->latest()
            ->paginate(9, ['*'], 'page', $page);
    
        $html = view('partials.discounted-products', compact('discountedProducts'))->render();
    
        return response()->json([
            'html' => $html,
            'nextPageUrl' => $discountedProducts->nextPageUrl()
        ]);
    }
    
    
    public function loadProducts(Request $request, $userId)
    {
        \Log::info('Request AJAX: ' . $request->ajax()); 
    
        if ($request->ajax()) {
            $user = User::findOrFail($userId);
            $products = $user->products()->paginate(8);
            $view = view('partials.products', ['products' => $products])->render();
            return response()->json([
                'html' => $view,
                'nextPageUrl' => $products->nextPageUrl()
            ]);
        }
    
        return response()->json(['error' => 'Non-AJAX request'], 400);
    }
    
    public function destroy(Product $id)
    {
    
        $id->delete();

        return redirect()->route('profile', auth()->user());
    }
    
    public function edit(Product $product)
    {
        $categories = Category::all(); 
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'discount' => 'nullable|numeric',
        'category_id' => 'required|exists:categories,id',
        'image_path' => 'nullable|image|max:2048',
        'video_path' => 'nullable|mimes:mp4,avi,mov|max:20000',
    ]);

    $price = str_replace('.', '', $request->input('price'));
    $discount = str_replace('.', '', $request->input('discount'));

    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price = $price;
    $product->discount = $discount ?: null;
    $product->category_id = $request->input('category_id');

    if ($request->hasFile('image_path')) {
        if ($product->image_path && Storage::exists($product->image_path)) {
            Storage::delete($product->image_path);
        }

        $product->image_path = $request->file('image_path')->store('images', 'public');
    }

    if ($request->hasFile('video_path')) {
        if ($product->video_path && Storage::exists($product->video_path)) {
            Storage::delete($product->video_path);
        }

        $product->video_path = $request->file('video_path')->store('videos', 'public');
    }

    $product->save();

    return redirect()->route('products.edit', $product)->with(
        'success', 'Product updated successfully.');
    
}



    // admin

    public function adminIndex()
    {
        $products = Product::with('category')->latest()->paginate(10); // Sesuaikan pagination sesuai kebutuhan Anda
        return view('admin.items.index', compact('products'));
    }

    public function adminShow(Product $product)
    {
        return view('admin.items.show', compact('product'));
    }

    public function adminDestroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        if ($product->video_path) {
            Storage::disk('public')->delete($product->video_path);
        }
        $product->delete();

        return redirect()->route('admin.items.index')->with('success', 'Product deleted successfully.');
    }

  

}
