
   
@foreach($plantSubmissions as $item)
            <div class="bg-gray-50 p-4 h-auto border-b border-double  border-green-200">
                @php
                    $images = [];
                    if ($item->image) {
                        $decoded = json_decode($item->image, true);
                        if (is_array($decoded)) {
                            $images = $decoded;
                        } else {
                            $images = [$item->image];
                        }
                    }
                    $first = count($images) ? $images[0] : null;
                @endphp
                @if($first)
                     <a href="{{ route('plant-submissions.show', $item->plant_id) }}" class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-semibold block mb-2">
                        <img src="{{ asset('storage/'.$first) }}" alt="Foto Tanaman" class="w-full bg-cover h-48 object-cover rounded mb-3 cursor-pointer border border-gray-300 hover:shadow-lg transition">
                    </a>
                @endif
                <a href="{{ route('plant-submissions.show', $item->plant_id) }}" class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-semibold block mb-2">
                    {{ \Illuminate\Support\Str::limit($item->plant_id, 20) }}
                </a>
                <p class="text-xs text-gray-700 mb-1">
                    <span class="font-semibold"><i class='fas fa-venus text-red-600'></i></span>
                    {{ \Illuminate\Support\Str::limit($item->induk_betina, 20) }}
                </p>
                <p class="text-xs text-gray-700 mb-2">
                    <span class="font-semibold"><i class='fas fa-mars text-blue-600'></i></span>{{ \Illuminate\Support\Str::limit($item->induk_jantan, 20) }}
                </p>
                <p class="text-xs font-semibold">
                    @php
                        $status = $item->status_review;
                        $badgeClass = match($status) {
                            'approved' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            'banding' => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-gray-200 text-gray-700',
                        };
                    @endphp
                    <span class="px-2 py-1 rounded text-xs {{ $badgeClass }}">
                        {{ ucfirst($status) }}
                    </span>
                </p>
            </div>
@endforeach
        
        <tbody style="display: none;">
    


<!-- Modal Popout Foto -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
    <div class="relative">
        <button onclick="closeImageModal()" class="absolute -top-6 -right-6 md:top-0 md:right-0 bg-gray-800 text-white rounded-full p-2 hover:bg-red-600 shadow-lg z-50" style="right: -2rem; top: -2rem;">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" class="max-w-xs md:max-w-lg max-h-[80vh] rounded shadow-lg border-4 border-white" alt="Zoom Foto Tanaman">
    </div>
</div>
<script>
    function showImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    }
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('modalImage').src = '';
    }
    // Close modal on ESC
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') closeImageModal();
    });
</script>
