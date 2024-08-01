{{-- resources/views/admin/discuss.blade.php --}}

@extends('admin.layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">List of Posts</h1>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    @if($posts->isEmpty())
        <p class="text-gray-500">No posts.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg border border-gray-200">
                <thead class="bg-gray-200 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Caption</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $post->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-b border-gray-200">{{ $post->user->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-24 h-auto object-cover">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $post->caption }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $post->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm font-medium border-b border-gray-200">
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                    <svg fill="#D32F2F" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.755,20.283,4,8H20L18.245,20.283A2,2,0,0,1,16.265,22H7.735A2,2,0,0,1,5.755,20.283ZM21,4H16V3a1,1,0,0,0-1-1H9A1,1,0,0,0,8,3V4H3A1,1,0,0,0,3,6H21a1,1,0,0,0,0-2Z"/>
                                            </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Paginasi -->
        <div class="mt-4">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @endif
</div>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this post?');
    }
</script>
@endsection
