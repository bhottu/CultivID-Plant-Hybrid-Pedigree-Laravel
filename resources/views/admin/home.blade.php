<!-- resources/views/admin/home.blade.php -->
 
@extends('admin.layout')

@section('content')
<div class="grid grid-cols-1 gap-4 mt-8 sm:grid-cols-3 ">

        <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
            <div class="p-4 bg-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
            <div class="px-4 text-gray-700">
                <h3 class="text-sm tracking-wider">Total Member</h3>
                <p class="text-3xl">{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
            <div class="p-4 bg-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <path d="M9 15h6M12 12v6"></path>
                </svg>
            </div>
            <div class="px-4 text-gray-700">
                <h3 class="text-sm tracking-wider">Total Product</h3>
                <p class="text-3xl">{{ $totalProducts }}</p>
            </div>
        </div>

        <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
            <div class="p-4 bg-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                    </path>
                </svg>
            </div>
            <div class="px-4 text-gray-700">
                <h3 class="text-sm tracking-wider">Total Post</h3>
                <p class="text-3xl">{{ $totalPosts }}</p>
            </div>
        </div>


 

</div>

<div class="bg-white mt-4 border rounded-sm overflow-hidden shadow">
    <div class="px-4 py-2 bg-gray-200 border-b flex justify-between items-center">
        <h3 class="text-sm tracking-wider font-semibold">Latest Users</h3>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-500 hover:underline">View All</a>
    </div>
        @if($latestUsers->isEmpty())
            <p class="text-gray-500">No users found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border border-gray-200">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Role</th>
                            
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($latestUsers as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-20">{{ $user->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 border-b border-gray-200">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">
                                            User
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
</div>

<div class="bg-white mt-4 border rounded-sm overflow-hidden shadow">
        <div class="px-4 py-2 bg-gray-200 border-b flex justify-between items-center">
            <h3 class="text-sm tracking-wider font-semibold">Latest Products</h3>
            <a href="{{ route('admin.items.index') }}" class="text-sm text-blue-500 hover:underline">View All</a>
        </div>
        @if($latestProducts->isEmpty())
            <p class="text-gray-500">No products found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border border-gray-200">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Product Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Category</th>
                            
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($latestProducts as $product)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $product->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 border-b border-gray-200">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ Str::limit($product->description, 50) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $product->category->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
</div>

@endsection
