<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10); 
        return view('admin.items.categories', compact('categories'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
    
        $category = new Category();
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name); // Create slug from name
        $category->save();
    
        return redirect()->route('admin.items.categories')->with('success', 'Category created successfully.');
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->where('category_id', $category->id)->orderBy('created_at', 'desc')->paginate(9);

        return view('categories.show', compact('category', 'products'));
    }

    public function showAll()
    {
        $categories = Category::all();
        return view('categories.allcategories', compact('categories'));
    }

    public function loadMoreProducts(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $page = $request->get('page', 1);
        $products = $category->products()->where('category_id', $category->id)->orderBy('created_at', 'desc')->paginate(9, ['*'], 'page', $page);

        $view = view('partials.product_items', compact('products'))->render();
        return response()->json([
            'html' => $view,
            'nextPageUrl' => $products->hasMorePages() ? $products->nextPageUrl() : null
        ]); 
    }

    // admin
    public function destroy($id)
        {
            $category = Category::findOrFail($id);
            $category->delete();
            
            return redirect()->route('admin.items.categories')
                            ->with('success', 'Category deleted successfully');
        }

    public function edit(Category $category)
        {
            return view('admin.items.edit-categories', compact('category'));
        }

    public function update(Request $request, Category $category)
        {
            $request->validate(['name' => 'required|string|max:255']);

            $category->name = $request->name;
            $category->slug = \Str::slug($request->name); // Update slug
            $category->save();

            return redirect()->route('admin.items.categories')->with('success', 'Category updated successfully.');
        }

}
