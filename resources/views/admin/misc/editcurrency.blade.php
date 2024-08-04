@extends('admin.layout')

@section('content')

<div class="container mx-auto p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Currency</h2>
        <form action="{{ route('currencies.update', $currency->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            @error('code')
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ $message }}
                </div>
            @enderror
            <div>
                <label for="code" class="block text-gray-700">Code:</label>
                <input type="text" id="code" name="code" value="{{ old('code', $currency->code) }}" placeholder="IDR" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s">
            </div>

            @error('name')
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ $message }}
                </div>
            @enderror
            <div>
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $currency->name) }}" placeholder="Indonesia" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s">
            </div>

            @error('symbol')
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ $message }}
                </div>
            @enderror
            <div>
                <label for="symbol" class="block text-gray-700">Symbol:</label>
                <input type="text" id="symbol" name="symbol" value="{{ old('symbol', $currency->symbol) }}" placeholder="Rp" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-s">
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded shadow hover:bg-blue-600">Update</button>
        </form>


    </div>
</div>

@endsection
