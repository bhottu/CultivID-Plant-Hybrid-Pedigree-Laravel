@extends('admin.layout')

@section('content')
<div class="container mx-auto">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    <h1 class="text-2xl text-center font-bold mb-4">Add Category</h1>
    <form action="{{ route('categories.store') }}" method="POST" class="max-w-md mx-auto">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Category</button>
    </form>

    <!-- Daftar Kategori -->
   
    <div class="overflow-x-auto mt-6">
        @if($categories->isEmpty())
            <p class="text-gray-700">No categories available.</p>
        @else
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Category Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-b border-gray-200">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $category->slug }}</td>

                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg fill="none" width="24" height="24" viewBox="0 0 24 24" id="edit" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                                        <line id="secondary" x1="21" y1="21" x2="3" y2="21" style="fill: none; stroke: #00A9BC; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></line>
                                        <path id="primary" d="M19.88,7,11,15.83,7,17l1.17-4,8.88-8.88A2.09,2.09,0,0,1,20,4,2.09,2.09,0,0,1,19.88,7Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                                        </svg>

                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')" style="display:inline-block;">
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
            <div class="mt-4">
            {{ $categories->links() }}
            </div>
        @endif
        
    </div>
</div>
@endsection
