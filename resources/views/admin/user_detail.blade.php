@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-6">User Detail</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
             
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">User ID</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Name</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Balance</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">Rp {{ number_format($user->balance,0,",",".") }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Email</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Phone Number</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $user->phone_number ?? 'Not Set' }}</td>
                    </tr>
                     <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Location</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $user->latitude }}, {{ $user->longitude }} </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Role</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">
                            @if($user->is_admin)
                                <span class="bg-green-100 text-green-800 py-1 px-2 rounded-md text-xs font-medium">Admin</span>
                            @else
                                <span class="bg-gray-100 text-red-800 py-1 px-2 rounded-md text-xs font-medium">User</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Currency</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $user->currency ?? 'Not Set' }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Total Posts</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $totalPosts }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Total Products</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">{{ $totalProducts }}</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">Profile Photo</td>
                        <td class="px-3 py-2 text-sm text-gray-500 border-b border-gray-200">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="w-24 h-24 object-cover rounded-full border border-gray-300">
                            @else
                                No Photo
                            @endif
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <!-- Tombol Delete -->
        @if(!$user->is_admin)
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete();" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 mt-3 text-white hover:bg-red-700 px-4 py-2 rounded-md text-sm font-medium">
                    Delete User
                </button>
            </form>
        @else
            <button type="button" disabled class="bg-gray-300 mt-3 text-gray-500 px-4 py-2 rounded-md text-sm font-medium cursor-not-allowed">
                Delete User
            </button>
        @endif
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this user?');
    }
</script>
@endsection
