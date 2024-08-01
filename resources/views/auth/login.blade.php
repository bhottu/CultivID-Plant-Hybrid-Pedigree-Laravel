@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container mx-auto">
    <div class="max-w-md mx-auto my-8">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="h-16 mt-4 w-auto"> 
        </div>
        <!-- Login Form -->
       
          
            
        <form action="{{ route('login') }}" method="post" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            @if($errors->any())
                <div class="alert text-red-800 justify-left alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert text-red justify-left alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @csrf
        </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <a class="mb-4 text-gray-600 text-sm hover:text-gray-800" href="{{ route('password.request') }}">Forgot Your Password?</a>
            <button type="submit" class="w-full bg-blue-500 mt-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
        </form>
    </div>
</div>
@endsection
