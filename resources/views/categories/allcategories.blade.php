@extends('layouts.app')

@section('content')

<!-- Categories Section -->
<div class="mb-6 mt-4 px-4">
    <h2 class="text-2xl flex justify-center text-sky-800 font-bold rounded-sm p-2">Categories</h2>
    <div class="flex justify-center flex-wrap mt-4 gap-6">
        @if($categories->isEmpty())
            <p>No categories available.</p>
        @else
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                    <div class="flex  max-w-sm rounded-xl bg-gradient-to-tr from-pink-300 to-blue-300 p-0.5 shadow-lg">
                        <h2 class="flex-1 hover:bg-sky-200 font-bold text-sky-900 text-xl text-center bg-white px-6 py-3 rounded-xl">{{ $category->name }}</h2>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</div>

@endsection
