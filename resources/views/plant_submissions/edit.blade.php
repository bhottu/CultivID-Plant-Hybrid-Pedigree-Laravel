@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 rounded max-w-lg ">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Edit Pengajuan Tanaman</h1>
    <form action="{{ route('plant-submissions.update', $plantSubmission) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
        <label class="block text-gray-800 font-semibold">
            Plant ID <span class="text-red-600">*</span>
        </label>

        <div class="grid grid-cols-[95%_5%] gap-2 items-center">

            <input
                type="text"
                name="plant_id"
                required
                value="{{ old('plant_id', $plantSubmission->plant_id) }}"
                class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
                oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();"
            >

            <!-- default -->
            <input type="hidden" name="plant_id_var" value="1">

            <label class="flex items-center gap-1 text-xs text-gray-600">
                <input
                    type="checkbox"
                    name="plant_id_var"
                    value="0"
                    class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                    {{ old('plant_id_var', $plantSubmission->plant_id_var) == 0 ? 'checked' : '' }}
                >
                Variegated?
            </label>
         <p id="helper-checkbox-text" class="text-xs font-normal text-body">Check this box if the plant is variegated.</p>
        </div>

        @error('plant_id')
            <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
    </div>


        <div>
    <label class="block text-gray-800 font-semibold">
        Seed parent <i class="fas fa-venus text-red-600"></i>
        <span class="text-gray-500 text-xs font-normal italic">(Opsional)</span>
    </label>

    <div class="grid grid-cols-[95%_5%] gap-2 items-center">

        <select
            name="induk_betina"
            id="induk_betina"
            class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
        >
            <option value="">-- Pilih / Tambah baru --</option>
            @foreach($parentSubmissions as $parent)
                <option
                    value="{{ $parent->plant_id }}"
                    {{ old('induk_betina', $plantSubmission->induk_betina) == $parent->plant_id ? 'selected' : '' }}
                >
                    {{ $parent->plant_id }}
                    @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                    @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                </option>
            @endforeach
        </select>

        <!-- default -->
        <input type="hidden" name="induk_betina_var" value="1">

        <label class="flex items-center gap-1 text-xs text-gray-600">
            <input
                type="checkbox"
                name="induk_betina_var"
                value="0"
                class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                {{ old('induk_betina_var', $plantSubmission->induk_betina_var) == 0 ? 'checked' : '' }}
            >
            Variegated?
        </label>
         <p id="helper-checkbox-text" class="text-xs font-normal text-body">Check this box if the seed parent is variegated.</p>
    </div>

    @error('induk_betina')
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>


        <div>
    <label class="block text-gray-800 font-semibold">
        Pollen parent <i class="fas fa-mars text-blue-600"></i>
        <span class="text-gray-500 text-xs font-normal italic">(Opsional)</span>
    </label>

    <div class="grid grid-cols-[95%_5%] gap-2 items-center">

        <select
            name="induk_jantan"
            id="induk_jantan"
            class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
        >
            <option value="">-- Pilih / Tambah baru --</option>
            @foreach($parentSubmissions as $parent)
                <option
                    value="{{ $parent->plant_id }}"
                    {{ old('induk_jantan', $plantSubmission->induk_jantan) == $parent->plant_id ? 'selected' : '' }}
                >
                    {{ $parent->plant_id }}
                    @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                    @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                </option>
            @endforeach
        </select>

        <!-- default -->
        <input type="hidden" name="induk_jantan_var" value="1">

        <label class="flex items-center gap-1 text-xs text-gray-600">
            <input
                type="checkbox"
                name="induk_jantan_var"
                value="0"
                class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                {{ old('induk_jantan_var', $plantSubmission->induk_jantan_var) == 0 ? 'checked' : '' }}
            >
            Variegated?
        </label>
            <p id="helper-checkbox-text" class="text-xs font-normal text-body">Check this box if the pollen parent is variegated.</p>
    </div>

    @error('induk_jantan')
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>

        
        <div>
            <label class="block text-gray-800 font-semibold">Breeder <span class="text-gray-500 text-xs font-normal italic">(Opsional)</span></label>
            <select name="penyilang" id="penyilang" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih / Tambah baru --</option>
                @foreach($users as $user)
                    <option value="{{ $user->name }}" {{ old('penyilang', $plantSubmission->penyilang) == $user->name ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
                @if($plantSubmission->penyilang && !$users->pluck('name')->contains($plantSubmission->penyilang))
                    <option value="{{ $plantSubmission->penyilang }}" selected>{{ $plantSubmission->penyilang }}</option>
                @endif
            </select>
            @error('penyilang') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Uploader</label>
            <input type="text" class="w-full border border-gray-300 rounded p-2 bg-gray-100" value="{{ $plantSubmission->uploader ? $plantSubmission->uploader->name : '-' }}" readonly>
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Description</label>
            <textarea name="keterangan" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('keterangan', $plantSubmission->keterangan) }}</textarea>
            @error('keterangan') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Photos</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
            @php
                $images = [];
                if ($plantSubmission->image) {
                    $decoded = json_decode($plantSubmission->image, true);
                    if (is_array($decoded)) {
                        $images = $decoded;
                    } else {
                        $images = [$plantSubmission->image];
                    }
                }
                $mainImage = count($images) ? $images[0] : null;
            @endphp
            
            @if($plantSubmission->image)
                <img src="{{ asset('storage/'.$mainImage) }}" alt="Foto Tanaman" class="mt-2 w-32 h-32 object-cover rounded">
            @endif
            @error('image') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
    <button type="submit" class="bg-gray-800 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold shadow">Update</button>
    </form>
</div>
    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#induk_jantan').select2({
                tags: true,
                placeholder: '-- Pilih / Tambah baru --',
                allowClear: true,
                width: '100%'
            });
            $('#induk_betina').select2({
                tags: true,
                placeholder: '-- Pilih / Tambah baru --',
                allowClear: true,
                width: '100%'
            });
            $('#penyilang').select2({
                tags: true,
                placeholder: '-- Pilih / Tambah baru --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
@endsection
