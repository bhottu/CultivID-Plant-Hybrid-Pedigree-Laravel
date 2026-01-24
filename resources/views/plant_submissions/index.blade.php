@extends('layouts.app')

@section('content')

@php
    $activeStatus = request('status') ?? 'pending';
@endphp

 {{-- Status Badge --}}
<div class="container mx-auto p-4 bg-white rounded shadow max-w-lg">
    <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold text-green-900">My Submissions</h1>
</div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    
    <div class="overflow-x-auto">
        
        
    <div class="flex items-center gap-3 flex-nowrap overflow-x-auto scrollbar-hide scroll-smooth">

        {{-- Approved --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'approved']) }}"
   class="relative flex items-center gap-2 px-4 py-2 rounded-full
   {{ $activeStatus === 'approved'
        ? 'bg-gray-200 text-green-800 ring-2 ring-green-400'
        : 'bg-green-50 text-green-600 hover:bg-green-100'
   }}
   transition text-xs font-medium shadow-sm">

    @if(($counts['approved'] ?? 0) > 0)
        <span class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 rounded-full bg-green-600"></span>
    @endif

    <span class="absolute -top-2 -right-1 min-w-[16px] h-4 px-1 flex items-center justify-center rounded-full bg-green-600 
    text-white text-[10px] font-semibold leading-none"> {{ $counts['approved'] ?? 0 }} </span>

    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="9"/>
        <path d="M8 12l3 3 5-5"/>
    </svg>
    Approved
</a>


         {{-- Pending --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'pending']) }}"
   class="relative flex items-center gap-2 px-4 py-2 rounded-full
   {{ $activeStatus === 'pending'
        ? 'bg-gray-200 text-yellow-800 ring-2 ring-yellow-400'
        : 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100'
   }}
   transition text-xs font-medium shadow-sm">

    @if(($counts['pending'] ?? 0) > 0)
        <span class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
    @endif

    <span class="absolute -top-2 -right-1 min-w-[16px] h-4 px-1 flex items-center justify-center rounded-full bg-yellow-500 
    text-white text-[10px] font-semibold leading-none"> 
    {{ $counts['pending'] ?? 0 }} 
    </span>

    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="9"/>
        <path d="M12 7v5l3 2"/>
    </svg>
    Pending
</a>


        {{-- Revisions --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'revision']) }}"
   class="relative flex items-center gap-2 px-4 py-2 rounded-full
   {{ $activeStatus === 'revision'
        ? 'bg-gray-200 text-blue-800 ring-2 ring-blue-400'
        : 'bg-blue-50 text-blue-600 hover:bg-blue-100'
   }}
   transition text-xs font-medium shadow-sm">

    @if(($counts['revision'] ?? 0) > 0)
        <span class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 rounded-full bg-blue-600"></span>
    @endif

    <span class="absolute -top-2 -right-1 min-w-[16px] h-4 px-1 flex items-center justify-center rounded-full bg-blue-600 
    text-white text-[10px] font-semibold leading-none"> 
    {{ $counts['revision'] ?? 0 }} 
    </span>

    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M4 20h4l10-10-4-4L4 16v4z"/>
        <path d="M14 6l4 4"/>
    </svg>
    Revision
</a>


          {{-- Reject --}}
       <a href="{{ route('plant-submissions.index', ['status' => 'rejected']) }}"
   class="relative flex items-center gap-2 px-4 py-2 rounded-full
   {{ $activeStatus === 'rejected'
        ? 'bg-gray-200 text-red-800 ring-2 ring-red-400'
        : 'bg-red-50 text-red-500 hover:bg-red-100'
   }}
   transition text-xs font-medium shadow-sm">

    @if(($counts['rejected'] ?? 0) > 0)
        <span class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 rounded-full bg-red-600"></span>
    @endif

    <span class="absolute -top-2 -right-1 min-w-[16px] h-4 px-1 flex items-center justify-center rounded-full bg-red-600 
    text-white text-[10px] font-semibold leading-none"> 
    {{ $counts['rejected'] ?? 0 }} 
    </span>

    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="9"/>
        <path d="M9 9l6 6M15 9l-6 6"/>
    </svg>
    Reject
</a>


        {{-- Appeal --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'appeal']) }}"
   class="relative flex items-center gap-2 px-4 py-2 rounded-full
   {{ $activeStatus === 'appeal'
        ? 'bg-gray-200 text-indigo-800 ring-2 ring-indigo-400'
        : 'bg-gray-100 text-indigo-600 hover:bg-indigo-100'
   }}
   transition text-xs font-medium shadow-sm">

    @if(($counts['appeal'] ?? 0) > 0)
        <span class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 rounded-full bg-gray-700"></span>
    @endif

    <span class="absolute -top-2 -right-1 min-w-[16px] h-4 px-1 flex items-center justify-center rounded-full bg-indigo-500 
    text-white text-[10px] font-semibold leading-none"> 
    {{ $counts['appeal'] ?? 0 }} 
    </span>

    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 3v18"/>
        <path d="M5 7h14"/>
        <path d="M7 7l-3 6h6l-3-6z"/>
        <path d="M17 7l-3 6h6l-3-6z"/>
    </svg>
    Appeal
</a>



</div>

        <table class="min-w-full mt-2 text-xs">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs border-b border-t border-gray-300">
                    <th class="p-2 border-l">Photo</th>
                    <th class="p-2 border-l-4 border-double">ID</th>
                    <th class="p-2 border-l-4 border-double">Parent <i class='fas fa-venus text-red-600'></i></th>
                    <th class="p-2 border-l-4 border-double">Parent <i class='fas fa-mars text-blue-600'></i></th>
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
                    
                    <th class="p-2">Edit</th>
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

                        $status = $item->status_review;
                        $badgeClass = match($status) {
                            'approved' => 'bg-green-600 text-white text-xxxs',
                            'rejected' => 'bg-red-600 text-white',
                            'banding'  => 'bg-yellow-600 text-white',
                            default    => 'bg-gray-600 text-white',
                        };
                    @endphp

                    <div class="relative w-12">
                        @if($first)
                            <img src="{{ asset('storage/'.$first) }}"
                                alt="Foto Tanaman"
                                class="w-12 h-12 object-cover rounded border border-gray-300 cursor-pointer"
                                onclick="showImageModal('{{ asset('storage/'.$first) }}')">
                        @else
                            <div class="w-12 h-12 flex items-center justify-center rounded border border-gray-300 bg-gray-100
                                        text-xxxs leading-tight text-gray-500 text-center">
                                No Image
                            </div>
                        @endif

                        {{-- Status Badge --}}
                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $item->uploader_id))
                            <span class="absolute bottom-0 left-0 w-full rounded-b text-[9px] text-xxxs text-center {{ $badgeClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        @endif
                    </div>
                </td>


                    <td class="p-2"  onclick="window.location='{{ route('plant-submissions.show', $item) }}'">
                        <a href="{{ route('plant-submissions.show', $item) }}" class="text-gray-700 hover:text-blue-700" title="Lihat Detil">
                            <span class="text-gray-800 hover:underline italic">{{ $item->plant_id }}</span>
                        </a>
                            <div class=" md:block text-xs text-gray-500 mt-1">
                                <span class="inline-flex items-center mr-4">
                                    @if($item->penyilang)
                                        <span class="italic text-gray-400 text-xs">Breeder : {{ $item->penyilang }}</span>
                                    @else
                                        <span class="italic text-gray-400 my-1"> No breeder, 
                                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $item->uploader_id))
                                            <a href="{{ route('plant-submissions.edit', $item) }}" class="text-xs text-red-400 underline">Add</a>
                                        @elseif(Auth::check())
                                            <a href="{{ route('plant-submissions.appeal.create', $item) }}" class="text-xs text-red-400 underline"> Appeal</a>
                                        @else
                                            <a href="{{ route('login') }}" class="text-xs text-red-400 underline"> Appeal</a>
                                        @endif
                                        </span>
                                    @endif                          
                                </span><br>
                            </div>
                    </td>


                    <td class="p-2">
                        @php
                            $betina = App\Models\PlantSubmission::where('plant_id', $item->induk_betina)->first();
                        @endphp
                        @if($item->induk_betina && $betina)
                         <span class="rounded text-xs bg-red-200 text-red-900 italic">  {{ $item->induk_betina }} </span>
                        @endif

                    </td>
                    
                    
                    
                    <td class="p-2">
                         @php
                            $jantan = App\Models\PlantSubmission::where('plant_id', $item->induk_jantan)->first();
                        @endphp
                        @if($item->induk_jantan && $jantan)
                            <span class="rounded text-xs bg-blue-200 text-red-blue italic"> {{ $item->induk_jantan }} </span>
                        @endif
                    </td>
                    
                    <td class="p-2">
                        <div x-data="{ open: false }">

                             {{-- BUTTON 3 DOT --}}
                            <button @click="open = true"
                                class="p-2 rounded-full hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="#000000" height="200px" width="200px" version="1.1" id="Capa_1" 
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32.055 32.055" 
                                xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> <g> 
                                <path d="M3.968,12.061C1.775,12.061,0,13.835,0,16.027c0,2.192,1.773,3.967,3.968,3.967c2.189,0,3.966-1.772,3.966-3.967 
                                C7.934,13.835,6.157,12.061,3.968,12.061z M16.233,12.061c-2.188,0-3.968,1.773-3.968,3.965c0,2.192,1.778,3.967,3.968,3.967 
                                s3.97-1.772,3.97-3.967C20.201,13.835,18.423,12.061,16.233,12.061z M28.09,12.061c-2.192,0-3.969,1.774-3.969,3.967 
                                c0,2.19,1.774,3.965,3.969,3.965c2.188,0,3.965-1.772,3.965-3.965S30.278,12.061,28.09,12.061z"></path> </g> </g></svg>
                            </button>

                            {{-- OVERLAY --}}
                            <div x-show="open"
                                x-transition.opacity
                                x-cloak
                                class="fixed inset-0 bg-black/50 z-40"
                                @click="open = false">
                            </div>

                            {{-- BOTTOM SHEET --}}
                            <div x-show="open"
                                x-transition:enter="transition transform ease-out duration-300"
                                x-transition:enter-start="translate-y-full"
                                x-transition:enter-end="translate-y-0"
                                x-transition:leave="transition transform ease-in duration-200"
                                x-transition:leave-start="translate-y-0"
                                x-transition:leave-end="translate-y-full"
                                class="fixed bottom-0 left-0 right-0 z-50 bg-white rounded-t-2xl shadow-lg">

                                {{-- HANDLE --}}
                                <div class="flex justify-center py-2">
                                    <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
                                </div>

                                <div class="px-4 pb-4 space-y-2 text-sm" x-cloak>

                                    {{-- EDIT / BANDING --}}
                                    @if(Auth::user() && (Auth::user()->is_admin || Auth::id() === $item->uploader_id))
                                        <a href="{{ route('plant-submissions.edit', $item) }}"
                                        class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-purple-50 to-purple-100 hover:shadow-lg">
                                            ✏️ <span>Edit</span>
                                        </a>
                                    @else
                                        <a href="{{ route('plant-submissions.appeal.create', $item) }}"
                                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 text-yellow-700 bg-gradient-to-r from-purple-50 to-purple-100 hover:shadow-lg">
                                            ⚖️ <span>Banding</span>
                                        </a>
                                    @endif

                                    @can('review', $item)
                                        <hr>

                                        <form action="{{ route('plant-submissions.review', $item) }}" method="POST">
                                            @csrf

                                            @if($item->status_review == 'approved')
                                                <button disabled
                                                    class="w-full flex items-center gap-3 p-3 rounded-lg text-gray-400 cursor-not-allowed bg-gradient-to-r from-purple-50 to-purple-100 hover:shadow-lg">
                                                    ❌ <span>Reject</span>
                                                </button>

                                                <button name="status_review" value="rejected"
                                                    class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-red-50 text-red-600 bg-gradient-to-r from-purple-50 to-purple-100 hover:shadow-lg">
                                                    🚫 <span>Nonaktifkan</span>
                                                </button>
                                            @else
                                                <button name="status_review" value="approved"
                                                    class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 text-green-600 bg-gradient-to-r from-purple-50 to-purple-100 hover:shadow-lg">
                                                    ✅ <span>Approve</span>
                                                </button>

                                                <button name="status_review" value="rejected"
                                                    class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-red-50 text-red-600 bg-gradient-to-r from-purple-50 to-purple-100 hover:shadow-lg">
                                                    ❌ <span>Reject</span>
                                                </button>
                                            @endif
                                        </form>
                                    @endcan

                                    @auth
                                    @if(Auth::user()->is_admin || Auth::id() === $item->uploader_id)
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('plant-submissions.destroy', $item) }}')"
                                        class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 text-red-600 bg-gradient-to-r from-purple-50 to-purple-100 hover:shadow-lg">
                                        🗑️ <span>Delete</span>
                                    </button>
                                    @endif
                                    @endauth

                                    {{-- CLOSE --}}
                                    <button @click="open = false"
                                        class="w-full p-3 rounded-lg bg-gray-100 text-gray-600 mt-2">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>


                </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $submissions->links() }}</div>
</div>
    {{-- Modal Popout Foto --}}
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute -top-6 -right-6 md:top-0 md:right-0 bg-gray-800 text-white rounded-full p-2 hover:bg-red-600 shadow-lg z-50" style="right: -2rem; top: -2rem;">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" class="max-w-xs md:max-w-lg max-h-[80vh] rounded shadow-lg border-4 border-white" alt="Zoom Foto Tanaman">
        </div>
    </div>

    <div id="deleteModal"
     class="fixed inset-0 z-50 hidden bg-black/40 flex items-end">

    <div class="bg-white w-full rounded-t-2xl p-4 animate-slide-up">
        <h3 class="text-lg font-semibold text-gray-800">
            Delete data?
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            This plant data and its photos will be permanently deleted.
        </p>

        <form id="deleteForm" method="POST" class="mt-4">
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="w-full py-3 bg-red-600 text-white rounded-xl font-semibold">
                Delete
            </button>
        </form>

        <button onclick="closeDeleteModal()"
                class="w-full mt-2 py-3 text-gray-600 rounded-xl">
            Cancel
        </button>
    </div>
</div>

    <script>
        function openDeleteModal(url) {
            const form = document.getElementById('deleteForm');
            form.action = url; 
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>


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
