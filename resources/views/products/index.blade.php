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
    <div>
        
    </div>


    {{-- Icon Navigation overlap bawah banner --}}
    <div class="nav-overlap z-10 p-4 relative mx-auto max-w-lg">
    
    {{-- Search Bar --}}
    <div class="search-bar mb-2 shadow-lg mx-auto max-w-3xl rounded-lg">
        <form action="{{ route('search') }}" method="GET" class="flex items-center justify-center gap-2">
            <input type="text" name="query" class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search..." required>
            <button type="submit" class="bg-blue-700 border hover:bg-blue-700 text-white px-6 py-2 rounded-r-md font-medium transition duration-200">
                Search
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-md p-3 max-w-3xl mx-auto relative">
    <div class="flex items-center gap-3 flex-nowrap overflow-x-auto scrollbar-hide scroll-smooth">

        {{-- All --}}
        <a href="{{ route('plant-submissions.index') }}"
            class="relative flex items-center gap-2 px-4 py-2 rounded-full text-xs font-medium shadow-sm transition
            {{ request()->routeIs('plant-submissions.index')
                    ? 'bg-gray-200 text-gray-800 ring-2 ring-gray-400'
                    : 'bg-green-50 text-gray-600 hover:bg-green-100'
            }}">
                All
        </a>

        {{-- Approved --}}
        <a href="{{ route('plant-submissions.index', ['status' => 'approved']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-full
           bg-green-50 text-green-600 hover:bg-green-100 transition text-xs font-medium shadow-sm">

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
           bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition text-xs font-medium shadow-sm">

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
            bg-blue-50 text-blue-600 hover:bg-blue-100 transition text-xs font-medium shadow-sm"> 
 
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
           bg-red-50 text-red-500 hover:bg-red-100 transition text-xs font-medium shadow-sm">

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
           bg-gray-100 text-indigo-600 hover:bg-indigo-100 transition text-xs font-medium shadow-sm">

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

<section class="w-full mx-auto max-w-lg">

    {{-- New Hybrids --}}
    <div class="container mx-auto max-w-lg p-4 bg-white border-t  mt-8">
    <div class="flex items-center justify-between mb-2">
    <h1 class="border-l-4 border-double border-sky-500 pl-4 italic leading-tight">
        <span class="block text-sm text-gray-800">NEW PLANTS & HYBRIDS</span>
        <span class="block text-xs text-gray-400 italic">cultivar registration & history</span>
    </h1>
</div>

        <div class="overflow-x-auto">
            <table id="plants-table" class="min-w-full mt-2">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs border-b border-t border-gray-300 ">
                        <th class="p-2 border-l ">Photo</th>
                        <th class="p-2 border-l-4 border-double">ID</th>
                        <th class="p-2 border-l-4 border-double">Parent <i class='fas fa-venus text-red-600'></i></th>
                        <th class="p-2 border-l-4 border-double">✕</th>
                        <th class="p-2 border-l-4 border-double">Parent <i class='fas fa-mars text-blue-600'></i></th>
                    </tr>
                </thead>
                <tbody id="plants-tbody">
                    @foreach($approvedPlants as $item)
                        @if(($item->induk_betina && $item->induk_jantan) && $item->induk_betina !== '' && $item->induk_jantan !== '')
                    <tr class="border-b hover:bg-gray-100 text-xs" onclick="window.location='{{ route('plant-submissions.show', $item) }}'">
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
                        <img src="{{ asset('storage/'.$first) }}" alt="Foto Tanaman" class="w-12 h-12 object-cover rounded cursor-pointer border border-gray-300 hover:shadow-lg transition">
                        @else
                        <div class="w-12 h-12 flex items-center justify-center rounded border border-gray-300 bg-gray-100
                                    text-[10px] text-xxxs leading-none text-gray-500 text-center whitespace-nowrap">
                            No Image
                        </div>
                        @endif
                        </td>
                        <td class="p-2 align-top text-xs" >
                            <a href="{{ route('plant-submissions.show', $item) }}" class="text-gray-800 hover:underline italic">{{ \Illuminate\Support\Str::words($item->plant_id, 3, '..') }}</a>

                            <div class=" md:block text-xs text-gray-500 mt-1">
                                <span class="inline-flex items-center mr-4">
                                    @if($item->penyilang)
                                        <span class="italic text-gray-400 text-xs">Breeder : {{ $item->penyilang }}</span>
                                    @else
                                        <span class="italic text-gray-400 my-1 text-xxxs"> No breeder, 
                                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $item->uploader_id))
                                            <a href="{{ route('plant-submissions.edit', $item) }}" class="text-red-400 underline">Add</a>
                                        @elseif(Auth::check())
                                            <a href="{{ route('plant-submissions.appeal.create', $item) }}" class="text-red-400 underline"> Appeal</a>
                                        @else
                                            <a href="{{ route('login') }}" class="text-red-400 underline"> Appeal</a>
                                        @endif
                                        </span>
                                    @endif                          
                                </span><br>
                            </div>

                        </td>
                        <td class="p-2"><span class="rounded text-xs bg-red-200 text-red-900 italic">{{ $item->induk_betina }} </span></td>
                        <td class="p-2">✕</td>
                        <td class="p-2"><span class="rounded text-xs bg-blue-200 text-blue-900 italic"> {{ $item->induk_jantan }}</span></td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Load More Sentinel --}}
         
        <div id="load-more" class="text-center py-4">
            <div id="loading-spinner" class="hidden">
                <i class="fas fa-spinner fa-spin text-gray-500"></i> Loading more...
            </div>
            <div id="no-more" class="hidden text-gray-500">No more plants</div>
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

            // Intersection Observer
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
                noMoreElement.classList.add('hidden');

                const nextPage = currentPage + 1;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`{{ route('products.index') }}?page=${nextPage}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newTbody = doc.querySelector('#plants-tbody');
                    if (newTbody && newTbody.innerHTML.trim() !== '') {
                        document.querySelector('#plants-tbody').insertAdjacentHTML('beforeend', newTbody.innerHTML);
                        currentPage = nextPage;
                    } else {
                        hasMorePages = false;
                        noMoreElement.classList.remove('hidden');
                    }

                    loadingSpinner.classList.add('hidden');
                    isLoading = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingSpinner.classList.add('hidden');
                    isLoading = false;
                });
            }
        });
    </script>

            </a>
        </div>
    </div>
        </div>
    </div>
</section>



<div class="container mx-auto my-8">

    


</div>
@endsection