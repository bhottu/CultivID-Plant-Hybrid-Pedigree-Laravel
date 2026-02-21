@extends('admin.layout')

@section('content')
    <div class="container mx-auto px-4">
        <div class="mb-4">
            <h1 class="text-3xl font-semibold">Edit Pengajuan Tanaman</h1>
        </div>
        <div class="bg-white rounded shadow p-4 border border-gray-200 max-w-2xl">
        <form 
            x-data="{ status: '{{ old('status_review', $plantSubmission->status_review) }}' }"
            action="{{ route('admin.plant-submissions.update', $plantSubmission) }}" 
            method="POST" 
            enctype="multipart/form-data" 
            class="space-y-4"
        >

        @csrf
        @method('PUT')
        <div>
            <label class="block text-gray-800 font-semibold">ID Tanaman <span class="text-red-600">*</span></label>
            <input type="text" name="plant_id" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200" required value="{{ old('plant_id', $plantSubmission->plant_id) }}">
            @error('plant_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Induk Jantan</label>
            <select name="induk_jantan" id="induk_jantan" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih/Isi Plant ID atau Nama Penyilang --</option>
                @foreach($parentSubmissions as $parent)
                    <option value="{{ $parent->plant_id }}" {{ old('induk_jantan', $plantSubmission->induk_jantan) == $parent->plant_id ? 'selected' : '' }}>
                        {{ $parent->plant_id }}
                        @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                        @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                    </option>
                @endforeach
            </select>
            @error('induk_jantan') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Induk Betina</label>
            <select name="induk_betina" id="induk_betina" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih/Isi Plant ID atau Nama Penyilang --</option>
                @foreach($parentSubmissions as $parent)
                    <option value="{{ $parent->plant_id }}" {{ old('induk_betina', $plantSubmission->induk_betina) == $parent->plant_id ? 'selected' : '' }}>
                        {{ $parent->plant_id }}
                        @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                        @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                    </option>
                @endforeach
            </select>
            @error('induk_betina') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Penyilang <span class="text-gray-500 font-normal">(Opsional)</span></label>
            <select name="penyilang" id="penyilang" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih/Isi Nama Penyilang --</option>
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
            <label class="block text-gray-800 font-semibold">Keterangan</label>
            <textarea name="keterangan" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('keterangan', $plantSubmission->keterangan) }}</textarea>
            @error('keterangan') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            
            <label class="block text-gray-800 font-semibold">Foto Tanaman</label>
            <input 
                type="file" 
                name="images[]" 
                multiple 
                accept="image/*"
                class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
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
            @endphp

             @if(count($images))
                <div class="mt-3 flex gap-2">
                    @foreach($images as $img)
                        <img 
                            src="{{ asset('storage/'.$img) }}" 
                            class="w-24 h-24 object-cover rounded border"
                        >
                    @endforeach
                </div>
            @endif

            @error('images') 
                <div class="text-red-600 text-sm">{{ $message }}</div> 
            @enderror
            
        </div>

        <div>
            <label class="block text-gray-800 font-semibold">
                Status Review <span class="text-red-600">*</span>
            </label>

            <select 
                name="status_review" 
                x-model="status"
                class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>

            @error('status_review') 
                <div class="text-red-600 text-sm">{{ $message }}</div> 
            @enderror
        </div>

        <div x-show="status === 'rejected'" x-transition>
            <label class="block text-gray-800 font-semibold">
                Rejection Reason <span class="text-red-600">*</span>
            </label>

            <textarea 
                name="rejection_reason" 
                class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
            >{{ old('rejection_reason', $plantSubmission->rejection_reason) }}</textarea>

            @error('rejection_reason') 
                <div class="text-red-600 text-sm">{{ $message }}</div> 
            @enderror
        </div>


        <button type="submit" class="bg-gray-800 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold shadow">Update</button>
        </form>
    </div>
   
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
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
   
@endsection
