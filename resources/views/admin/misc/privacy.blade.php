@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">Privacy Policy</h1>
        <!-- Menampilkan konten dari pengaturan -->
        <div class="text-gray-600">{!! $settings->privacy_policy ?? 'No privacy available.' !!}</div>
    </div>
</div>
@endsection
