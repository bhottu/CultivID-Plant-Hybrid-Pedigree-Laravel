@extends('admin.layout')

@section('content')

    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">Users</h1>
      

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if($users->isEmpty())
            <p class="text-gray-500">No users found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border border-gray-200">
                    <thead class="bg-gray-200 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $user->id }}</td>
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
                                <td class="px-6 py-4 text-sm font-medium border-b border-gray-200 flex items-center space-x-4">
                                <!-- Ikon View -->
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <svg width="24" height="24" viewBox="0 0 1024 1024" class="icon" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#003366" d="M512 160c320 0 512 352 512 352S832 864 512 864 0 512 0 512s192-352 512-352zm0 64c-225.28 0-384.128 208.064-436.8 288 52.608 79.872 211.456 288 436.8 288 225.28 0 384.128-208.064 436.8-288-52.608-79.872-211.456-288-436.8-288zm0 64a224 224 0 110 448 224 224 0 010-448zm0 64a160.192 160.192 0 00-160 160c0 88.192 71.744 160 160 160s160-71.808 160-160-71.744-160-160-160z"/>
                                    </svg>
                                </a>

                                <!-- Ikon Delete -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent border-0 p-0 text-red-600 hover:text-red-900 {{ $user->is_admin ? 'cursor-not-allowed opacity-50' : '' }}" {{ $user->is_admin ? 'disabled' : '' }}>
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
                {{ $users->links('pagination::tailwind') }}
            </div>
        @endif
    </div>


<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this user?');
    }
</script>
@endsection
