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
        <h1 class="text-white text-center xl:text-2xl lg:text-xl mb-4 md:text-lg sm:text-base xs:text-sm font-semibold bg-gray-800 p-2 bg-opacity-40 rounded-sm">
            Plant Database
        </h1>
    </div>


    <!-- Icon Navigation overlap bawah banner -->
    <div class="nav-overlap z-10 p-4 -translate-y-1/2 relative mx-auto max-w-lg">
    
    <!-- Search Bar -->
    <div class="search-bar mb-2 shadow-lg mx-auto max-w-3xl rounded-lg">
        <form action="{{ route('search') }}" method="GET" class="flex items-center justify-center gap-2">
            <input type="text" name="query" class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search..." required>
            <button type="submit" class="bg-blue-700 border hover:bg-blue-700 text-white px-6 py-2 rounded-r-md font-medium transition duration-200">
                Search
            </button>
        </form>
    </div>

        <div class="bg-white rounded-lg shadow-lg p-4 mx-auto max-w-3xl">
            <table class="w-full table-fixed">
                <tr class="text-gray-600 text-center">
                    <!-- Approved -->
                    <td class="py-3 w-16 text-center align-middle">
                        <a href="{{ route('plant-submissions.index') }}" 
                        class="flex flex-col items-center hover:text-gray-800 transition">
                            <svg class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M8 12l3 3 5-5"/>
                            </svg>
                            <span class="text-xs md:text-sm mt-1">Approved</span>
                        </a>
                    </td>

                    <!-- Reject -->
                    <td class="py-3 w-16 text-center align-middle">
                        <a href="{{ route('index.sosmed') }}" 
                        class="flex flex-col items-center hover:text-gray-800 transition">
                            <svg class="w-6 h-6 text-red-400"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M9 9l6 6M15 9l-6 6"/>
                            </svg>

                            <span class="text-xs md:text-sm mt-1">Reject</span>
                        </a>
                    </td>

                    <!-- Pending -->
                    <td class="py-3 w-16 text-center align-middle">
                        <a href="{{ route('plant-submissions.index') }}" 
                        class="flex flex-col items-center hover:text-gray-800 transition">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                            <span class="text-xs md:text-sm mt-1">Pending</span>
                        </a>
                    </td>

                    <!-- Revision -->
                    <td class="py-3 w-16 text-center align-middle">
                        <a href="{{ route('all.products') }}" 
                        class="flex flex-col items-center hover:text-gray-800 transition">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 20h4l10-10-4-4L4 16v4z"/>
                                <path d="M14 6l4 4"/>
                            </svg>
                            <span class="text-xs md:text-sm mt-1">Revision</span>
                        </a>
                    </td>

                    <!-- Appeal -->
                    <td class="py-3 w-16 text-center align-middle">
                        <a href="{{ route('index.sosmed') }}" 
                        class="flex flex-col items-center hover:text-gray-800 transition">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 3v18"/>
                                <path d="M5 7h14"/>
                                <path d="M7 7l-3 6h6l-3-6z"/>
                                <path d="M17 7l-3 6h6l-3-6z"/>
                            </svg>
                            <span class="text-xs md:text-sm mt-1">Appeal</span>
                        </a>
                    </td>

                    
                </tr>
            </table>
        </div>
    </div>
</div>

<section class="w-full mx-auto max-w-lg">

    <!-- New Hybrids -->
    <div class="container mx-auto max-w-lg p-4 bg-white border-t  mt-8">
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-2xl text-sm font-bold border-l-4 border-double border-sky-500 pl-4">NEW HYBRIDS</h1>
        <a href="{{ route('plant-submissions.create') }}" class="ml-4 bg-gray-800 text-white px-3 py-1 rounded shadow hover:bg-blue-700 transition flex items-center" style="font-size: 0.7rem; height:1.5rem; width:1.5rem; min-width:1.5rem; min-height:1.5rem; justify-content:center;" title="Ajukan Hybrid Baru">
            <span class="sr-only">Ajukan Hybrid Baru</span>
            <i class="fas fa-plus text-base"></i>
        </a>
    </div>
        <div class="overflow-x-auto">
            <table id="plants-table" class="min-w-full mt-2">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs border-b border-t border-gray-300 ">
                        <th class="p-2 border-l ">Foto</th>
                        <th class="p-2 border-l-4 border-double">ID</th>
                        <th class="p-2 border-l-4 border-double">Induk <i class='fas fa-venus text-red-600'></i></th>
                        <th class="p-2 border-l-4 border-double">✕</th>
                        <th class="p-2 border-l-4 border-double">Induk <i class='fas fa-mars text-blue-600'></i></th>
                    </tr>
                </thead>
                <tbody id="plants-tbody">
                    @foreach($approvedPlants as $item)
                        @if(($item->induk_betina && $item->induk_jantan) && $item->induk_betina !== '' && $item->induk_jantan !== '')
                    <tr class="border-b hover:bg-gray-100 text-xs">
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
                        </td>
                        <td class="p-2 align-top text-xs">
                            <a href="{{ route('plant-submissions.show', $item) }}" class="text-gray-800 hover:underline font-semibold">{{ \Illuminate\Support\Str::limit($item->plant_id, 20) }}</a>
                            <!-- Mobile only: Penyilang & Pengirim di bawah ID -->
                            <div class="block md:hidden text-xs text-gray-500 mt-1">
                                <span class="inline-flex items-center mr-4"><i class="fas fa-dna text-green-600 mr-1"></i> {{ \Illuminate\Support\Str::limit($item->penyilang, 5) }}</span>
                                <span class="inline-flex items-center"><i class="fa-solid fa-upload text-blue-600 mr-1"></i> {{ \Illuminate\Support\Str::limit($item->uploader->name, 5) }}</span>
                            </div>
                            <!-- Desktop: Penyilang & Pengirim below ID -->
                            <div class="hidden md:block text-xs text-gray-500 mt-1">
                                <span class="inline-flex items-center mr-4"><i class="fas fa-dna text-green-600 mr-1"></i>{{ \Illuminate\Support\Str::limit($item->penyilang, 5) }}</span>
                                <span class="inline-flex items-center"><i class="fa-solid fa-upload text-blue-600 mr-1"></i>{{ \Illuminate\Support\Str::limit($item->uploader->name, 5) }}</span>
                            </div>
                        </td>
                        <td class="p-2">{{ $item->induk_betina }} </td>
                        <td class="p-2">✕</td>
                        <td class="p-2">{{ $item->induk_jantan }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Load More Sentinel -->
        <div id="load-more" class="text-center py-4">
            <div id="loading-spinner" class="hidden">
                <i class="fas fa-spinner fa-spin text-gray-500"></i> Loading more...
            </div>
            <div id="no-more" class="hidden text-gray-500">No more hybrids</div>
        </div>

    </div>


    <!-- Modal Popout Foto Tanaman -->
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
