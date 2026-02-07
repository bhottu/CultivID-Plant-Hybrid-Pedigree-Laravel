@foreach ($products as $product)
    {{-- Tambahkan text-left di sini untuk memastikan semua konten di dalam kartu merapat ke kiri --}}
    <div class="bg-white rounded-md overflow-hidden shadow-sm border border-gray-100 flex flex-col text-left">
        
        {{-- 1. Gambar --}}
        <div class="relative aspect-square w-full bg-gray-50">
            <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
                @if ($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-[10px] italic center">
                        No Image
                    </div>
                @endif
                
                <div class="absolute right-2"> 
                    <span class="absolute bottom-0 right-0 {{ $product->is_sold_out ? 'bg-red-500' : 'bg-green-500' }} text-white text-xxxs font-bold px-2 py-1 rounded-tl shadow-sm">
                        {{ $product->is_sold_out ? 'Sold Out' : 'Available' }}
                    </span>
                </div>
            </a>
        </div>

        {{-- 2. Detail Produk (Tambahkan text-left lagi untuk keamanan) --}}
        <div class="p-3 flex flex-col flex-grow text-left">
            <a href="{{ route('products.show', $product) }}" class="block mb-1 text-left">
                <h3 class="text-sm text-gray-800 leading-tight truncate text-left">
                    {{ $product->name }}
                </h3>
            </a>

            <div class="mb-2 text-left">
                @if($product->discount)
                    {{-- 1. Harga Setelah Diskon (Utama) --}}
                    <div class="text-sm font-black text-gray-600 leading-none text-left mb-1">
                        {{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }} 
                    </div>

                    {{-- 2. Harga Asli & Badge Diskon --}}
                    <div class="flex items-center gap-1.5 text-left">
                        <span class="text-xs text-red-500 line-through leading-none mr-2">
                            {{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        
                        {{-- Badge Diskon --}}
                        <span class="bg-red-100 text-red-600 text-xs  px-1 rounded">
                            {{ $product->discount }}%
                        </span>
                    </div>
                @else
                    {{-- Harga Normal jika tidak ada diskon --}}
                    <div class="text-sm font-black text-gray-600 leading-none text-left">
                        {{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                @endif
            </div>
          

            <div class="mt-auto pt-2 border-t border-gray-50 flex items-center justify-start gap-2 w-full text-left">
                @php
                    $photo = $product->user->profile_photo_path;
                @endphp
                <img src="{{ $photo ? asset('storage/' . $photo) : asset('storage/images/default.png') }}" 
                     class="h-5 w-5 rounded-full object-cover flex-shrink-0">
                
                <div class="min-w-0 text-left">
                    <p class="text-sm font-semibold text-gray-700 truncate leading-none text-left">
                        {{ $product->user->name ?? 'Unknown' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endforeach
