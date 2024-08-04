@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold">Google AdSense Settings</h2>
        <h4 class="text-xs text-gray-400 font-semibold mb-4">Turn on auto ads from your google adsense setting.</h4>
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('google.adsense.update') }}" method="POST">
            @csrf

            <!-- Publisher ID -->
            <div class="mb-4">
                <label for="publisher_id" class="block text-gray-700">Publisher ID</label>
                <input type="text" id="publisher_id" name="publisher_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ $adsense->publisher_id ?? '' }}" placeholder="Enter Publisher ID">
            </div>

            <!-- Display Ads -->
            <div class="mb-4 hidden">
                <label for="display_ads" class="block text-gray-700">Display Ads Unit ID</label>
                <input type="text" id="display_ads" name="display_ads" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ $adsense->display_ads ?? '' }}" placeholder="Enter Display Ads Unit ID">
            </div>

            <!-- In-Feed Ads -->
            <div class="mb-4 hidden">
                <label for="in_feed_ads" class="block text-gray-700">In-Feed Ads Unit ID</label>
                <input type="text" id="in_feed_ads" name="in_feed_ads" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ $adsense->in_feed_ads ?? '' }}" placeholder="Enter In-Feed Ads Unit ID">
            </div>

            <!-- Multiplex Ads -->
            <div class="mb-4 hidden">
                <label for="multiplex_ads" class="block text-gray-700">Multiplex Ads Unit ID</label>
                <input type="text" id="multiplex_ads" name="multiplex_ads" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ $adsense->multiplex_ads ?? '' }}" placeholder="Enter Multiplex Ads Unit ID">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
            </div>
        </form>
        <h4 class="text-xs mt-4 text-gray-400 font-semibold">You can get this Publisher ID from Google Adsense</h4>
        <h4 class="text-xs text-gray-400 font-semibold">Example : ca-pub-1122334455667788" </h4>

    </div>
@endsection
