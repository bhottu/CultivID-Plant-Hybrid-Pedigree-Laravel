@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="flex justify-center items-center h-screen">
    <div class="bg-white rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-semibold mb-4 text-center">Forgot Password</h1>
        
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
            </div>

        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Email" required>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
