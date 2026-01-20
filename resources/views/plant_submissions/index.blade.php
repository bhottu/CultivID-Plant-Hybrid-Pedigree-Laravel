@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white rounded shadow max-w-lg">
    <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold text-green-900">New Hybrids</h1>

    <a href="{{ route('plant-submissions.create') }}"
       class="bg-gray-800 text-white px-4 py-2 text-xs rounded hover:bg-gray-900 transition">
        Add Hybrid
    </a>
</div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="min-w-full mt-2 text-xs">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs border-b border-t border-gray-300">
                    <th class="p-2 border-l">Foto</th>
                    <th class="p-2 border-l-4 border-double">ID Tanaman</th>
                    <th class="p-2 border-l-4 border-double">Induk <i class='fas fa-venus text-red-600'></i></th>
                    <th class="p-2 border-l-4 border-double">Induk <i class='fas fa-mars text-red-600'></i></th>
                    {{-- Kolom Status hanya untuk admin atau uploader (per baris) --}}
                    @php
                        $showStatusHeader = false;
                        if(Auth::check() && Auth::user()->is_admin) {
                            $showStatusHeader = true;
                        } elseif(Auth::check()) {
                            foreach($submissions as $item) {
                                if(Auth::id() === $item->uploader_id) {
                                    $showStatusHeader = true;
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $item)
                    @if(($item->induk_betina && $item->induk_jantan) && $item->induk_betina !== '' && $item->induk_jantan !== '')
                <tr class="border-b hover:bg-gray-100">
                    <td class="p-2">
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
                        <img src="{{ asset('storage/'.$first) }}" alt="Foto Tanaman" class="w-12 h-12 object-cover rounded cursor-pointer border border-gray-300 hover:shadow-lg transition" onclick="showImageModal('{{ asset('storage/'.$first) }}')">
                        @else
                        <span class="text-gray-400">-</span>
                        @endif

                        <!-- Status Badge -->
                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $item->uploader_id))
                       
                            @php
                                $status = $item->status_review;
                                $badgeClass = match($status) {
                                    'approved' => 'bg-green-200 text-green-900',
                                    'rejected' => 'bg-red-200 text-red-900',
                                    'banding' => 'bg-yellow-900 text-yellow-100',
                                    default => 'bg-gray-200 text-gray-900',
                                };
                            @endphp
                            <span class="px-2 py-1 rounded text-xs {{ $badgeClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        
                        @endif
                        <!-- Status Badge -->
                    </td>

                    <td class="p-2">
                         <a href="{{ route('plant-submissions.show', $item) }}" class="text-gray-700 hover:text-blue-700" title="Lihat Detil">
                                 <span class="font-bold">{{ $item->plant_id }}</span>
                            </a>
                       <br>
                       Breeder <i class="fas fa-dna text-green-600 mr-1"></i> {{ $item->penyilang }}<br>
                       Uploader <i class="fa-solid fa-upload text-blue-600 mr-1"></i> {{ $item->uploader->name ?? '-' }}
                    </td>


                    <td class="p-2">
                        @php
                            $betina = App\Models\PlantSubmission::where('plant_id', $item->induk_betina)->first();
                        @endphp
                        @if($item->induk_betina && $betina)
                         <span class="rounded text-xs bg-blue-200 text-blue-900">  {{ $item->induk_betina }} </span>
                        @endif

                    </td>
                    
                    
                    
                    <td class="p-2">
                         @php
                            $jantan = App\Models\PlantSubmission::where('plant_id', $item->induk_jantan)->first();
                        @endphp
                        @if($item->induk_jantan && $jantan)
                            <span class="rounded text-xs bg-red-200 text-red-900"> {{ $item->induk_jantan }} </span>
                        @endif
                    </td>
                    
                    <td class="p-2">
                        <div class="flex flex-row items-center space-x-2">
                            
                            @if(Auth::user() && (Auth::user()->is_admin || Auth::id() === $item->uploader_id))
                                <a href="{{ route('plant-submissions.edit', $item) }}" class="text-blue-700 hover:text-blue-900" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                            @else
                                <a href="{{ route('plant-submissions.appeal.create', $item) }}" class="text-yellow-700 hover:underline">Banding</a>
                            @endif
                        </div>
                        @can('review', $item)
                        <form action="{{ route('plant-submissions.review', $item) }}" method="POST" class="inline">
                            @csrf
                            @if($item->status_review == 'approved')
                                <button name="status_review" value="rejected" class="text-gray-400 ml-2 cursor-not-allowed" disabled>Reject</button>
                                <button name="status_review" value="rejected" class="text-red-700 ml-2">Nonaktifkan</button>
                            @else
                                <button name="status_review" value="approved" class="text-green-700 ml-2">Approve</button>
                                <button name="status_review" value="rejected" class="text-red-700 ml-2">Reject</button>
                            @endif
                        </form>
                        @endcan
                    </td>
                </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $submissions->links() }}</div>
</div>
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
@endsection
