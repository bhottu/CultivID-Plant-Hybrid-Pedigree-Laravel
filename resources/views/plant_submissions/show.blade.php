@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg p-4 bg-white">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-green-900 flex items-center">
            <i class='fas fa-seedling text-green-600 mr-2'></i> {{ $plantSubmission->plant_id }}
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
                    <span class="text-gray-400">Tidak ada foto</span>
                </div>
            @endif
        </div>
    <div class="p-4 rounded border border-gray-200 shadow text-sm w-full">
        
            <table class="table-auto text-sm mb-4  w-full">
                <tr>
                    <td class="pr-2">ID Tanaman</td>
                   <td class="text-italic font-semibold ">→ {{ $plantSubmission->plant_id }}</td>
                </tr>
                <tr>
                    <td class="pr-2">Induk</td>
                    <td class="text-italic font-semibold ">→ {{ $plantSubmission->induk_betina }}</td>
                </tr>
                <tr>
                    <td class="pr-2">Induk </td>
                    <td class="text-italic font-semibold ">→ {{ $plantSubmission->induk_jantan }}</td>
                </tr>
                <tr>
                    <td class="pr-2">Penyilang </td>
                    <td class="text-italic font-semibold ">→ {{ $plantSubmission->penyilang }}</td>
                </tr>
                
                @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                <tr>
                    <td class="pr-2">Status</td>
                    <td>→
                       <span class="font-semibold  px-2 py-1 text-green-700 rounded text-xs {{ $plantSubmission->status_review == 'approved' ? 'bg-green-500 text-green-900' : ($plantSubmission->status_review == 'rejected' ? 'bg-red-500 text-red-900' : ($plantSubmission->status_review == 'banding' ? 'bg-yellow-500 text-yellow-900' : 'bg-gray-500 text-gray-900')) }}">
                           {{ ucfirst($plantSubmission->status_review) }}
                        </span>
                    </td>
                </tr>
                @endif
            </table>
           
            <div class="flex gap-2 mt-2">
                @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                    <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="bg-gray-800 text-white px-4 py-2 rounded text-xs">Ubah</a>
                @elseif(Auth::check())
                    <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="bg-red-600 text-white px-2 py-1 rounded mb-2 inline-block hover:bg-red-800 transition text-xs">Banding</a>
                @else
                    <a href="{{ route('login') }}" class="bg-white-600 border text-red-600 hover:text-gray-600 px-2 py-1 rounded mb-2 inline-block  transition text-xs">Banding</a>
                @endif
            </div>
        
      </div>
    </div>
    

     {{-- Silsilah Tanaman (Pedigree) --}}
    @if(isset($pedigree) && $pedigree)
    <div class="mt-2">
        <h2 class="text-md font-bold text-green-900 mb-2">Pedigree</h2>
        <div class="bg-gray-50 p-4 rounded shadow text-sm">
            @php
                function renderPedigree($node) {
                    if(!$node) return;
                    // Tampilkan satu level saja: induk dan anak
                    if($node['induk_betina'] || $node['induk_jantan']) {
                        echo '<div class="flex flex-row items-center justify-center gap-2 mb-1">';
                        if($node['induk_betina']) {
                            // Cek apakah induk_betina adalah ID yang valid (ada di DB)
                            $betinaExists = \App\Models\PlantSubmission::where("plant_id", $node['induk_betina'])->exists();
                            if($betinaExists) {
                                echo '<span class="flex items-center"><i class="fas fa-venus text-pink-400"></i> <a href="'.route('plant-submissions.show', ['plantSubmission' => $node['induk_betina']]).'" class="text-xs text-blue-600 underline ml-1">'.$node['induk_betina'].'</a></span>';
                            } else {
                                echo '<span class="flex items-center"><i class="fas fa-venus text-pink-400"></i> <span class="text-xs text-gray-700 ml-1">'.$node['induk_betina'].'</span></span>';
                            }
                        }
                        if($node['induk_betina'] && $node['induk_jantan']) {
                            echo '<span class="mx-1 text-gray-500">&times;</span>';
                        }
                        if($node['induk_jantan']) {
                            $jantanExists = \App\Models\PlantSubmission::where("plant_id", $node['induk_jantan'])->exists();
                            if($jantanExists) {
                                echo '<span class="flex items-center"><i class="fas fa-mars text-blue-400"></i> <a href="'.route('plant-submissions.show', ['plantSubmission' => $node['induk_jantan']]).'" class="text-xs text-blue-600 underline ml-1">'.$node['induk_jantan'].'</a></span>';
                            } else {
                                echo '<span class="flex items-center"><i class="fas fa-mars text-blue-400"></i> <span class="text-xs text-gray-700 ml-1">'.$node['induk_jantan'].'</span></span>';
                            }
                        }
                        echo '</div>';
                        // Panah ke bawah
                        echo '<div class="flex flex-row justify-center items-center h-4 mb-1">';
                        echo '<span class="block text-gray-500 text-lg mx-2">&#8595;</span>';
                        echo '</div>';
                    }
                    // Anak (ID)
                    echo '<div class="flex flex-col items-center mb-2">';
                    echo '<span class="font-semibold text-green-900 text-lg text-sm">'.$node['plant_id'].'</span>';
                    echo '</div>';
                }
                renderPedigree($pedigree);
            @endphp
        </div>
    </div>
    @endif

    <h2 class="text-md font-bold text-green-900 mb-2 mt-2">Uploader</h2>
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
                <div class="flex justify-between text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.24 12.24a6 6 0 00-8.49-8.49L5 10.5V19h8.5z"></path>
                        </svg>
                        <span>{{ $plantSubmission->uploader->plantSubmissions->count() }} Hybrid</span>
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
