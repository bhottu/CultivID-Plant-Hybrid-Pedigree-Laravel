@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg p-4 bg-white">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-green-900 flex items-center bg-red-200 rounded-lg py-1 px-2">
            <i class='fas fa-seedling text-green-600 mr-2'></i> <span class="italic">{{ $plantSubmission->plant_id }}</span>
        </h1>
       
    </div>
    <div class="flex flex-col  gap-2">
        <div>
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
            @if($mainImage)
                @if(count($images) > 1)
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="prevImage()" class="bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <div class="relative w-full bg-white rounded overflow-hidden border border-gray-200 shadow">
                            <img id="mainImage" src="{{ asset('storage/'.$mainImage) }}" alt="Foto Tanaman" class="w-full h-[200px] object-cover cursor-pointer transition" onclick="showImageModal('{{ asset('storage/'.$mainImage) }}')">
                        </div>
                        <button onclick="nextImage()" class="bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                @else
                    <div class="relative w-full bg-white rounded overflow-hidden border border-gray-200 shadow">
                        <img id="mainImage" src="{{ asset('storage/'.$mainImage) }}" alt="Foto Tanaman" class="w-full h-[200px] object-cover cursor-pointer transition" onclick="showImageModal('{{ asset('storage/'.$mainImage) }}')">
                    </div>
                @endif
                @if(count($images) > 1)
                    <div class="mt-2 flex gap-2">
                        @foreach(array_slice($images, 1) as $thumb)
                            <img src="{{ asset('storage/'.$thumb) }}" alt="thumb" class="w-12 h-12 object-cover rounded cursor-pointer border border-gray-300" onclick="showImageModal('{{ asset('storage/'.$thumb) }}')">
                        @endforeach
                    </div>
                @endif
            @else
                <div class="w-full bg-white rounded border border-gray-200 shadow p-4 text-center">
                    <span class="text-xs  text-gray-400">No photo</span>
                     @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs text-red-400 underline">Add</a>
                            @elseif(Auth::check())
                                <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs text-red-400 underline">Appeal</a>
                            @else
                                <a href="{{ route('login') }}" class="text-xs text-red-400 underline">Appeal</a>
                            @endif
                </div>
            @endif
        </div>
        
    <div class="p-4 rounded border border-gray-200 shadow text-sm w-full">
        
            <table class="table-auto text-sm mb-4 text-xs w-full">
                <tr class="border-b border-gray-50">
                    <td class="pr-2 text-xs">Plant ID</td>
                   <td class="italic text-xs text-right"> 
                    @if($plantSubmission->plant_id)
                           <span class="italic"> {{ $plantSubmission->plant_id }}</span>
                           @if($plantSubmission->plant_id_var == 0)
                                <span class="text-xs py-0.5 rounded bg-green-100 text-green-700 font-semibold">
                                    Variegated
                                </span>
                            @endif
                        @else
                            <span class="italic text-gray-400">No data</span> 
                        @endif
                   </td>
                </tr>
                <tr class="border-b border-gray-50">
                    <td class="pr-2">Seed parent <i class='fas fa-venus text-red-600'></i></td>
                    <td class="italic text-xs text-right"> 
                        @if($plantSubmission->induk_betina)
                            {{ $plantSubmission->induk_betina }} 

                            @if($plantSubmission->induk_betina_var == 0)
                                <span class=" text-xs py-0.5 rounded bg-green-100 text-green-700 font-semibold">
                                    Variegated
                                </span>
                            @endif
                        @else
                            <span class="italic text-gray-400">No data, </span>
                            
                            @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs text-red-400 underline">Add</a>
                            @elseif(Auth::check())
                                <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs text-red-400 underline">Appeal</a>
                            @else
                                <a href="{{ route('login') }}" class="text-xs text-red-400 underline">Appeal</a>
                            @endif
                        
                        @endif
                    </td>
                </tr>
                <tr class="border-b border-gray-50">
                    <td class="pr-2">Pollen parent <i class='fas fa-mars text-blue-600'></i></td>
                    <td class="italic text-xs text-right">
                        @if($plantSubmission->induk_jantan)
                            {{ $plantSubmission->induk_jantan }}

                            @if($plantSubmission->induk_jantan_var == 0)
                                <span class="text-xs py-0.5 rounded bg-green-100 text-green-700 font-semibold">
                                    Variegated
                                </span>
                            @endif
                        @else
                            <span class="italic text-gray-400">No data, </span> 
                            @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs text-red-400 underline">Add</a>
                            @elseif(Auth::check())
                                <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs text-red-400 underline">Appeal</a>
                            @else
                                <a href="{{ route('login') }}" class="text-xs text-red-400 underline">Appeal</a>
                            @endif
                        
                        @endif
                    </td>
                </tr>
                <tr class="border-b border-gray-50">
                    <td class="pr-2">Breeder </td>
                    <td class="italic text-xs text-right"> 
                        @if($plantSubmission->penyilang)
                            {{ $plantSubmission->penyilang }}
                        @else
                            <span class="italic text-gray-400">No data, </span>
                            @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs text-red-400 underline">Add</a>
                            @elseif(Auth::check())
                                <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs text-red-400 underline">Appeal</a>
                            @else
                                <a href="{{ route('login') }}" class="text-xs text-red-400 underline">Appeal</a>
                            @endif
                        
                        @endif
                        </td>
                </tr>
                
                @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                <tr class="border-b border-gray-50">
                    <td class="pr-2">Status</td>
                    <td class="text-right">
                       <span class="px-1 text-gray-700 font-semibold rounded text-xxs 
                       {{ 
                        $plantSubmission->status_review == 'approved' ? 'bg-green-200 text-green-900' : 
                        ($plantSubmission->status_review == 'rejected' ? 'bg-red-200 text-red-900' : 
                        ($plantSubmission->status_review == 'banding' ? 'bg-yellow-200 text-yellow-900' : 'bg-gray-200 text-gray-900')) 
                        }} text-right">
                           {{ ucfirst($plantSubmission->status_review) }}
                        </span>
                    </td>
                </tr>
                @endif
            </table>
           
            <div class="mt-4 text-xs rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 text-yellow-500"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75M12 15.75h.01M10.29 3.86l-8.03 13.9a1.5 1.5 0 001.3 2.24h16.88a1.5 1.5 0 001.3-2.24l-8.03-13.9a1.5 1.5 0 00-2.6 0z" />
                        </svg>

                        <div>
                            <p>
                                <strong>Warning:</strong>
                                If there is any mistake in the breeder or parent plant name,
                                please submit an appeal to move this plant to your account.
                            </p>
                            <p class="mt-2">
                                <strong>Alternatively</strong>, you may ask the uploader to update the data
                                without transferring ownership on this page.
                            </p>
                        </div>
                    </div>
                @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                    <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="bg-gray-800 text-white px-4 py-1 rounded text-xs">Edit</a>
                @elseif(Auth::check())
                    <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="whitespace-nowrap rounded-md bg-yellow-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-yellow-600">Appeal</a>
                @else
                    <a href="{{ route('login') }}" class="whitespace-nowrap rounded-md bg-yellow-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-yellow-600">Appeal</a>
                @endif

    </div>
</div>
        
      </div>
    </div>
    

     
     
{{-- ===================== --}}
{{-- PEDIGREE TABLE --}}
{{-- ===================== --}}
@if(isset($pedigree) && $pedigree)

@php
    function plantLink($plantId, $gender = null) {
        if (!$plantId) {
            return '<span class="text-gray-400 italic">—</span>';
        }

        $icon = '';
        if ($gender === 'f') {
        $icon = "<i class='fas fa-venus text-red-600 mr-1'></i>";
        }

        if ($gender === 'm') {
            $icon = "<i class='fas fa-mars text-blue-600 mr-1'></i>";
        }

        $exists = \App\Models\PlantSubmission::where('plant_id', $plantId)->exists();

        if ($exists) {
            return '<a href="'.route('plant-submissions.show', $plantId).'"
                       class="text-gray-600 text-xs hover:underline italic">'
                        .$icon.' '.$plantId.
                   '</a>';
        }

        return '<span class="text-gray-500 italic">'.$icon.' '.$plantId.'</span>';
    }
@endphp

<div class="mt-4">
    <h2 class="text-md text-green-900 mb-2">Pedigree</h2>

    <div class="overflow-x-auto">
        <table class="border-collapse border border-gray-300 text-sm text-center w-full">

            {{-- TABLE HEAD --}}
            <thead class="bg-yellow-50 text-xs text-gray-400">
                <tr>
                    <th class="border px-4 py-2">Offspring</th>
                    <th class="border px-4 py-2">Parent</th>
                    <th class="border px-4 py-2">Grandparents</th>
                </tr>
            </thead>

            <tbody>
                {{-- ROW 1 --}}
                <tr>
                    {{-- CHILD --}}
                    <td rowspan="4"
                        class="border bg-gray-50  px-4 py-6 text-green-900">
                        {!! plantLink($pedigree['plant_id']) !!}
                    </td>

                    {{-- PARENT BETINA --}}
                    <td rowspan="2"
                        class="border px-4 py-4 bg-red-50 ">
                        {!! plantLink($pedigree['betina_node']['plant_id'] ?? null, 'f') !!}
                    </td>

                    {{-- GRANDPARENT BETINA (ATAS) --}}
                    <td class="border bg-red-50  px-4 py-3">
                        {!! plantLink($pedigree['betina_node']['betina_node']['plant_id'] ?? null, 'f') !!}
                    </td>
                </tr>

                {{-- ROW 2 --}}
                <tr>
                    {{-- GRANDPARENT JANTAN (BAWAH) --}}
                    <td class="border bg-blue-50  bg-blue-50  px-4 py-3">
                        {!! plantLink($pedigree['betina_node']['jantan_node']['plant_id'] ?? null, 'm') !!}
                    </td>
                </tr>

                {{-- ROW 3 --}}
                <tr>
                    {{-- PARENT JANTAN --}}
                    <td rowspan="2"
                        class="border bg-blue-50  px-4 py-4 bg-blue-50 ">
                        {!! plantLink($pedigree['jantan_node']['plant_id'] ?? null, 'm') !!}
                    </td>

                    {{-- GRANDPARENT BETINA (ATAS) --}}
                    <td class="border bg-red-50  px-4 py-3">
                        {!! plantLink($pedigree['jantan_node']['betina_node']['plant_id'] ?? null, 'f') !!}
                    </td>
                </tr>

                {{-- ROW 4 --}}
                <tr>
                    {{-- GRANDPARENT JANTAN (BAWAH) --}}
                    <td class="border bg-blue-50 px-4 py-3">
                        {!! plantLink($pedigree['jantan_node']['jantan_node']['plant_id'] ?? null, 'm') !!}
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
</div>
@endif





    


    <h2 class="text-md text-green-900 mb-2 mt-2">Contributor</h2>
        @if($plantSubmission->uploader)
            <div class="bg-gray-50 p-4 rounded shadow text-sm">
                <div class="flex items-center gap-3 mb-2">
                    @if($plantSubmission->uploader->profile_photo_path)
                        <img src="{{ asset('storage/' . $plantSubmission->uploader->profile_photo_path) }}" alt="Profile" class="w-10 h-10 rounded-full">
                    @else
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($plantSubmission->uploader->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('profile', $plantSubmission->uploader->username) }}" class="font-semibold text-blue-600 hover:underline">{{ $plantSubmission->uploader->name }}</a>
                        <p class="text-xs text-gray-500">Member since {{ $plantSubmission->uploader->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex justify-between text-xs text-gray-600">
                    
                    <div class="flex items-center gap-1">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.24 12.24a6 6 0 00-8.49-8.49L5 10.5V19h8.5z"></path>
                        </svg>
                        <span>{{ $plantSubmission->uploader->plantSubmissions->count() }} Plants</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>{{ $plantSubmission->uploader->posts->count() }} Posts</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>{{ $plantSubmission->uploader->products->count() }} Products</span>
                    </div>
                </div>
            </div>
        @endif

           


            <div class="border rounded p-4 mt-4 bg-yellow-50 text-sm">
                
                    <h3 class="mb-2 bg-red-50">☕ Buy Me a Coffee</h3>

                     {{-- Buy Me a Coffee Section --}}
                    @php
                        $count = $plantSubmission->uploader->plantSubmissions->count();
                        $userName = $plantSubmission->uploader->name;
                        $contributorLevel = '';

                        if ($count > 0 && $count <= 10) {
                            $contributorLevel = 'A good start'; // biasa saja
                        } elseif ($count <= 50) {
                            $contributorLevel = 'Cool'; // keren
                        } elseif ($count <= 100) {
                            $contributorLevel = 'Amazing'; // luar biasa
                        } else {
                            $contributorLevel = 'One of the top contributors'; // top kontributor
                        }
                    @endphp

                    <div class="mb-3 text-gray-500">
                        @if($contributorLevel)
                            {{ $contributorLevel }}, <span class="font-semibold bg-red-200">{{ $userName }}</span> has contributed <span class="font-semibold bg-red-200">{{ $count }}</span> plants.
                        @else
                            <span class="font-semibold bg-red-200">{{ $userName }}</span> has contributed <span class="font-semibold bg-red-200">{{ $count }}</span> plants.
                        @endif
                        If you have benefited from their contributions, support them by sending a cup of coffee as an appreciation ☕
                    </div>


                    @if(auth()->check())
                <form action="{{ route('transactions.buy') }}" id="buyCoffeeForm"  method="POST">
                            @csrf

                                    {{-- Radio buttons --}}
                                <div class="mb-2">
                                    <label class="mr-4">
                                        <input type="radio" name="amount_option" value="5000"> Rp 5.000
                                    </label>
                                    <label class="mr-4">
                                        <input type="radio" name="amount_option" value="10000" checked> Rp 10.000
                                    </label>
                                    <label class="mr-4">
                                        <input type="radio" name="amount_option" value="25000"> Rp 25.000
                                    </label>
                                
                                </div>
                            <input type="text" class="border border-gray-300 rounded p-2 bg-gray-100" name="amount"  id="custom_amount"  placeholder="Enter amount" value="10000">
                            <input type="hidden" name="plant_id" value="{{ $plantSubmission->id }}">

                            <button
                                type="submit"
                                 id="sendBtn"
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-2 rounded"
                            >
                                Send
                            </button>
                        </form>

                        
                <script>
                    const radios = document.querySelectorAll('input[name="amount_option"]');
                    const amountInput = document.getElementById('custom_amount');
                    const form = document.getElementById('buyCoffeeForm');
                     const sendBtn = document.getElementById('sendBtn');

                     

                    radios.forEach(radio => {
                        radio.addEventListener('change', () => {
                            if (radio.value !== 'custom' && radio.checked) {
                                amountInput.value = radio.value; // otomatis set value radio
                            }
                        });
                    });

                     form.addEventListener('submit', (e) => {
                        // Hapus semua titik dan koma sebelum submit
                        amountInput.value = amountInput.value.replace(/[\.,]/g, '');
                    });

                    // Opsional: format tampilan saat mengetik agar lebih enak dibaca
                    amountInput.addEventListener('input', () => {
                        let numericValue = amountInput.value.replace(/[\.,]/g, '');
                        if (numericValue) {
                            // menambahkan titik ribuan sementara
                            amountInput.value = Number(numericValue).toLocaleString('id-ID');
                        }
                    });
                </script>
                
                @else
                    <button class="bg-green-600 hover:bg-green-700 text-white px-2 py-2 rounded" onclick="alert('Silakan login terlebih dahulu!')">☕ Buy Me a Coffee</button>
                @endif

            </div>

            


</div>
    <!-- Modal Popout Foto -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute -top-6 -right-6 md:top-0 md:right-0 bg-gray-800 text-white rounded-full p-2 hover:bg-red-600 shadow-lg z-50" style="right: -2rem; top: -2rem;">
                <i class="fas fa-times"></i>
            </button>
            @if(count($images) > 1)
                <div class="flex items-center justify-center gap-4">
                    <button onclick="prevModalImage()" class="bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <div class="relative">
                        <img id="modalImage" src="" class="max-w-xs md:max-w-lg max-h-[80vh] rounded shadow-lg border-4 border-white" alt="Zoom Foto Tanaman">
                    </div>
                    <button onclick="nextModalImage()" class="bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            @else
                <img id="modalImage" src="" class="max-w-xs md:max-w-lg max-h-[80vh] rounded shadow-lg border-4 border-white" alt="Zoom Foto Tanaman">
            @endif
        </div>
    </div>
    <script>
        @php
            $imagesArray = [];
            if ($plantSubmission->image) {
                $decoded = json_decode($plantSubmission->image, true);
                if (is_array($decoded)) {
                    $imagesArray = $decoded;
                } else {
                    $imagesArray = [$plantSubmission->image];
                }
            }
        @endphp
        const images = @json($imagesArray);
        const baseUrl = '{{ asset('storage') }}/';
        let currentIndex = 0;

        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
            // Find currentIndex
            const imagePath = src.replace(baseUrl, '');
            currentIndex = images.indexOf(imagePath);
        }
        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('modalImage').src = '';
        }
        // Close modal on ESC
        document.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') closeImageModal();
        });

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            document.getElementById('mainImage').src = baseUrl + images[currentIndex];
        }
        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            document.getElementById('mainImage').src = baseUrl + images[currentIndex];
        }
        function prevModalImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            document.getElementById('modalImage').src = baseUrl + images[currentIndex];
        }
        function nextModalImage() {
            currentIndex = (currentIndex + 1) % images.length;
            document.getElementById('modalImage').src = baseUrl + images[currentIndex];
        }
    </script>
@endsection
