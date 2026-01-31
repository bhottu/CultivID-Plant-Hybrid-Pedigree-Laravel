@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white rounded shadow max-w-lg">

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h1 class="text-2xl font-bold mb-4 text-gray-800">
    {{ $isView ? 'Appeal details' : 'Submit an Appeal' }}
    </h1>
    <div class="text-sm text-gray-500 mt-1">
    @if($isView)
       Here are the details of the appeal that has been submitted for the plant.
    <b>{{ $submission->plant_id }}</b>
    by <b>{{ $appeal->user?->name ?? 'Unknown' }}</b>.
    @else
        Errors in the plant name, breeder name, and parent plants of <b>{{ $submission->plant_id }}</b> uploaded by <b>{{ $submission->uploader?->name ?? 'Tidak diketahui' }}</b> may be appealed or revised. 
        
        Please fill out the form below. 
    @endif
    </div>

    @if(!$isView)
    <form action="{{ route('plant-submissions.appeal.store', $submission) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-4">
    @csrf
    @endif

        @csrf
        <div>
            <label class="block text-gray-800 font-semibold mt-3">Plant ID</label>
            <input type="text" class="w-full border border-gray-300 rounded p-2 bg-gray-100" value="{{ $submission->plant_id }}" readonly>
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Messages</label>
@php
$defaultText = "I would like to submit an appeal regarding this plant.
Please update the following information to reflect the actual data:

- Plant ID : $submission->plant_id 
- Seed parent : $submission->induk_betina
- Pollen parent : $submission->induk_jantan
- Breeder : $submission->penyilang
- Is this your plant? : Yes / No
- If approved, would you like to move this hybrid to your account? : Yes / No, just revise
- Explanation for Appeal (Optional) : 
";
@endphp

<textarea
    name="keterangan"
    rows="6"
    {{ $isView ? 'readonly' : 'required' }}
    class="w-full border border-gray-300 rounded p-2
        {{ $isView ? 'bg-gray-100' : 'bg-white focus:border-blue-500 focus:ring' }}"
         oninput="autoResize(this)"
>
{{ 
    $isView
        ? ($appeal->keterangan ?? '')
        : old('keterangan', $defaultText)
}}
</textarea>

           {{-- MODE SUBMIT --}}
            @if(!$isView)
                <div>
                    <label class="block text-gray-800 font-semibold">Photo revision</label>
                    <input type="file"
                        name="bukti[]"
                        multiple
                        accept="image/*"
                        class="w-full border border-gray-300 rounded p-2 bg-white" require>

                    <div class="text-xs text-gray-500 mt-1">
                        Maks. 5 foto, ukuran maks 500kb per foto
                    </div>
                </div>

                <button type="submit"
                    class="bg-gray-800 mt-3 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold shadow">
                    Send Appeal
                </button>
            @endif

            {{-- MODE VIEW --}}
            @if($isView)
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">
                        Photo revision
                    </label>

                    @php
                        $buktiImages = $appeal?->bukti
                            ? json_decode($appeal->bukti, true)
                            : [];
                    @endphp

                    @if(count($buktiImages))
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($buktiImages as $img)
                            <div class="border rounded shadow-sm p-2 bg-white">
                                {{-- Preview --}}
                               
                                    <img
                                        src="{{ asset('storage/'.$img) }}"
                                        onclick="openImageModal('{{ asset('storage/'.$img) }}')"
                                        class="rounded w-full object-cover hover:opacity-90 transition"
                                        alt="Bukti Banding">
                                

                                {{-- Download Button --}}
                                <a href="{{ asset('storage/'.$img) }}"
                                download
                                class="mt-2 block text-center text-xs bg-gray-800 hover:bg-blue-700 text-white px-3 py-1.5 rounded font-semibold transition">
                                    ⬇ Download
                                </a>
                            </div>
                        @endforeach
                </div>

                    @else
                        <div class="text-sm text-gray-500 italic">
                            Tidak ada foto yang dilampirkan.
                        </div>
                    @endif
                </div>

           

            @endif



    @if(!$isView)
    </form>
    @endif

   
    @if($isView && auth()->check() && auth()->user()->is_admin)
    <div class="relative mt-4">
        <button 
            id="menuTogglerevise"
            type="button"
            class="bg-gray-800 mt-3 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold shadow"
        >
            Revision
        </button>
    </div>

    <div id="mobileRevise" class="fixed inset-0 bg-white z-50 hidden flex-col overflow-y-auto max-h-screen">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="font-bold text-gray-800">Revision Menu</h2>
                <button id="menuClose"
                    class="text-gray-600 hover:text-red-600 text-xl font-bold">
                    ✕
                </button>
            </div>

        {{-- Content --}}
        <div class="container mx-auto p-4 rounded max-w-lg ">
            <form action="{{ route('plant-submissions.appeals.update', $submission) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
       
            <label class="block text-gray-800 font-semibold">
                Plant ID <span class="text-red-600">*</span>
            </label>

            <div class="grid grid-cols-[95%_5%] gap-2 items-center">

            <input
                type="text"
                name="plant_id"
                required
                value="{{ old('plant_id', $submission->plant_id) }}"
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
                    {{ old('plant_id_var', $submission->plant_id_var) == 0 ? 'checked' : '' }}
                >
                Variegated?
            </label>
            <p id="helper-checkbox-text" class="text-xs font-normal text-body">Check this box if the plant is variegated.</p>
        </div>

        @error('plant_id')
            <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
       
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
                    {{ old('induk_betina', $submission->induk_betina) == $parent->plant_id ? 'selected' : '' }}
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
                {{ old('induk_betina_var', $submission->induk_betina_var) == 0 ? 'checked' : '' }}
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
                    {{ old('induk_jantan', $submission->induk_jantan) == $parent->plant_id ? 'selected' : '' }}
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
                {{ old('induk_jantan_var', $submission->induk_jantan_var) == 0 ? 'checked' : '' }}
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
                    <option value="{{ $user->name }}" {{ old('penyilang', $submission->penyilang) == $user->name ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
                @if($submission->penyilang && !$users->pluck('name')->contains($submission->penyilang))
                    <option value="{{ $submission->penyilang }}" selected>{{ $submission->penyilang }}</option>
                @endif
            </select>
            @error('penyilang') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Move this plant to {{ $appeal?->user?->name ?? '-' }} (id {{ $appeal?->user_id ?? '-' }})</label>
            <input name="uploader_id" type="text" class="w-full border border-gray-300 rounded p-2" value="{{ $appeal?->user_id ?? '-' }}">
            <p id="helper-checkbox-text" class="text-xs font-normal text-body"> Contributor sebelumnya {{ $submission->uploader ? $submission->uploader->name : '-' }} (id {{ $submission->uploader ? $submission->uploader_id : '-' }})</p>
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Status</label>
            <input name="status_review" type="text" class="w-full border border-gray-300 rounded p-2" value="approved">
            <p id="helper-checkbox-text" class="text-xs font-normal text-body"> Status sebelumnya ({{ $submission?->status_review ?? '-' }})</p>
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Description</label>
            <textarea name="keterangan" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('keterangan', $submission->keterangan) }}</textarea>
            @error('keterangan') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-gray-800 font-semibold">Photos</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded p-2 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200">
            @php
                $images = [];
                if ($submission->image) {
                    $decoded = json_decode($submission->image, true);
                    if (is_array($decoded)) {
                        $images = $decoded;
                    } else {
                        $images = [$submission->image];
                    }
                }
                $mainImage = count($images) ? $images[0] : null;
            @endphp
            
            @if($submission->image)
                <img src="{{ asset('storage/'.$mainImage) }}" alt="Foto Tanaman" class="mt-2 w-32 h-32 object-cover rounded">
            @endif
            @error('image') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>
    <button type="submit" class="bg-gray-800 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold shadow">Update</button>
    </form>


        </div>

    @endif

    
        </div>


    {{-- Modal Preview --}}
    <div id="imageModal"
        onclick="closeImageModal()"
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">

        <div class="relative">
            {{-- Close button --}}
            <button onclick="closeImageModal()" class="absolute -top-6 -right-6 md:top-0 md:right-0 bg-gray-800 text-white rounded-full p-2 hover:bg-red-600 shadow-lg z-50" style="right: -2rem; top: -2rem;">
                    <i class="fas fa-times"></i>
                </button>

            <div class="flex items-center justify-center gap-4 px-2">
            {{-- Image --}}
            <img id="modalImage"
                src=""
                onclick="event.stopPropagation()"
                class="w-full max-h-[85vh] items-center max-w-lg object-contain rounded-lg shadow-lg bg-white">
            </div>
        </div>
    </div>


<script>
    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    }

    // auto resize saat halaman pertama kali load
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('textarea').forEach(function (el) {
            autoResize(el);
        });
    });
</script>

<script>
(function () {
    const body = document.body;

    document.addEventListener('click', function (e) {
        // OPEN
        if (e.target.closest('#menuTogglerevise')) {
            const menu = document.getElementById('mobileRevise');
            if (!menu) return;

            menu.classList.remove('hidden');
            menu.classList.add('flex');
            body.classList.add('overflow-hidden');
        }

        // CLOSE
        if (e.target.closest('#menuClose')) {
            const menu = document.getElementById('mobileRevise');
            if (!menu) return;

            menu.classList.add('hidden');
            menu.classList.remove('flex');
            body.classList.remove('overflow-hidden');
        }
    });
})();
</script>




<script>
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');

    modalImg.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

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

    
</div>
@endsection
