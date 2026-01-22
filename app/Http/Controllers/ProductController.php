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
//use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\PlantSubmission;
use App\Models\PlantSubmissionAppeal;


class ProductController extends Controller
{
    public function index()
    {
         
        $products = Product::with('category', 'user')->latest()->paginate(10);
        $categories = Category::all();
        $discountedProducts = Product::where('discount', '>', 0)->latest()->take(4)->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
       
        // Ambil tanaman hias yang sudah di-approve admin atau sedang banding
        $approvedPlants = \App\Models\PlantSubmission::with('uploader')
            ->whereIn('status_review', ['approved', 'banding'])
            ->latest()->paginate(10);

        if (request()->header('HX-Request')) {
            return view('partials.home-content', compact('products'));
        }

        // =========================
// BADGE COUNTS (AMAN UNTUK GUEST)
// =========================
$user = Auth::user(); // bisa null
$base = PlantSubmission::query();

// Jika user login & BUKAN admin → filter milik sendiri
if ($user && !$user->is_admin) {
    $base->where('uploader_id', $user->id);
}

// Jika guest → TIDAK boleh lihat data user
if (!$user) {
    $base->whereRaw('1 = 0'); // hasilkan 0 data
}

$counts = [
    'approved' => (clone $base)->where('status_review','approved')->count(),
    'pending'  => (clone $base)->where('status_review','pending')->count(),
    'rejected' => (clone $base)->where('status_review','rejected')->count(),
    'revision' => (clone $base)->where(function ($q) {
                        $q->whereNull('induk_jantan')
                          ->orWhere('induk_jantan','')
                          ->orWhereNull('induk_betina')
                          ->orWhere('induk_betina','');
                    })->count(),
    'appeal'   => $user
                    ? ($user->is_admin
                        ? PlantSubmissionAppeal::count()
                        : PlantSubmissionAppeal::where('user_id', $user->id)->count())
                    : 0,
];


        return view('products.index', compact('products', 'categories', 'posts', 'discountedProducts', 'approvedPlants','counts'));
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
        ], [
            'image.max' => 'The image field must not be greater than 2 MB.',
            'video.max' => 'The video field must not be greater than 10 MB.',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $product->user_id = auth()->id();
        $product->is_sold_out = false; 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageResized = Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75);
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $imageResized->save(public_path('storage/images/' . $filename));
            $product->image_path = 'images/' . $filename;
        }

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '.' . $video->getClientOriginalExtension();
            $path = $video->move(public_path('storage/videos'), $filename);
            $product->video_path = 'videos/' . $filename;
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
            'hasMorePages' => $products->hasMorePages()
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
    
    public function destroy($id)
    {
        // Temukan produk berdasarkan ID
        $product = Product::findOrFail($id);
    
        // Hapus file gambar jika ada
        if ($product->image_path && Storage::exists('public/' . $product->image_path)) {
            Storage::delete('public/' . $product->image_path);
        }
    
        // Hapus file video jika ada
        if ($product->video_path && Storage::exists('public/' . $product->video_path)) {
            Storage::delete('public/' . $product->video_path);
        }
    
        // Hapus produk dari database
        $product->delete();
    
        return redirect()->route('profile', auth()->user())->with('success', 'Product deleted successfully.');
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
            'video_path' => 'nullable|mimes:mp4,avi,mov|max:10240',
            
        ], [
            'image_path.max' => 'The image field must not be greater than 2 MB.',
            'video_path.max' => 'The video field must not be greater than 10 MB.',
        ]);

        $price = str_replace('.', '', $request->input('price'));
        $discount = str_replace('.', '', $request->input('discount'));

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $price;
        $product->discount = $discount ?: null;
        $product->category_id = $request->input('category_id');

        if ($request->hasFile('image_path')) {
            if ($product->image_path && Storage::exists('public/' . $product->image_path)) {
                Storage::delete('public/' . $product->image_path);
            }

            $image = $request->file('image_path');
            $imageResized = Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75);
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $imageResized->save(public_path('storage/images/' . $filename));
            $product->image_path = 'images/' . $filename;
        }

        if ($request->hasFile('video_path')) {
            if ($product->video_path && Storage::exists('public/' . $product->video_path)) {
                Storage::delete('public/' . $product->video_path);
            }
        
            $video = $request->file('video_path');
            $filename = time() . '.' . $video->getClientOriginalExtension();
            $path = $video->move(public_path('storage/videos'), $filename);
            $product->video_path = 'videos/' . $filename;
        }

        $product->save();

        return redirect()->route('products.edit', $product)->with(
            'success', 'Product updated successfully.');
    }

    public function toggleSoldOut(Product $product)
    {
        if (Auth::id() != $product->user_id) {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
    
        $product->is_sold_out = !$product->is_sold_out;
        $product->save();
    
        return redirect()->back()->with('success', 'Product status updated successfully.');
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
        if ($product->image_path && Storage::exists('public/' . $product->image_path)) {
            Storage::delete('public/' . $product->image_path);
        }
        if ($product->video_path && Storage::exists('public/' . $product->video_path)) {
            Storage::delete('public/' . $product->video_path);
        }
        $product->delete();

        return redirect()->route('admin.items.index')->with('success', 'Product deleted successfully.');
    }
}
