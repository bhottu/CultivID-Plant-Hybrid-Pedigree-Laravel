<!-- resources/views/admin/misc/about.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">About Us</h1>
        <p style="margin-bottom: 15px; line-height: 1.6;">{!! $settings->about_us ?? 'No privacy available.' !!}</p>
    </div>
</div>
@endsection
