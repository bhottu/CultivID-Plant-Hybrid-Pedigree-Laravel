@extends('admin.layout')

@section('content')

<div class="container mx-auto p-6">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Add Currency</h2>
        <form action="{{ route('currencies.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="code" class="block text-gray-700">Code:</label>
                <input type="text" id="code" name="code" placeholder="IDR" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s">
            </div>
            <div>
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" id="name" name="name" placeholder="Indonesia" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s">
            </div>
            <div>
                <label for="symbol" class="block text-gray-700">Symbol:</label>
                <input type="text" id="symbol" name="symbol" placeholder="Rp" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s">
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded shadow hover:bg-blue-600">Add</button>
        </form>
    </div>

    <div>
        <h2 class="text-2xl font-semibold mb-4">Currency List</h2>
        <table class="min-w-full bg-white border border-gray-300 rounded-md">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left">Code</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Symbol</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($currencies as $currency)
    <tr class="hover:bg-gray-50 border-b border-gray-300">
        <td class="px-4 py-2">{{ $currency->code }}</td>
        <td class="px-4 py-2">{{ $currency->name }}</td>
        <td class="px-4 py-2">{{ $currency->symbol }}</td>
        <td class="px-4 py-2 flex items-center space-x-2">
          
            <a href="{{ route('currencies.edit', $currency->id) }}" class="text-blue-600 hover:text-blue-900">
                <svg fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="inline-block">
                    <line x1="21" y1="21" x2="3" y2="21" style="fill: none; stroke: #00A9BC; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></line>
                    <path d="M19.88,7,11,15.83,7,17l1.17-4,8.88-8.88A2.09,2.09,0,0,1,20,4,2.09,2.09,0,0,1,19.88,7Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                </svg>
            </a>
            
            <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete();">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">
                    <svg fill="#D32F2F" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
</div>
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this currency?');
}
</script>
@endsection
