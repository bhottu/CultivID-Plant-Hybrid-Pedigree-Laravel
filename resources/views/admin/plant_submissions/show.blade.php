@extends('admin.layout')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-semibold flex items-center"><i class='fas fa-seedling text-green-600 mr-2'></i> {{ $plantSubmission->plant_id }}</h1>
            <a href="{{ route('admin.plant-submissions.create') }}" class="bg-gray-800 text-white px-4 py-2 text-sm rounded hover:bg-gray-900 transition">+ Tambah</a>
        </div>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-1/3">
            @if($plantSubmission->image)
                <div class="w-full bg-white rounded overflow-hidden border border-gray-200 shadow">
                    <img src="{{ asset('storage/'.$plantSubmission->image) }}" alt="Foto Tanaman" class="w-full h-[200px] object-cover cursor-pointer transition" onclick="showImageModal('{{ asset('storage/'.$plantSubmission->image) }}')">
                </div>
            @else
                <div class="w-full bg-white rounded border border-gray-200 shadow p-4 text-center">
                    <span class="text-gray-400">Tidak ada foto</span>
                </div>
            @endif
        </div>
    <div class="p-4 rounded border border-gray-200 shadow text-sm">
        <div class="md:w-2/3">
            <table class="table-auto text-sm w-full mb-4">
                <tr>
                    <td class="font-semibold pr-2"><i class='far fa-id-card'></i> ID Tanaman</td>
                   <td class="text-italic">: {{ $plantSubmission->plant_id }}</td>
                </tr>
                <tr>
                    <td class="font-semibold pr-2"><i class='fas fa-venus '></i> Induk </td>
                    <td class="text-italic">: {{ $plantSubmission->induk_betina }}</td>
                </tr>
                <tr>
                    <td class="font-semibold pr-2"><i class='fas fa-mars'></i> Induk </td>
                    <td class="text-italic">: {{ $plantSubmission->induk_jantan }}</td>
                </tr>
                <tr>
                    <td class="font-semibold pr-2"><i class="fas fa-dna"></i> Penyilang </td>
                    <td class="text-italic">: {{ $plantSubmission->penyilang }}</td>
                </tr>
                @if($plantSubmission->uploader_id)
                <tr>
                    <td class="font-semibold pr-2"><i class='fas fa-user'></i> Pengupload </td>
                    <td class="text-italic">: {{ $plantSubmission->uploader ? $plantSubmission->uploader->name : '-' }}</td>
                </tr>
                @endif
                @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                <tr>
                    <td class="font-semibold pr-2">Status</td>
                    <td>
                       <span class="px-2 py-1 text-green-700 rounded text-xs {{ $plantSubmission->status_review == 'approved' ? 'bg-green-500 text-green-900' : ($plantSubmission->status_review == 'rejected' ? 'bg-red-500 text-red-900' : ($plantSubmission->status_review == 'banding' ? 'bg-yellow-500 text-yellow-900' : 'bg-gray-500 text-gray-900')) }}">
                           {{ ucfirst($plantSubmission->status_review) }}
                        </span>
                    </td>
                </tr>
                @endif
            </table>
            <div class="flex gap-2 mt-2">
                @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                    <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="bg-gray-800 text-white px-4 py-2 rounded text-sm">Ubah</a>
                @elseif(Auth::check())
                    <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="bg-red-600 text-white px-2 py-1 rounded mb-2 inline-block hover:bg-red-800 transition text-xs">Banding</a>
                @else
                    <a href="{{ route('login') }}" class="bg-white-600 border text-red-600 hover:text-gray-600 px-2 py-1 rounded mb-2 inline-block  transition text-xs">Banding</a>
                @endif
            </div>
        </div>
      </div>
    </div>
        {{-- Silsilah Tanaman (Pedigree) --}}
    @if(isset($pedigree) && $pedigree)
    <div class="mt-8">
        <h2 class="text-md font-bold text-green-900 mb-2">Silsilah Tanaman</h2>
        <div class="p-4 rounded border border-gray-200 shadow text-sm ">
            @include('admin.pedigree.pedigree', ['pedigree' => $pedigree])
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
