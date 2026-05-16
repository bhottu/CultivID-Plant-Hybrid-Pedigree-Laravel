@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-4 px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>
    <div class="bg-blue-100 dark:bg-gray-700 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex items-center">
                <div class="mr-4">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" onclick="openImagePopup('{{ asset('storage/' . Auth::user()->profile_photo_path) }}')" alt="Profile Photo" class="h-32 w-auto rounded">
                    @else
                        <img src="/storage/images/default.png" alt="Default Profile Photo" onclick="openImagePopup('/storage/images/default.png')" class="h-10 w-10 rounded-full">
                    @endif
                </div>
                <div>
                <div class="text-gray-500 text-sm">
                    <p class="text-gray-700 text-sm font-bold dark:text-gray-400">Name:</p>
                    <p><span class="font-normal">{{ auth()->user()->name }}</span></p>
                </div>
                <div class="text-gray-500 text-sm">
                    <p class="text-gray-700 text-sm font-bold dark:text-gray-400">Email:</p>
                    <p><span class="font-normal">{{ auth()->user()->email }}</span></p>
                </div>
                <div class="text-gray-500 text-sm">
                    <p class="text-gray-700 text-sm font-bold dark:text-gray-400">Phone number:</p>
                    <p><span class="font-normal">{{ auth()->user()->phone_number }}</span></p>
                </div>

                </div>
            </div>
        </div>


        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">Username</label>
            <input type="text" class="bg-gray-200 shadow appearance-none rounded w-full py-2 px-3 text-gray-700 dark:text-gray-400 leading-tight focus:outline-none focus:shadow-outline" id="username" name="name" value="{{ old('username') ?? auth()->user()->username }}" disabled>
        </div>
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">Name</label>
            <input type="text" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" value="{{ old('name') ?? auth()->user()->name }}">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">Email</label>
            <input type="email" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" value="{{ old('email') ?? auth()->user()->email }}">
        </div>
   
        <div class="mb-4">
            <label for="currency" class="block font-medium text-sm text-gray-700 dark:text-gray-400">Currency <label class="text-xs text-gray-500">(Not on the list? <a href="{{ route('admin.settings.contact') }}" class="hover:text-red-700 text-red-400">Contact Us</a>)</label></label>
            <select id="currency" name="currency" class="form-control w-auto shadow appearance-none rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled>Select Currency</option>
                @foreach($currencies as $currency)
                    <option value="{{ $currency->code }}" {{ old('currency', $user->currency) == $currency->code ? 'selected' : '' }}>
                        {{ $currency->code }} - {{ $currency->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="phone_number" class="block font-medium text-sm text-gray-700 dark:text-gray-400">Phone Number</label>
            <input id="phone_number" type="text" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">New Password</label>
            <input type="password" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">Confirm New Password</label>
            <input type="password" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="mb-4">
            <label for="profile_photo" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">Profile Photo</label>
            <input type="file" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="profile_photo" name="profile_photo">
        </div>

        <div class="mb-4">
            <label for="location" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">Lokasi</label>
            <div id="map" style="height: 400px; width: 100%;"></div>
            <div class="mt-4">
                <button type="button" id="getLocationBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs mb-2">Get Current Location</button>
            </div>
            <div class="flex items-center space-x-4">
        <div>
            
            <label for="latitude" class="block text-gray-600 text-sm font-medium dark:text-gray-400">Latitude</label>
            <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $user->latitude) }}" class="dark:text-gray-400 rounded-md p-2 text-sm w-32">
        </div>
        <div>
            <label for="longitude" class="block text-gray-600 text-sm font-medium dark:text-gray-400">Longitude</label>
            <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $user->longitude) }}" class="border dark:text-gray-400 border-gray-300 rounded-md p-2 text-sm w-32">
        </div>
        
    </div>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Profile</button>
        </div>
    </form>
</div>

<!-- ImagePopup.blade.php -->
<div id="image-popup" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-75">
    <div class="relative max-w-screen-lg mx-auto flex h-full">
        <!-- Bagian Gambar di Kiri -->
        <div class="relative bg-black h-full flex items-center justify-center">
            <img id="image-popup-img" src="" alt="Post Image" class="max-h-full max-w-full object-contain rounded-lg">
            <div class="absolute top-0 right-0 p-4">
                <button class="text-white hover:text-gray-300" onclick="closeImagePopup()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>  
    </div>
</div>
<!-- End Popup -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    var map = L.map('map').setView([{{ $user->latitude ?? '51.505' }}, {{ $user->longitude ?? '-0.09' }}], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Set z-index to ensure map is below header
    map.getContainer().style.zIndex = '1';

    @if($user->latitude && $user->longitude)
        var marker = L.marker([{{ $user->latitude }}, {{ $user->longitude }}]).addTo(map);
        marker.bindPopup('<b>Your Location</b>').openPopup();
    @endif

    var popup = L.popup();

    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);

        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;
    }

    map.on('click', onMapClick);

    // Add the geocoder control
    var geocoder = L.Control.Geocoder.nominatim();
    L.Control.geocoder({
        geocoder: geocoder
    }).addTo(map).on('markgeocode', function(e) {
        var center = e.geocode.center;
        map.setView(center, 13);
        var marker = L.marker(center).addTo(map);
        marker.bindPopup('<b>' + e.geocode.name + '</b>').openPopup();
        document.getElementById('latitude').value = center.lat;
        document.getElementById('longitude').value = center.lng;
    });

    // Get current location
    document.getElementById('getLocationBtn').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                map.setView([lat, lng], 13);
                var marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup('<b>Your Current Location</b>').openPopup();
            }, function(error) {
                alert('Error getting location: ' + error.message);
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });
</script>



@endsection
