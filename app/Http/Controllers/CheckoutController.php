<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use Xendit\Configuration;
use App\Models\Product;



class CheckoutController extends Controller
{
   public function index()
{
    $cart = Cart::firstOrCreate([
        'user_id' => auth()->id(),
    ]);

    $cart->load('items.product');

    $total = $cart->items->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    return view('checkout.index', compact('cart', 'total'));
}

public function buyNow(Request $request)
{
    $product = Product::where('slug', $request->slug)->firstOrFail();

    // pakai accessor discounted_price
    $finalPrice = (int) round($product->discounted_price);

    if ($finalPrice <= 0) {
        return back()->with('error', 'Harga produk tidak valid');
    }

    Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    $apiInstance = new InvoiceApi();

    $invoice = $apiInstance->createInvoice([
        'external_id' => 'BUY-' . $product->id . '-' . time(),
        'amount' => $finalPrice,
        'payer_email' => auth()->user()->email,
        'description' => 'Buy Now - ' . $product->name,
        'currency' => 'IDR',
        'success_redirect_url' => route('products.show', $product->slug) . '?status=success',
        'failure_redirect_url' => route('products.show', $product->slug) . '?status=failed',
    ]);

    return redirect($invoice['invoice_url']);
}

public function remove($id)
{
    $item = \App\Models\CartItem::findOrFail($id);
    $item->delete();

    return back()->with('success', 'Item removed');
}


   public function pay()
{
    // SET API KEY LANGSUNG
    Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));

    $cart = Cart::where('user_id', auth()->id())
        ->where('status', 'active')
        ->with('items.product')
        ->firstOrFail();

    $total = $cart->items->sum(fn ($item) =>
        $item->price * $item->quantity
    );

    $apiInstance = new InvoiceApi();

    $invoice = $apiInstance->createInvoice([
        'external_id' => 'CART-'.auth()->id().'-'.time(),
        'amount' => $total,
        'payer_email' => auth()->user()->email,
        'description' => 'Checkout Cart',
    ]);

    return redirect($invoice['invoice_url']);
}

}
