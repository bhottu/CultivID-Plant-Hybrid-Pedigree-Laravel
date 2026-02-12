@extends('layouts.app')

@section('content')

<div class="container mx-auto max-w-6xl px-4 py-10">

    <h1 class="text-2xl p-4 font-bold hidden md:block mt-8">Checkout</h1>

    {{-- CEK JIKA CART ADA & ADA ITEM --}}
    @if ($cart && $cart->items->isNotEmpty())

        <div class="grid md:grid-cols-2 gap-8">

            {{-- LEFT SIDE - LIST ITEM --}}
            <div class="md:col-span-2 bg-white rounded-xl shadow-sm p-6">

                <h2 class="text-lg font-semibold mb-4">Order Items</h2>

                @foreach ($cart->items as $item)
                    <div class="relative flex items-center justify-between border-b py-4">

                        <div class="flex items-center gap-4">

                            {{-- PRODUCT IMAGE --}}
                            <a href="{{ route('products.show', $item->product->slug) }}" class="w-12">
                                <div class="aspect-square w-full overflow-hidden rounded-lg border bg-gray-100">
                                    <img 
                                        src="{{ asset('storage/' . $item->product->image_path) }}" 
                                        alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            </a>

                            {{-- PRODUCT INFO --}}
                            <div>
                                <a href="{{ route('products.show', $item->product->slug) }}"
                                   class="font-semibold text-gray-800 hover:text-blue-600 transition">
                                    {{ $item->product->name }}
                                </a>

                                <p class="text-sm text-gray-500 mt-1">
                                    Qty: {{ $item->quantity }}
                                </p>

                                <p class="text-sm text-gray-400">
                                    Rp {{ number_format($item->price) }} / item
                                </p>
                            </div>

                        </div>

                        {{-- ITEM TOTAL --}}
                        <div class="font-semibold text-gray-700">
                            Rp {{ number_format($item->price * $item->quantity) }}
                        </div>

                        {{-- DELETE BUTTON --}}
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                        class="absolute top-3 right-0">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="text-gray-400 hover:text-red-600 transition text-lg font-bold">
                            &times;
                        </button>
                    </form>


                    </div>
                @endforeach

            </div>

            {{-- RIGHT SIDE - SUMMARY --}}
            <div class="bg-white rounded-xl shadow-sm p-6 h-fit">

                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>

                <div class="flex justify-between mb-2 text-gray-600">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($total) }}</span>
                </div>

                <div class="flex justify-between mb-4 text-gray-600">
                    <span>Shipping</span>
                    <span>Rp 0</span>
                </div>

                <div class="border-t pt-4 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-blue-600">
                        Rp {{ number_format($total) }}
                    </span>
                </div>

                <form action="{{ route('checkout.pay') }}" method="POST" class="mt-6">
                    @csrf
                    <button
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 transition text-white font-semibold rounded-lg shadow-sm">
                        Pay Now
                    </button>
                </form>

                <p class="text-xs text-gray-400 mt-3 text-center">
                    You will be redirected to secure payment page.
                </p>

            </div>

        </div>

    @else

        {{-- CART KOSONG --}}
        <div class="bg-white rounded-xl shadow-sm p-10 mt-8 text-center">
            <p class="text-gray-500 text-lg">
                There are no items in your cart
            </p>

            <a href="{{ route('products.index') }}"
               class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Shop now
            </a>
        </div>

    @endif

</div>

@endsection
