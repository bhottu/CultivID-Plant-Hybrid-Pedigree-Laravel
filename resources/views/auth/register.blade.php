@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="container mx-auto">
    <div class="max-w-md mx-auto my-8">
        <div class="flex justify-center mb-4">
                    @if (isset($settings) && $settings->logo)
                        <img class="h-16 mt-4 rounded-xl w-auto" src="{{ Storage::url($settings->logo) }}" alt="Logo"> 
                    @else
                        <div class="text-xl font-bold mt-8 w-auto">Cultiv ID</div>
                    @endif 
        </div>
       
        <form action="{{ route('register') }}" method="post" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
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
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>
       
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
    
        <div class="flex mt-4 items-center">
            <hr class="flex-grow border-t border-gray-300">
            <span class="mx-4 text-gray-500">register</span>
            <hr class="flex-grow border-t border-gray-300">
        </div>
        
        <div class="flex mt-4 justify-center">
            <a href="{{ url('auth/google') }}" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 text-center rounded focus:outline-none focus:shadow-outline">
                Register with Google
            </a>
        </div>           
    </form>
    </div>
</div>
@endsection
