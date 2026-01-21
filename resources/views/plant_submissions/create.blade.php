@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 mb-8 p-4 bg-gray-100 rounded shadow max-w-lg border border-gray-300">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Add New Hybrid</h1>
    <form action="{{ route('plant-submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-800 font-semibold">Plant ID <span class="text-red-600">*</span></label>
            <input type="text" name="plant_id" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200" required value="{{ old('plant_id') }}">
            @error('plant_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        
        <div>
            <label class="block text-gray-800 font-semibold">Seed parent <i class='fas fa-venus text-red-600'></i></label>
            <select name="induk_betina" id="induk_betina" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih/Isi Plant ID atau Nama Penyilang --</option>
                @foreach($parentSubmissions as $parent)
                    <option value="{{ $parent->plant_id }}">
                        {{ $parent->plant_id }}
                        @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                        @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                    </option>
                        @endforeach
            </select>
            <!-- warning duplikat dihapus -->
            @error('induk_betina') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Pollen parent <i class='fas fa-mars text-blue-600'></i></label>
            <select name="induk_jantan" id="induk_jantan" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih/Isi Plant ID atau Nama Penyilang --</option>
                @foreach($parentSubmissions as $parent)
                    <option value="{{ $parent->plant_id }}">
                        {{ $parent->plant_id }}
                        @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                        @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                    </option>
                        @endforeach
            </select>
            <!-- warning duplikat dihapus -->
            @error('induk_jantan') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Breeder <span class="text-gray-500 font-normal">(Opsional)</span></label>
            <select name="penyilang" id="penyilang" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih/Isi Nama Penyilang --</option>
                @foreach($users as $user)
                    <option value="{{ $user->name }}" {{ old('penyilang') == $user->name ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('penyilang') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Uploader</label>
            <input type="text" class="w-full border border-gray-300 rounded p-2 bg-gray-100" value="{{ Auth::user()->name }}" readonly>
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Description</label>
            <textarea name="keterangan" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('keterangan') }}</textarea>
            @error('keterangan') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Photos</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
            @error('image') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
    </form>
</div>
    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 tetap aktif, tanpa validasi duplikat
            $('#induk_jantan').select2({
                tags: true,
                placeholder: '-- Pilih/Isi ID atau Nama Tanaman --',
                allowClear: true,
                width: '100%'
            });
            $('#induk_betina').select2({
                tags: true,
                placeholder: '-- Pilih/Isi ID atau Nama Tanaman --',
                allowClear: true,
                width: '100%'
            });
            $('#penyilang').select2({
                tags: true,
                placeholder: '-- Pilih/Isi Nama Penyilang --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
@endsection
