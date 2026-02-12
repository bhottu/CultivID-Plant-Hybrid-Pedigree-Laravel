<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // ambil / buat cart aktif
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
            'status' => 'active',
        ]);

        // cek item di cart
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $product = Product::find($request->product_id);

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->finalPrice(),
            ]);
        }

        return back()->with('success', 'Added to cart');
    }

    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('status', 'active')
            ->with('items.product')
            ->first();

        return view('cart.index', compact('cart'));
    }
}

