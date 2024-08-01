@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">Contact Us</h1>
        <!-- Menampilkan konten dari pengaturan -->
        <div class="text-gray-600">{!! $settings->contact_us ?? 'No contact us available.' !!}</div>
    </div>
</div>
@endsection
