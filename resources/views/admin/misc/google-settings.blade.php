@extends('admin.layout')

@section('title', 'Google Login Settings')

@section('content')
<div class="container mx-auto">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold">Google Login Settings</h2>
        <h4 class="text-xs text-gray-400 font-semibold mb-4">This settings for google login.</h4>
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 mb-4">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ route('google.settings.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="google_client_id" class="block text-sm font-medium text-gray-700">Google Client ID</label>
                <input type="text" name="google_client_id" id="google_client_id" value="{{ old('google_client_id', $settings->google_client_id ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                @error('google_client_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="google_client_secret" class="block text-sm font-medium text-gray-700">Google Client Secret</label>
                <input type="text" name="google_client_secret" id="google_client_secret" value="{{ old('google_client_secret', $settings->google_client_secret ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                @error('google_client_secret')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="google_redirect_uri" class="block text-sm font-medium text-gray-700">Google Redirect URI</label> <label class="text-xs font-medium text-gray-700">Type: {{ route('home') }}/auth/google/callback</label>
                <input type="text" name="google_redirect_uri" id="google_redirect_uri" value="{{ old('google_redirect_uri', $settings->google_redirect_uri ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                @error('google_redirect_uri')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Settings</button>
        </form>

        <h4 class="text-xs mt-4 text-gray-400 font-semibold">- Open the Google Cloud Console.</h4>
        <h4 class="text-xs text-gray-400 font-semibold">- In the left menu, navigate to APIs & Services > Credentials.</h4>
        <h4 class="text-xs text-gray-400 font-semibold">- Select an existing OAuth 2.0 Client ID or create a new one.</h4>
        <h4 class="text-xs text-gray-400 font-semibold">- In the Authorized javascript origin section, add <b>{{ route('home') }}</b></h4>
        <h4 class="text-xs text-gray-400 font-semibold">- In the Authorized redirect URIs section, add: <b>{{ route('home') }}/auth/google/callback</b></h4>
        <h4 class="text-xs text-gray-400 font-semibold">- Copy client ID & client secret, then paste here.</h4>
        <h4 class="text-xs text-gray-400 font-semibold">- Save the changes.</h4>


    </div>
</div>
@endsection
