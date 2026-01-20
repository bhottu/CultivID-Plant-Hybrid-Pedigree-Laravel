@foreach ($products as $product)
    <div class="bg-white rounded-lg overflow-hidden mb-4 shadow-lg product-item">
        <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">
        @if ($product->image_path)
                    <div class="relative">
                            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                                @if ($product->is_sold_out)
                                    <span class="absolute bottom-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-tl">
                                        Sold Out
                                    </span>
                                @else
                                    <span class="absolute bottom-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-tl">
                                        Available
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endif
        </a>
        <div class="p-4">
            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-gray-500">
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
            </a>
                    
                        @if($product->discount)
                            <span class="text-red-600 line-through mr-2">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-gray-600">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-gray-600">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                   
            <div class="flex items-center">
                <a href="{{ url('profile/' . $product->user->id) }}">
                    
                    @if($product->user->profile_photo_path)
                        <img src="{{ asset('storage/' . $product->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                    @else
                        <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                    @endif
                </a>
                <div class="ml-2">
                    <span class="font-semibold">
                        <a href="{{ url('profile/' . $product->user->id) }}" class="hover:text-gray-500">{{ $product->user->name ?? 'Unknown' }}</a>
                    </span>
                    <div class="text-gray-500 text-xs">{{ $product->created_at->format('d M Y') }}</div>
                </div>
            </div>
            <p class="text-gray-800">{{ Str::limit($product->description, 50, '...') }}
                <span class="inline-block bg-blue-200 text-blue-800 rounded-300 px-3 py-1 text-xs font-semibold mr-2">
                    <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">Read more</a>
                </span>
            </p>
        </div>
    </div>
@endforeach
