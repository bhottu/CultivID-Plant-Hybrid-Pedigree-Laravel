<!-- resources/views/admin/items/index.blade.php -->

@extends('admin.layout')

@section('content')
    <div class="container mx-auto px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

        <h1 class="text-3xl font-semibold mb-4">List of Products</h1>

        @if ($products->count())
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-200 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Product Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Discount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Created Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $product->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 border-b border-gray-200">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $product->category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $product->user->currency }} {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">
                                    @if ($product->discount)
                                    {{ sprintf('%.0f', $product->discount) }}%
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $product->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.items.show', $product) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg width="24" height="24" viewBox="0 0 1024 1024" class="icon" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#003366" d="M512 160c320 0 512 352 512 352S832 864 512 864 0 512 0 512s192-352 512-352zm0 64c-225.28 0-384.128 208.064-436.8 288 52.608 79.872 211.456 288 436.8 288 225.28 0 384.128-208.064 436.8-288-52.608-79.872-211.456-288-436.8-288zm0 64a224 224 0 110 448 224 224 0 010-448zm0 64a160.192 160.192 0 00-160 160c0 88.192 71.744 160 160 160s160-71.808 160-160-71.744-160-160-160z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.items.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg fill="#D32F2F" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.755,20.283,4,8H20L18.245,20.283A2,2,0,0,1,16.265,22H7.735A2,2,0,0,1,5.755,20.283ZM21,4H16V3a1,1,0,0,0-1-1H9A1,1,0,0,0,8,3V4H3A1,1,0,0,0,3,6H21a1,1,0,0,0,0-2Z"/>
                                            </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @else
            <p class="mt-4">Tidak ada produk yang ditemukan.</p>
        @endif
    </div>
@endsection
