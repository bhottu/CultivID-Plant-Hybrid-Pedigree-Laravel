@extends('admin.layout')

@section('content')
    <div class="container mx-auto px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-semibold">PlantDB</h1>
            <a href="{{ route('plant-submissions.create') }}" class="bg-gray-800 text-white px-4 py-2 text-sm rounded hover:bg-gray-900 transition">+ Tambah</a>
        </div>

        @if($submissions->count())
            @php
                $showStatusHeader = false;
                if(Auth::check() && Auth::user()->is_admin) {
                    $showStatusHeader = true;
                } elseif(Auth::check()) {
                    foreach($submissions as $itemCheck) {
                        if(Auth::id() === $itemCheck->uploader_id) {
                            $showStatusHeader = true;
                            break;
                        }
                    }
                }
            @endphp
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-200 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">ID Tanaman</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Induk Betina</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">&times;</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Induk Jantan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Penyilang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Pengirim</th>
                            @if($showStatusHeader)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Status</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $item)
                       
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">
                                    @if($item->image)
                                        <img src="{{ asset('storage/'.$item->image) }}" alt="Foto" class="w-12 h-12 object-cover rounded cursor-pointer" onclick="showImageModal('{{ asset('storage/'.$item->image) }}')">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $item->plant_id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $item->induk_betina }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200 text-center">&#10005;</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $item->induk_jantan }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $item->penyilang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $item->uploader->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">
                                    <span class="px-2 py-1 rounded text-xs {{ $item->status_review == 'approved' ? 'bg-green-100 text-green-900' : ($item->status_review == 'rejected' ? 'bg-red-100 text-gray-900' : ($item->status_review == 'banding' ? 'bg-yellow-900 text-yellow-100' : 'bg-gray-200 text-gray-900')) }}">{{ ucfirst($item->status_review) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 border-b border-gray-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.plant-submissions.show', $item) }}" class="text-gray-600 hover:text-blue-700 p-2 rounded hover:bg-gray-100" title="Lihat Detil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(Auth::user() && (Auth::user()->is_admin || Auth::id() === $item->uploader_id))
                                                <a href="{{ route('admin.plant-submissions.edit', $item) }}" class="text-gray-600 hover:text-blue-900 p-2 rounded hover:bg-gray-100" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('plant-submissions.appeal.create', $item) }}" class="text-yellow-700 hover:underline">Banding</a>
                                            @endif
                                        </div>
                                        @can('review', $item)
                                        <form action="{{ route('admin.plant-submissions.review', $item) }}" method="POST" class="inline-flex items-center space-x-2">
                                            @csrf
                                            @if($item->status_review == 'approved')
                                                <button type="submit" name="status_review" value="rejected" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded" title="Nonaktifkan">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @else
                                                <button type="submit" name="status_review" value="approved" class="text-green-600 bg-green-50 hover:bg-green-100 p-2 rounded" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="submit" name="status_review" value="rejected" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $submissions->links() }}
            </div>
        @else
            <p class="mt-4">Tidak ada tanaman yang ditemukan.</p>
        @endif
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
        document.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') closeImageModal();
        });
    </script>
@endsection
