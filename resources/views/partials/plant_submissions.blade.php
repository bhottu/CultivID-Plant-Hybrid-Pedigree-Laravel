
   
@foreach($plantSubmissions as $item)
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

        $status = $item->status_review;
        $badgeClass = match($status) {
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            'banding'  => 'bg-yellow-100 text-yellow-700',
            default    => 'bg-gray-200 text-gray-700',
        };
    @endphp

    {{-- Container utama menggunakan flex agar gambar dan teks sejajar --}}
    <div class="flex items-center bg-white p-2 border-b border-gray-100 hover:bg-gray-50 transition-all w-full text-left">
        
        <div class="flex-shrink-0 mr-4" style="width: 56px; height: 56px;">
            <div class="relative w-14 h-14 rounded-lg overflow-hidden border border-gray-200 shadow-sm" >
                @if($first)
                    <img onclick="showImageModal('{{ $first ? asset('storage/'.$first) : '' }}')" src="{{ asset('storage/'.$first) }}" alt="Foto Tanaman"  style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-xxxs text-gray-400">
                        No Image
                    </div>
                @endif
            </div>
        </div>

        <div class="flex-grow min-w-0 text-left" onclick="{{ route('plant-submissions.show', $item->plant_id) }}">
            <a href="{{ route('plant-submissions.show', $item->plant_id) }}" class="block">
                <h4 class="text-xs font-bold text-gray-600 hover:underline italic truncate leading-tight">
                    {{ \Illuminate\Support\Str::limit($item->plant_id, 35) }}
                </h4>
            </a>
            
            <div class="mt-1 space-y-0.5">
                <p class="text-xs text-gray-600 flex items-center italic truncate">
                    <span class="w-4"><i class="fas fa-venus text-red-500"></i></span>
                    {{ \Illuminate\Support\Str::limit($item->induk_betina, 30) }}
                </p>
                <p class="text-xs text-gray-600 flex items-center italic truncate">
                    <span class="w-4"><i class="fas fa-mars text-blue-500"></i></span>
                    {{ \Illuminate\Support\Str::limit($item->induk_jantan, 30) }}
                </p>
            </div>
        </div>

        <div class="flex-shrink-0 ml-auto pl-2">
            <span class="px-2 py-1 rounded-md text-xs {{ $badgeClass }}  tracking-tighter">
                {{ $status }}
            </span>
        </div>

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
