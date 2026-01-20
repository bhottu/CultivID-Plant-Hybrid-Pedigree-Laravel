<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
//use Illuminate\Http\JsonResponse;


class ApiProductController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $products = Product::latest()->paginate(10);
    
        // Kembalikan harga dan diskon tanpa format
        $products->getCollection()->transform(function ($product) {
            $product->price = $product->price;
            $product->discount = $product->discount;
            return $product;
        });
    
        return response()->json($products, 200);
    }


    public function discountedProducts()
    {

        $discountedProducts = Product::where('discount', '>', 0)->latest()->paginate(9);

        // Format price and discount for each discounted product
        $discountedProducts->getCollection()->transform(function ($product) {
            $product->price = $product->price;
            $product->discount =$product->discount;
            return $product;
        });

        return response()->json($discountedProducts, 200);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        return response()->json($product, 200);
    }

   public function store(Request $request)
    {
          \Log::info('User ID: ' . Auth::id());
          
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
        $product->user_id = Auth::id(); // Set user_id to the authenticated user
        $product->is_sold_out = false; // Default value

        // Handle image upload
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

        return response()->json([
            'message' => 'Product added successfully.',
            'product' => $product
        ], 201);
    }

    public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found.'], 404);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0|max:100',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'video' => 'nullable|mimes:mp4,mov,avi,flv|max:10240',
    ]);

    // Update fields
    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->category_id = $request->input('category_id');
    $product->price = $request->input('price');
    $product->discount = $request->input('discount');
    $product->user_id = $request->input('user_id', $product->user_id);

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($product->image_path && Storage::exists('public/' . $product->image_path)) {
            Storage::delete('public/' . $product->image_path);
        }
        $image = $request->file('image');
        $imageResized = Image::make($image)->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', 75);
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $imageResized->save(public_path('storage/images/' . $filename));
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

    return response()->json([
        'message' => 'Product updated successfully.',
        'product' => $product
    ], 201);
}

    public function destroy($id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    
        // Hapus file gambar dan video jika ada
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
    
        if ($product->video_path) {
            Storage::disk('public')->delete($product->video_path);
        }
    
        // Hapus produk dari database
        $product->delete();
    
        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }
}
