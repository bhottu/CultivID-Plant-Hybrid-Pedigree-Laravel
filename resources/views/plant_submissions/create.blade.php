@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 rounded max-w-lg">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Add New Hybrid</h1>
    <form  id="hybridForm" action="{{ route('plant-submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
    <label class="block text-gray-800 font-semibold">
        Plant ID <span class="text-red-600">*</span>
    </label>

    <div class="grid grid-cols-[95%_5%] gap-2 items-center">

        <input
            type="text"
            name="plant_id"
            required
            value="{{ old('plant_id') }}"
            class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
            oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();"
        >

        <!-- DEFAULT VALUE (tidak dicentang) -->
        <input type="hidden" name="plant_id_var" value="1">

        <label class="flex items-center gap-1 text-xs text-gray-600">
            <input
                type="checkbox"
                name="plant_id_var"
                value="0"
                class="rounded border-gray-300 text-green-600 focus:ring-green-500"
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
                Seed parent <i class='fas fa-venus text-red-600'></i>
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
                        <option value="{{ $parent->plant_id }}">
                            {{ $parent->plant_id }}
                            @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                            @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                        </option>
                    @endforeach
                </select>

                <label class="flex items-center gap-1 text-xs text-gray-600">
                    <input
                        type="checkbox"
                        name="induk_betina_var"
                        class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                        {{ old('induk_betina_var') ? 'checked' : '' }}
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
                Pollen parent <i class='fas fa-mars text-blue-600'></i>
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
                        <option value="{{ $parent->plant_id }}">
                            {{ $parent->plant_id }}
                            @if($parent->induk_jantan) ({{ $parent->induk_jantan }}) @endif
                            @if($parent->induk_betina) ({{ $parent->induk_betina }}) @endif
                        </option>
                    @endforeach
                </select>

                <label class="flex items-center gap-1 text-xs text-gray-600">
                    <input
                        type="checkbox"
                        name="induk_jantan_var"
                        class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                        {{ old('induk_jantan_var') ? 'checked' : '' }}
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
            <label class="block text-gray-800 font-semibold">Photos (Max 3)</label>

            <input 
                type="file" 
                name="images[]" 
                id="images"
                multiple
                accept="image/*"
                class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200"
            >

            @error('images') 
                <div class="text-red-600 text-sm">{{ $message }}</div> 
            @enderror

            @error('images.*') 
                <div class="text-red-600 text-sm">{{ $message }}</div> 
            @enderror

            <!-- Preview -->
            <div id="previewContainer" class="mt-3 flex gap-2 flex-wrap"></div>
        </div>
   
        <button 
            type="submit" 
            id="submitBtn"
            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center justify-center gap-2"
        >
            <span id="submitText">Submit</span>

            <!-- Spinner -->
            <svg 
                id="submitSpinner"
                class="hidden animate-spin h-5 w-5 text-white" 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24"
            >
                <circle 
                    class="opacity-25" 
                    cx="12" 
                    cy="12" 
                    r="10" 
                    stroke="currentColor" 
                    stroke-width="4"
                ></circle>
                <path 
                    class="opacity-75" 
                    fill="currentColor" 
                    d="M4 12a8 8 0 018-8v8H4z"
                ></path>
            </svg>
        </button>


    </form>
</div>
    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

        function initParentSelect(selector) {
            $(selector).select2({
                tags: true,
                placeholder: '-- Type to search / Add new --',
                allowClear: true,
                width: '100%',

                createTag: function (params) {
                    const term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                },

                templateResult: function (data) {
                    if (data.newTag) {
                        return $(
                            '<span style="display:flex;align-items:center;justify-content:space-between;width:100%;">' +
                                '<span>' + data.text + '</span>' +
                                '<span style="display:inline-flex;align-items:center;font-size:12px;color:#000000;font-weight:600;">' +
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;">' +
                                        '<line x1="12" y1="5" x2="12" y2="19"></line>' +
                                        '<line x1="5" y1="12" x2="19" y2="12"></line>' +
                                    '</svg>' +
                                    'Add new' +
                                '</span>' +
                            '</span>'
                        );
                    }
                    return data.text;
                }
            });
        }

        // 🔥 Terapkan ke kedua field
        initParentSelect('#induk_jantan');
        initParentSelect('#induk_betina');

        // ⚠️ Penyilang tetap seperti milik kamu (tidak diubah)
        $('#penyilang').select2({
            tags: true,
            placeholder: '-- Type to search / Add new --',
            allowClear: true,
            width: '100%',
            minimumInputLength: 1,

            createTag: function (params) {
                const term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            },

                templateResult: function (data) {
                    if (data.newTag) {
                        return $(
                            '<span style="display:flex;align-items:center;justify-content:space-between;width:100%;">' +
                                '<span>' + data.text + '</span>' +
                                '<span style="display:inline-flex;align-items:center;font-size:12px;color:#000000;font-weight:600;">' +
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;">' +
                                        '<line x1="12" y1="5" x2="12" y2="19"></line>' +
                                        '<line x1="5" y1="12" x2="19" y2="12"></line>' +
                                    '</svg>' +
                                    'Add new' +
                                '</span>' +
                            '</span>'
                        );
                    }
                    return data.text;
                }
        });

    });

    const input = document.getElementById('images');
    const previewContainer = document.getElementById('previewContainer');

    input.addEventListener('change', function () {

        previewContainer.innerHTML = ''; // reset preview

        const files = Array.from(this.files);

        if (files.length > 3) {
            alert('Maximum 3 images allowed');
            this.value = '';
            return;
        }

        files.forEach(file => {

            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.className = "relative";

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = "w-24 h-24 object-cover rounded border border-gray-300";

                wrapper.appendChild(img);
                previewContainer.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    });


  
    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('hybridForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');

        if (!form) return;

        form.addEventListener('submit', function () {

            // prevent double submit
            if (submitBtn.disabled) return;

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

            submitText.textContent = 'Submitting...';
            submitSpinner.classList.remove('hidden');
        });

    });


    </script>
    @endpush
@endsection
