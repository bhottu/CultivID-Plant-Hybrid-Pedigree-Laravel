@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Tanaman Anda</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 text-right">
        <a href="{{ route('plants.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200">Tambah Tanaman Baru</a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-6 py-3 text-sm font-medium text-gray-600">Nama Umum</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-600">Genus</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-600">Keluarga</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-600">Induk</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-600">Status</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plants as $plant)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $plant->common_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $plant->genus }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $plant->family }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $plant->female_parents_id }} x {{ $plant->male_parents_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">{{ $plant->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <a href="{{ route('plants.edit', $plant->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a> |
                            <form action="{{ route('plants.destroy', $plant->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
