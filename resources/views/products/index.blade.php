@extends('layouts.app')

@section('content')

<!-- Banner -->
@if (isset($settings) && $settings->banner)
<div class="w-full h-48 bg-cover bg-no-repeat bg-center flex flex-col justify-center items-center relative" 
    style="background-image: url('{{ Storage::url($settings->banner) }}')">
@else
<div class="w-full h-48 bg-cover bg-no-repeat bg-center flex flex-col justify-center items-center relative" 
    style="background-image: url('{{ asset('/storage/banners/banner.jpg') }}')">
@endif
   

{{-- Icon Navigation overlap bawah banner --}}
<div class="nav-overlap z-10 p-4 relative mx-auto ">
    
    {{-- Search Bar --}}
    <div class="search-bar mb-2 shadow-lg mx-auto max-w-3xl rounded-lg">
        <form action="{{ route('search') }}" method="GET" class="flex items-center justify-center gap-2">
            <input type="text" name="query" class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search here.." required>
            <button type="submit" class="bg-gray-800 border hover:bg-gray-700 text-white px-6 py-2 rounded-r-md font-medium transition duration-200">
                Search
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-md p-3 max-w-3xl mx-auto relative">
        <div class="flex items-center gap-3 flex-nowrap overflow-x-auto scrollbar-hide scroll-smooth">

        {{-- All --}}
        <a href="{{ route('plant-submissions.index') }}"
            class="relative flex items-center gap-2 px-4 py-2 rounded-full text-xs md:text-sm font-medium shadow-sm transition
            {{ request()->routeIs('plant-submissions.index')
                    ? 'bg-gray-200 text-gray-800 ring-2 ring-gray-400'
                    : 'bg-green-50 text-gray-600 hover:bg-green-100'
            }}">
                All
        </a>

        {{-- Approved --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'approved']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-full
           bg-green-50 text-green-600 hover:bg-green-100 transition text-xs md:text-sm font-medium shadow-sm">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9"/>
                <path d="M8 12l3 3 5-5"/>
            </svg>
            Approved

            @auth
                @if(($counts['approved'] ?? 0) > 0)
                <span class="min-w-[16px] h-4 px-1
                    flex items-center justify-center rounded-full bg-green-600 text-white
                    text-[10px] font-semibold leading-none">
                    {{ $counts['approved'] }}
                </span>
                @endif
            @endauth
        </a>

        {{-- Pending --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'pending']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-full
           bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition text-xs md:text-sm font-medium shadow-sm">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 7v5l3 2"/>
            </svg>
            Pending
            @auth
                @if(($counts['pending'] ?? 0) > 0)
                <span class="min-w-[16px] h-4 px-1
                    flex items-center justify-center rounded-full bg-yellow-500 text-white
                    text-[10px] font-semibold leading-none">
                    {{ $counts['pending'] ?? 0 }}
                </span>
                @endif
            @endauth
        </a>

       {{-- Revision --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'revision']) }}" 
            class="relative flex items-center gap-2 px-4 py-2 rounded-full 
            bg-blue-50 text-blue-600 hover:bg-blue-100 transition text-xs md:text-sm font-medium shadow-sm"> 
 
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"> 
                <path d="M4 20h4l10-10-4-4L4 16v4z"/> <path d="M14 6l4 4"/> 
            </svg> 
            Revisions 

            @auth
                @if(($counts['revision'] ?? 0) > 0)
                <span class="min-w-[16px] h-4 px-1 
                flex items-center justify-center rounded-full bg-blue-600 text-white 
                text-[10px] font-semibold leading-none">
                {{ $counts['revision'] ?? 0 }}
                </span> 
                @endif
            @endauth
        </a>

        {{-- Reject --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'rejected']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-full
           bg-red-50 text-red-500 hover:bg-red-100 transition text-xs md:text-sm font-medium shadow-sm">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9"/>
                <path d="M9 9l6 6M15 9l-6 6"/>
            </svg>
            Rejected

             @auth
                @if(($counts['rejected'] ?? 0) > 0)
                <span class="min-w-[16px] h-4 px-1
                    flex items-center justify-center rounded-full bg-red-600 text-white
                    text-[10px] font-semibold leading-none">
                    {{ $counts['rejected'] ?? 0 }}
                </span>
                @endif
            @endauth
        </a>

        {{-- Appeal --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'appeal']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-full
           bg-gray-100 text-indigo-600 hover:bg-indigo-100 transition text-xs md:text-sm font-medium shadow-sm">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 3v18"/>
                <path d="M5 7h14"/>
                <path d="M7 7l-3 6h6l-3-6z"/>
                <path d="M17 7l-3 6h6l-3-6z"/>
            </svg>
            Appeal

             @auth
                @if(($counts['appeal'] ?? 0) > 0)
                <span class="min-w-[16px] h-4 px-1
                    flex items-center justify-center rounded-full bg-indigo-500 text-white
                    text-[10px] font-semibold leading-none">
                    {{ $counts['appeal'] ?? 0 }}
                </span>
                @endif
            @endauth
        </a>

    </div>
</div>


    </div>
</div>


<section class="w-full mx-auto">
    <div class="container mx-auto px-4 mt-8">
        <div class="flex flex-col md:flex-row gap-6 border-b border-gray-200">
            
            {{-- KOLOM KIRI (75% / md:col-span-9) --}}
            <div class="w-full md:w-3/4 bg-white p-4 border-t">
                <div class="flex items-center justify-between mb-2">
                    <h1 class="border-l-4 border-double border-sky-500 pl-4 italic leading-tight">
                        <span class="block text-sm md:text-lg text-gray-800 font-bold">Latest Plants & Hybrids</span>
                        <span class="block text-xs md:text-sm text-gray-400 italic">cultivar registration & history</span>
                    </h1>
                </div>

                <div class="overflow-x-auto">
                    <table id="plants-table" class="min-w-full mt-2 table-fixed">
                        <colgroup>
                            <col style="width:10%">
                            <col style="width:40%">
                            <col style="width:25%">
                            <col style="width:25%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs border-b border-t border-gray-300 md:text-sm">
                                <th class="p-2 border-l">Photo</th>
                                <th class="p-2 border-l-4 border-double">Plant ID</th>
                                <th class="p-2 border-l-4 border-double">S. Parent <i class='fas fa-venus text-red-600'></i></th>
                                <th class="p-2 border-l-4 border-double">P. Parent <i class='fas fa-mars text-blue-600'></i></th>
                            </tr>
                        </thead>
                        <tbody id="plants-tbody">
                            @foreach($approvedPlants as $item)
                                @if(($item->induk_betina && $item->induk_jantan) && $item->induk_betina !== '' && $item->induk_jantan !== '')
                                <tr class="border-b hover:bg-gray-100 text-xs cursor-pointer" onclick="window.location='{{ route('plant-submissions.show', $item) }}'">
                                    <td class="p-2">
                                        {{-- Logika Image --}}
                                        @php
                                            $images = [];
                                            if ($item->image) {
                                                $decoded = json_decode($item->image, true);
                                                $images = is_array($decoded) ? $decoded : [$item->image];
                                            }
                                            $first = count($images) ? $images[0] : null;
                                        @endphp
                                        @if($first)
                                            <img src="{{ asset('storage/'.$first) }}" alt="Foto" class="w-12 h-12 object-cover rounded border border-gray-300">
                                        @else
                                            <div class="w-12 h-12 flex items-center justify-center rounded border border-gray-300 bg-gray-100 text-xxxs text-gray-500">No Image</div>
                                        @endif
                                    </td>
                                    <td class="p-2 align-top">
                                        <span class="text-gray-800 italic font-medium md:text-sm">{{ \Illuminate\Support\Str::words($item->plant_id, 3, '..') }}</span>
                                        @if($item->plant_id_var == 0)
                                            <span class="block text-[10px] md:text-sm mt-1 text-green-700 font-bold">Variegated</span>
                                        @endif
                                        <div class="text-[10px] md:text-sm text-gray-400 mt-1 italic">
                                            Breeder: {{ $item->penyilang ?? 'Unknown' }}
                                        </div>
                                    </td>
                                    <td class="p-2 italic text-gray-700 text-xs md:text-sm">{{ $item->induk_betina }}</td>
                                    <td class="p-2 italic text-gray-700 text-xs md:text-sm">{{ $item->induk_jantan }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Indikator Load More --}}
                <div id="load-more" class="text-center py-4">
                    <div id="loading-spinner" class="hidden">
                        <i class="fas fa-spinner fa-spin text-gray-500"></i> Loading...
                    </div>
                    <div id="no-more" class="hidden text-gray-500 text-xs">No more plants</div>
                </div>

            </div> 
            
            @include('partials.sidebar-dekstop')

        </div>
    </div>
</section>

{{-- MODAL (Taruh di luar kontainer grid) --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
    <div class="relative">
        <button onclick="closeImageModal()" class="absolute -top-10 -right-10 text-white text-2xl">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" class="max-w-md max-h-[80vh] rounded shadow-lg border-4 border-white">
    </div>
</div>


   {{-- Modal popuout foto tanaman --}}
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

    <script>
document.addEventListener('DOMContentLoaded', function() {

    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = true;

    const loadMoreElement = document.getElementById('load-more');
    const loadingSpinner = document.getElementById('loading-spinner');
    const noMoreElement = document.getElementById('no-more');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && hasMorePages && !isLoading) {
                loadNextPage();
            }
        });
    }, {
        rootMargin: '100px'
    });

    observer.observe(loadMoreElement);

    function loadNextPage() {

        if (isLoading || !hasMorePages) return;

        isLoading = true;
        loadingSpinner.classList.remove('hidden');

        const nextPage = currentPage + 1;

        fetch(`{{ route('plants.load-more') }}?page=${nextPage}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {

            if (data.html.trim() !== '') {

                document.querySelector('#plants-tbody')
                    .insertAdjacentHTML('beforeend', data.html);

                currentPage = nextPage;
                hasMorePages = data.hasMorePages;

            }

            if (!data.hasMorePages) {
                noMoreElement.classList.remove('hidden');
            }

            loadingSpinner.classList.add('hidden');
            isLoading = false;
        })
        .catch(error => {
            console.error(error);
            loadingSpinner.classList.add('hidden');
            isLoading = false;
        });
    }

});
</script>

           

@endsection