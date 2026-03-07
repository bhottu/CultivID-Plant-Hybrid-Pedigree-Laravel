@extends('layouts.app')

@section('title', $plantSubmission->plant_id)

@php
    $photos = json_decode($plantSubmission->photos, true);

    if (!empty($photos) && isset($photos[0])) {
        $ogImage = asset('storage/' . $photos[0]);
    } else {
        $imageDecoded = json_decode($plantSubmission->image, true);
        if (is_array($imageDecoded) && isset($imageDecoded[0])) {
            $ogImage = asset('storage/' . $imageDecoded[0]);
        } elseif ($plantSubmission->image) {
            $ogImage = asset('storage/' . $plantSubmission->image);
        } else {
            $ogImage = asset('images/og-default.jpg');
        }
    }
@endphp

@section('og_image', $ogImage)

@section('og_description',
    \Illuminate\Support\Str::limit(
        strip_tags($plantSubmission->keterangan ?? ''),
        155
    )
)

@section('content')

<section class="w-full mx-auto">
    <div class="container mx-auto px-4 mt-3">
        <div class="flex flex-col md:flex-row gap-6">
            
            {{-- KOLOM KIRI (75% / md:col-span-9) --}}
            <div class="w-full md:w-3/4 bg-white">
                <div class="flex items-center justify-between mb-2">
                    <h1 class="text-2xl font-bold text-green-900 flex items-center bg-red-200 rounded-lg py-1 px-2">
                        <i class='fas fa-seedling text-green-600 mr-2'></i> <span class="italic">{{ $plantSubmission->plant_id }}</span>
                    </h1>
                </div>

               
                
                    
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
                                <span class="text-xs  text-gray-400">No photo</span>
                                @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                            <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs text-red-400 underline">Add</a>
                                        @elseif(Auth::check())
                                            <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs text-red-400 underline">Appeal</a>
                                        @else
                                            <a href="{{ route('login') }}" class="text-xs text-red-400 underline">Appeal</a>
                                        @endif
                            </div>
                        @endif


                            <div class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5l7 7-7 7" />
                                </svg>

                                <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Share this plant</span>  
                  
                                <span class="text-heading text-xs font-medium px-1.5 py-0.5 text-gray-700 dark:text-gray-400">
                                                    
                                <button type="button"
                                    onclick="sharePost()"
                                    class="w-full text-gray hover:bg-blue-100 border font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline flex items-center justify-center h-full">
                                    
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3.684 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                    </svg>
                                </button>
                                                        
                                </span>
                            </div>
                    
                     

                <div class="p-4 rounded border border-gray-200 shadow text-sm w-full mt-2">
                    
             




                        <table class="table-auto text-sm mb-4 text-xs w-full">
                            <tr class="border-b border-gray-50">
                                <td class="pr-2 text-xs md:text-sm">Plant ID</td>
                            <td class="italic text-xs text-right"> 
                                @if($plantSubmission->plant_id)
                                    <span class="italic md:text-sm"> {{ $plantSubmission->plant_id }}</span>
                                    @if($plantSubmission->plant_id_var == 0)
                                            <span class="text-xs py-0.5 rounded bg-green-100 text-green-700 font-semibold">
                                                Variegated
                                            </span>
                                        @endif
                                    @else
                                        <span class="italic text-gray-400">No data</span> 
                                    @endif
                            </td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="pr-2 md:text-sm">Seed parent <i class='fas fa-venus text-red-600'></i></td>
                                <td class="italic text-xs md:text-sm text-right"> 
                                    @if($plantSubmission->induk_betina)
                                        {{ $plantSubmission->induk_betina }} 

                                        @if($plantSubmission->induk_betina_var == 0)
                                            <span class="text-xs md:text-sm py-0.5 rounded bg-green-100 text-green-700 font-semibold">
                                                Variegated
                                            </span>
                                        @endif
                                    @else
                                        <span class="italic text-gray-400 md:text-sm">No data, </span>
                                        
                                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                            <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs md:text-sm text-red-400 underline">Add</a>
                                        @elseif(Auth::check())
                                            <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs md:text-sm text-red-400 underline">Appeal</a>
                                        @else
                                            <a href="{{ route('login') }}" class="text-xs text-red-400 md:text-sm underline">Appeal</a>
                                        @endif
                                    
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="pr-2 md:text-sm">Pollen parent <i class='fas fa-mars text-blue-600'></i></td>
                                <td class="italic text-xs md:text-sm text-right">
                                    @if($plantSubmission->induk_jantan)
                                        {{ $plantSubmission->induk_jantan }}

                                        @if($plantSubmission->induk_jantan_var == 0)
                                            <span class="text-xs md:text-sm py-0.5 rounded bg-green-100 text-green-700 font-semibold">
                                                Variegated
                                            </span>
                                        @endif
                                    @else
                                        <span class="italic text-gray-400 md:text-sm">No data, </span> 
                                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                            <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs md:text-sm text-red-400 underline">Add</a>
                                        @elseif(Auth::check())
                                            <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs md:text-sm text-red-400 underline">Appeal</a>
                                        @else
                                            <a href="{{ route('login') }}" class="text-xs md:text-sm text-red-400 underline">Appeal</a>
                                        @endif
                                    
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="pr-2 md:text-sm">Breeder </td>
                                <td class="italic text-xs md:text-sm text-right"> 
                                    @if($plantSubmission->penyilang)
                                        {{ $plantSubmission->penyilang }}
                                    @else
                                        <span class="italic text-gray-400 md:text-sm">No data, </span>
                                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                            <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="text-xs md:text-sm text-red-400 underline">Add</a>
                                        @elseif(Auth::check())
                                            <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="text-xs md:text-sm text-red-400 underline">Appeal</a>
                                        @else
                                            <a href="{{ route('login') }}" class="text-xs md:text-sm text-red-400 underline">Appeal</a>
                                        @endif
                                    
                                    @endif
                                    </td>
                            </tr>
                            
                            @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                            <tr class="border-b border-gray-50">
                                <td class="pr-2 md:text-sm">Status</td>
                                <td class="text-right">
                                <span class="px-1 text-gray-700 font-semibold rounded text-xxs 
                                {{ 
                                    $plantSubmission->status_review == 'approved' ? 'bg-green-200 text-green-900' : 
                                    ($plantSubmission->status_review == 'rejected' ? 'bg-red-200 text-red-900' : 
                                    ($plantSubmission->status_review == 'banding' ? 'bg-yellow-200 text-yellow-900' : 'bg-gray-200 text-gray-900')) 
                                    }} text-right">
                                    {{ ucfirst($plantSubmission->status_review) }}
                                    </span>
                                </td>
                            </tr>
                            @endif

                            <tr class="border-b border-gray-50">
                                <td colspan="2" class="py-2">
                                    <div class="flex flex-col" x-data="{ expanded: false }">
                                        <span class="pr-2 md:text-sm">Description</span>
                                        
                                        <div class="italic text-xs md:text-sm mt-1 leading-relaxed">
                                            @if($plantSubmission->keterangan)
                                                @php
                                                    $words = explode(' ', $plantSubmission->keterangan);
                                                    $isLong = count($words) > 5;
                                                @endphp

                                                {{-- Teks Pendek (4 Kata) --}}
                                                <span x-show="!expanded">
                                                    {{ \Illuminate\Support\Str::words($plantSubmission->keterangan, 5, '') }}
                                                </span>

                                                {{-- Teks Lengkap (Akan muncul saat expanded true) --}}
                                                <span x-show="expanded" x-cloak>
                                                    {{ $plantSubmission->keterangan }}
                                                </span>

                                                @if($isLong)
                                                    <button 
                                                        @click="expanded = !expanded" 
                                                        class="text-blue-500 hover:text-blue-700 font-bold ml-1 focus:outline-none"
                                                        x-text="expanded ? 'Show Less' : '... Read More'">
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </table>

                            @if(
                                $plantSubmission->status_review === 'rejected' &&
                                Auth::check() &&
                                (
                                    Auth::user()->is_admin == 1 ||
                                    Auth::id() === $plantSubmission->uploader_id
                                )
                            )
                                <div class="mt-3 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-800">
                                    <strong>Submission rejected</strong><br>
                                    {{ $plantSubmission->rejection_reason }}
                                     @if(Auth::id() === $plantSubmission->uploader_id)
                                    <span class="mt-2 block"><a href="{{ route('plant-submissions.edit', $plantSubmission) }}"
                                    class="bg-gray-800 text-white mr-2 px-2 py-1 rounded text-xs">
                                        Edit and Resubmit
                                    </a></span>
                                @endif
                                </div>

                               
                            @endif

                        </div>

                        <div class="mt-4 text-xs md:text-sm rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-3">
                                    <svg class="mt-0.5 h-8 w-8 text-yellow-500"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75M12 15.75h.01M10.29 3.86l-8.03 13.9a1.5 1.5 0 001.3 2.24h16.88a1.5 1.5 0 001.3-2.24l-8.03-13.9a1.5 1.5 0 00-2.6 0z" />
                                    </svg>

                                    <div>
                                        <p>
                                            <strong>Warning:</strong>
                                            If there is any mistake in the breeder or parent plant name,
                                            please submit an appeal to move this plant to your account.
                                        </p>
                                        <p class="mt-2">
                                            <strong>Alternatively</strong>, you may ask the uploader to update the data
                                            without transferring ownership on this page.
                                        </p>
                                    </div>
                                </div>
                                    @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $plantSubmission->uploader_id))
                                        <a href="{{ route('plant-submissions.edit', $plantSubmission) }}" class="bg-gray-800 text-white px-4 py-1 rounded text-xs">Edit</a>
                                    @elseif(Auth::check())
                                        <a href="{{ route('plant-submissions.appeal.create', $plantSubmission) }}" class="whitespace-nowrap rounded-md bg-yellow-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-yellow-600">Appeal</a>
                                    @else
                                        <a href="{{ route('login') }}" class="whitespace-nowrap rounded-md bg-yellow-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-yellow-600">Appeal</a>
                                    @endif

                            </div>
                        </div>
                        
                        <div class="w-full md:text-sm bg-gray-100 mt-3 border border-dashed border-gray-400 rounded-lg h-24 flex items-center justify-between px-6 hover:bg-gray-200 transition-all cursor-pointer">
                            <div class="flex items-center gap-4">
                                {{-- Icon lebih kecil --}}
                                <div class="rounded-full">
                                    <i class="fas fa-ad text-xl"></i> 
                                    
                                </div>
                                
                                {{-- Teks rata kiri agar lebih hemat ruang --}}
                                <div class="text-left">
                                    <p class="text-xs font-bold text-yellow-600">Premium Ads</p> <h3 class="text-sm font-bold text-gray-700">Place Your Ad Here</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Reach thousands of plant enthusiasts.</p>
                                </div>
                            </div>

                            {{-- Tombol disesuaikan ukurannya (lebih kecil/compact) --}}
                            <a href="{{ route('become.partner') }}" 
                            class="px-4 py-1 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-200 hover:text-gray-800 transition whitespace-nowrap">
                                Become Partner
                            </a>
                        </div>
                        
                        {{-- ===================== --}}
                        {{-- PEDIGREE TABLE --}}
                        {{-- ===================== --}}
                        @auth
                            @if(isset($pedigree) && $pedigree)
                            @php
                                /**
                                * Render link tanaman + gender icon + variegated indicator
                                */
                                function plantLink($plantId, $gender = null, $isVar = null) {
                                    if (!$plantId) {
                                        return '<span class="text-gray-400 italic">—</span>';
                                    }

                                    // Gender icon
                                    $icon = '';
                                    if ($gender === 'f') {
                                        $icon = "<i class='fas fa-venus md:text-sm text-red-600 mr-1'></i>";
                                    } elseif ($gender === 'm') {
                                        $icon = "<i class='fas fa-mars md:text-sm text-blue-600 mr-1'></i>";
                                    }

                                    // Variegated indicator (PUTIH)
                                    $varIcon = '';
                                    if ($isVar === 0) {
                                        $varIcon = "
                                            <span
                                                title='Variegated'
                                                class='inline-block w-4 h-4 md:text-sm rounded-full bg-white border border-gray-400 ml-1 align-middle'>
                                            </span>
                                        ";
                                    }

                                    // Check exists
                                    $exists = \App\Models\PlantSubmission::where('plant_id', $plantId)->exists();

                                    if ($exists) {
                                        return '
                                            <a href="'.route('plant-submissions.show', $plantId).'"
                                            class="text-gray-700 text-xs md:text-sm hover:underline italic inline-flex items-center justify-center gap-1">
                                                '.$icon.'
                                                <span>'.$plantId.'</span>
                                                '.$varIcon.'
                                            </a>
                                        ';
                                    }

                                    return '
                                        <span class="text-gray-500 md:text-sm italic inline-flex items-center gap-1">
                                            '.$icon.'
                                            <span>'.$plantId.'</span>
                                            '.$varIcon.'
                                        </span>
                                    ';
                                }
                            @endphp

                            <div class="mt-4">
                                <h2 class="text-md md:text-sm text-green-900 mb-2">Pedigree</h2>

                                <div class="overflow-x-auto">
                                    <table class="border-collapse border border-gray-300 text-sm text-center w-full">

                                        {{-- TABLE HEAD --}}
                                        <thead class="bg-yellow-50 text-xs md:text-sm text-gray-400">
                                            <tr>
                                                <th class="border px-4 py-2">Offspring</th>
                                                <th class="border px-4 py-2">Parent</th>
                                                <th class="border px-4 py-2">Grandparents</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- ROW 1 --}}
                                            <tr>
                                                {{-- OFFSPRING --}}
                                                <td rowspan="4" class="border bg-gray-50 px-4 py-6">
                                                    {!! plantLink(
                                                        $pedigree['plant_id'],
                                                        null
                                                    {{--, $pedigree['plant_id_var'] ?? null --}}
                                                    ) !!}
                                                </td>

                                                {{-- PARENT BETINA --}}
                                                <td rowspan="2" class="border px-4 py-4 bg-red-50">
                                                    {!! plantLink(
                                                        $pedigree['betina_node']['plant_id'] ?? null,
                                                        'f'
                                                        {{--, $pedigree['betina_node']['plant_id_var'] ?? null --}}
                                                    ) !!}
                                                </td>

                                                {{-- GRANDPARENT BETINA --}}
                                                <td class="border bg-red-50 px-4 py-3">
                                                    {!! plantLink(
                                                        $pedigree['betina_node']['betina_node']['plant_id'] ?? null,
                                                        'f'
                                                        {{--, $pedigree['betina_node']['betina_node']['plant_id_var'] ?? null --}}
                                                    ) !!}
                                                </td>
                                            </tr>

                                            {{-- ROW 2 --}}
                                            <tr>
                                                {{-- GRANDPARENT JANTAN --}}
                                                <td class="border bg-blue-50 px-4 py-3">
                                                    {!! plantLink(
                                                        $pedigree['betina_node']['jantan_node']['plant_id'] ?? null,
                                                        'm'
                                                        {{--, $pedigree['betina_node']['jantan_node']['plant_id_var'] ?? null --}}
                                                    ) !!}
                                                </td>
                                            </tr>

                                            {{-- ROW 3 --}}
                                            <tr>
                                                {{-- PARENT JANTAN --}}
                                                <td rowspan="2" class="border bg-blue-50 px-4 py-4">
                                                    {!! plantLink(
                                                        $pedigree['jantan_node']['plant_id'] ?? null,
                                                        'm'
                                                        {{--, $pedigree['jantan_node']['plant_id_var'] ?? null --}}
                                                    ) !!}
                                                </td>

                                                {{-- GRANDPARENT BETINA --}}
                                                <td class="border bg-red-50 px-4 py-3">
                                                    {!! plantLink(
                                                        $pedigree['jantan_node']['betina_node']['plant_id'] ?? null,
                                                        'f'
                                                        {{--, $pedigree['jantan_node']['betina_node']['plant_id_var'] ?? null --}}
                                                    ) !!}
                                                </td>
                                            </tr>

                                            {{-- ROW 4 --}}
                                            <tr>
                                                {{-- GRANDPARENT JANTAN --}}
                                                <td class="border bg-blue-50 px-4 py-3">
                                                    {!! plantLink(
                                                        $pedigree['jantan_node']['jantan_node']['plant_id'] ?? null,
                                                        'm'
                                                        {{--, $pedigree['jantan_node']['jantan_node']['plant_id_var'] ?? null --}}
                                                    ) !!}
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>

                                    {{-- LEGEND 
                                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-2">
                                        <span class="inline-block w-3 h-3 rounded-full bg-white border border-gray-400"></span>
                                        <span>Variegated</span>
                                    </div> --}}
                                </div>
                            </div>

                    @php
                        $user = auth()->user();
                        // Mengikuti logika controller: pemilik adalah uploader_id
                        $isOwner = $user && $user->id === $plantSubmission->uploader_id; 
                        $isAdmin = $user && $user->is_admin;
                        
                        // Query pengecekan transaksi sesuai kriteria di controller Anda
                        $hasPaidCertificate = $user && \App\Models\UserTransaction::where('user_id', $user->id)
                                ->where('plant_id', $plantSubmission->id)
                                ->where('type', 'certificate')
                                ->where('status', 'completed')
                                ->exists();
                    @endphp
                

                    <div class="flex gap-2 mt-4">
                        @if($isAdmin)
                            {{-- ================= 1. ADMIN (Sesuai Goal 1) ================= --}}
                            <a href="{{ route('plant-submissions.pedigree.pdf', $plantSubmission) }}"
                            class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                ⬇ Download Certificate
                            </a>
                            <a href="{{ route('plant-submissions.pedigree.preview', $plantSubmission) }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-gray-200 rounded hover:bg-gray-300">
                                👁 Preview
                            </a>

                        @elseif($isOwner)

                            {{-- ================= 2. PEMILIK / UPLOADER (Sesuai Goal 2) ================= --}}
                            @if($hasPaidCertificate)
                                {{-- Jika sudah bayar --}}
                                <a href="{{ route('plant-submissions.pedigree.pdf', $plantSubmission) }}"
                                class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                    ⬇ Download Your Certificate
                                </a>
                                <a href="{{ route('plant-submissions.pedigree.preview', $plantSubmission) }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-gray-200 rounded hover:bg-gray-300">
                                👁 Preview
                            </a>
                        @else
                                {{-- Tombol Jika belum bayar --}}
                                
                                <form action="{{ route('certificate.buy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plant_id" value="{{ $plantSubmission->id }}">
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                        💳 Buy Certificate
                                    </button>
                                </form>
                                
                                <a href="javascript:void(0)" 
                                id="previewBtn"
                                class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-gray-200 rounded hover:bg-gray-300 transition">
                                👁 Preview
                                </a>
                                                                
                        @endif

                        @else
                                {{-- ================= 3. BUKAN PEMILIK (Sesuai Goal 3) ================= --}}
                                <button type="button"
                                    onclick="Swal.fire({
                                        title: 'Exclusive Access',
                                        text: 'The certificate can only be purchased and accessed by the owner of this plant. If this is your plant, please appeal.',
                                        icon: 'info',
                                        confirmButtonColor: '#059669', // Warna hijau agar senada dengan tema Cultiv
                                        confirmButtonText: 'I Understand'
                                    })"
                                    class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-gray-300 text-gray-500 rounded">
                                    🔒 Buy Certificate
                                </button>

                                <a href="javascript:void(0)" 
                                id="previewBtn"
                                class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-gray-200 rounded hover:bg-gray-300 transition">
                                👁 Preview
                                </a>
                        @endif

                    </div>

                    @endif
                    @endauth

                    @guest
                    <div class="mt-4">
                            <h2 class="text-md md:text-sm text-green-900 mb-2">Pedigree</h2>
                        <div class="p-3 rounded bg-gray-50 text-center">
                            <p class="text-sm md:text-sm text-gray-500 italic">
                                Please <a href="{{ route('login') }}" class="inline-block mt-2 text-xs text-green-700 hover:underline bg-red-200">Login</a> to view the pedigree
                            </p>

                        
                        </div>

                        <button type="button"
                                onclick="Swal.fire({
                                title: 'Exclusive Access',
                                text: 'The certificate can only be purchased and accessed by the owner of this plant. If this is your plant, please appeal.',
                                icon: 'info',
                                confirmButtonColor: '#059669', // Warna hijau agar senada dengan tema Cultiv
                                confirmButtonText: 'I Understand'
                                })"
                                class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-gray-300 text-gray-500 rounded">
                                🔒 Buy Certificate
                        </button>

                        <a href="javascript:void(0)" id="previewBtn" class="inline-flex items-center gap-2 px-3 py-2 text-xs md:text-sm bg-gray-200 rounded hover:bg-gray-300 transition">
                            👁 Preview
                        </a>

                    </div>
                    @endguest

                   <!-- Preview Modal -->
                    <div id="previewModal" 
                        class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">

                        <!-- Close Button -->
                        <button id="closePreview" 
                            class="absolute top-4 right-1 text-white text-3xl font-bold hover:text-gray-300" hidden>
                            &times;
                        </button>

                        <!-- Content Wrapper -->
                        <div class="max-w-5xl w-100 px-6 text-center">

                            <!-- Image -->
                            <img 
                                src="{{ asset('ped.jpg') }}" 
                                alt="Preview" 
                                class="w-full h-auto rounded-lg shadow-lg"
                            >

                            <!-- Caption -->
                            <p class="mt-4 bg-gray-800 text-white text-sm md:text-base">
                                Pedigree preview for this plant.
                            </p>

                        </div>
                    </div>

                    <h2 class="text-md md:text-sm text-green-900 mb-2 mt-2">Contributor</h2>
                    @if($plantSubmission->uploader)
                        <div class="bg-gray-50 p-4 rounded shadow text-sm">
                            <div class="flex items-center gap-3 mb-2">
                                @if($plantSubmission->uploader->profile_photo_path)
                                    <img src="{{ asset('storage/' . $plantSubmission->uploader->profile_photo_path) }}" alt="Profile" class="w-10 h-10 rounded-full">
                                @else
                                    <div class="w-10 md:text-sm h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($plantSubmission->uploader->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('profile', $plantSubmission->uploader->username) }}" class="font-semibold text-blue-600 hover:underline">{{ $plantSubmission->uploader->name }}</a>
                                    <p class="text-xs md:text-sm text-gray-500">Member since {{ $plantSubmission->uploader->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs md:text-sm text-gray-600">
                                
                                <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.24 12.24a6 6 0 00-8.49-8.49L5 10.5V19h8.5z"></path>
                                    </svg>
                                    <span>{{ $plantSubmission->uploader->plantSubmissions->count() }} Plants</span>
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

                    <div class="border rounded p-4 mt-4 bg-yellow-50 text-sm">
                
                    <h3 class="mb-2 bg-red-50">☕ Buy Me a Coffee</h3>

                     {{-- Buy Me a Coffee Section --}}
                    @php
                        $count = $plantSubmission->uploader->plantSubmissions->count();
                        $userName = $plantSubmission->uploader->name;
                        $contributorLevel = '';

                        if ($count > 0 && $count <= 10) {
                            $contributorLevel = 'A good start'; // biasa saja
                        } elseif ($count <= 50) {
                            $contributorLevel = 'Cool'; // keren
                        } elseif ($count <= 100) {
                            $contributorLevel = 'Amazing'; // luar biasa
                        } else {
                            $contributorLevel = 'One of the top contributors'; // top kontributor
                        }
                    @endphp

                    <div class="mb-3 text-gray-500">
                        @if($contributorLevel)
                            {{ $contributorLevel }}, <span class="font-semibold bg-red-200">{{ $userName }}</span> has contributed <span class="font-semibold bg-red-200">{{ $count }}</span> plants.
                        @else
                            <span class="font-semibold bg-red-200">{{ $userName }}</span> has contributed <span class="font-semibold bg-red-200">{{ $count }}</span> plants.
                        @endif
                        If you have benefited from their contributions, support them by sending a cup of coffee as an appreciation ☕
                    </div>


                        @if(auth()->check())
                            <form action="{{ route('coffee.buy') }}" 
                                id="buyCoffeeForm"  
                                method="POST">
                            @csrf

                            <div class="mb-2">
                                <label class="mr-4">
                                    <input type="radio" name="amount_option" value="5000"> Rp 5.000
                                </label>
                                <label class="mr-4">
                                    <input type="radio" name="amount_option" value="10000" checked> Rp 10.000
                                </label>
                                <label class="mr-4">
                                    <input type="radio" name="amount_option" value="25000"> Rp 25.000
                                </label>
                            </div>

                            <input 
                                type="text" 
                                class="border border-gray-300 rounded p-2 bg-gray-100 w-full"
                                name="amount"  
                                id="custom_amount"  
                                placeholder="Enter amount"
                                value="10000"
                            >

                            <input type="hidden" name="plant_id" value="{{ $plantSubmission->id }}">

                            <button
                                type="submit"
                                id="sendBtn"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mt-2 w-full"
                            >
                                ☕ Send Coffee
                            </button>
                            </form>

                        
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {

                            const radios = document.querySelectorAll('input[name="amount_option"]');
                            const amountInput = document.getElementById('custom_amount');
                            const form = document.getElementById('buyCoffeeForm');
                            const sendBtn = document.getElementById('sendBtn');

                            // Set amount saat radio dipilih
                            radios.forEach(radio => {
                                radio.addEventListener('change', function () {
                                    if (this.checked) {
                                        amountInput.value = Number(this.value).toLocaleString('id-ID');
                                    }
                                });
                            });

                            // Format ribuan saat mengetik
                            amountInput.addEventListener('input', function () {
                                let numericValue = this.value.replace(/[^\d]/g, '');
                                if (numericValue) {
                                    this.value = Number(numericValue).toLocaleString('id-ID');
                                } else {
                                    this.value = '';
                                }
                            });

                            // Bersihkan format sebelum submit
                            form.addEventListener('submit', function (e) {

                                let cleanValue = amountInput.value.replace(/[^\d]/g, '');

                                if (!cleanValue || cleanValue < 1000) {
                                    alert('Minimum Rp 1.000');
                                    e.preventDefault();   // ✅ pakai e
                                    return;
                                }

                                amountInput.value = cleanValue;

                                sendBtn.disabled = true;
                                sendBtn.innerText = "Generating QR...";
                            });

                        });
                        </script>
                
                @else
                    <button class="bg-green-600 hover:bg-green-700 text-white px-2 py-2 rounded" onclick="alert('Silakan login terlebih dahulu!')">☕ Buy Me a Coffee</button>
                @endif
            </div>

            <div class="w-full bg-gray-100 mt-3 border-2 border-dashed border-gray-400 rounded-xl p-8 flex flex-col items-center justify-center text-center hover:bg-gray-200 transition-all cursor-pointer text-sm">
            <div class="rounded-full mb-4">
                <i class="fas fa-ad text-2xl text-gray-800"></i> 
                <p class="text-xs font-bold text-yellow-600">Premium</p>
            </div>
            <h3 class="text-sm font-bold text-gray-700">Place Your Ad Here</h3>
                <p class="text-sm text-gray-500 max-w-xs mt-1">Reach thousands of plant enthusiasts in the Cultiv community.</p>
                <a href="{{ route('become.partner') }}" class="px-4 py-1 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-200 hover:text-gray-800 transition mt-2">
                     Become Partner
                </a>
            </div>

                    

                
            </div> 

            @include('partials.sidebar-dekstop')

        </div>
    </div>
</section>



        
        </div>
    </div>
</div>


    <!-- Modal Popout Foto -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <div id="modalContent" class="relative">
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

         imageModal.addEventListener('click', function (e) {
            // Kalau klik di luar konten (background)
            if (!modalContent.contains(e.target)) {
                closeImageModal();
            }
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

    <script>
        function openPedigreePreview() {
            document.getElementById('pedigreePreviewModal').classList.remove('hidden');
            document.getElementById('pedigreePreviewModal').classList.add('flex');
        }

        function closePedigreePreview() {
            document.getElementById('pedigreePreviewModal').classList.add('hidden');
            document.getElementById('pedigreePreviewModal').classList.remove('flex');
        }

        function openPedigreePreview() {
            const img = document.getElementById('pedigreePreviewImage');

            if (!img.src) {
                img.src = img.dataset.src; // baru load sekarang
            }

            img.classList.remove('hidden');
            document.getElementById('pedigreePreviewModal').classList.remove('hidden');
            document.getElementById('pedigreePreviewModal').classList.add('flex');
        }



        function sharePost() {
            const description = @json($plantSubmission->keterangan);

            const shareData = {
                title: @json($plantSubmission->plant_id),
                url: @json(url()->current())
            };

            if (description && description.trim() !== '') {
                shareData.text = description.length > 100 
                    ? description.substring(0, 100) + '...' 
                    : description;
            }

            if (navigator.share) {
                navigator.share(shareData)
                    .catch(err => console.log('Share cancelled', err));
            } else {
                openShareFallback();
            }
        }


    </script>
<script>
    // Cek apakah ada session error dari Controller
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            text: "{{ session('error') }}",
            confirmButtonColor: '#059669', // Warna hijau emerald
        });
    @endif

    // Cek juga jika ada session success (setelah bayar)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#059669',
        });
    @endif
</script>
<script>
const modal = document.getElementById('previewModal');
const closeBtn = document.getElementById('closePreview');
const previewBtn = document.getElementById('previewBtn');

// open
previewBtn.addEventListener('click', function () {
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
});

// close via button
closeBtn.addEventListener('click', function () {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

// close jika klik background
modal.addEventListener('click', function(e){
    if(e.target === modal){
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
});
</script>
@endsection
