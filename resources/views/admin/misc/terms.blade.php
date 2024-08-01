@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">Terms and Conditions</h1>
        <!-- Menampilkan konten dari pengaturan -->
        <div class="text-gray-600">{!! $settings->terms_conditions ?? 'No terms available.' !!}</div>
    </div>
</div>
@endsection
