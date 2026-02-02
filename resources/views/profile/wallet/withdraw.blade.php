@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg text-sm">
    <h1 class="text-2xl font-bold mb-4">
<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
  <path d="M22 22H2V10L12 2l10 8v12z"></path>
  <path d="M2 10h20"></path>
  <path d="M6 22V12"></path>
  <path d="M10 22V12"></path>
  <path d="M14 22V12"></path>
  <path d="M18 22V12"></path>
</svg> Withdraw</h1>

    <p class="mb-4">Current balance: <span class="font-semibold text-green-700">Rp {{ number_format($user->balance,0,',','.') }}</span></p>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('wallet.withdraw.submit') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label for="amount" class="block font-semibold">Amount</label> <label class="text-xs">Min. Rp10,000</label>
            <input type="text" name="amount" id="amount" class="border p-2 rounded w-full" placeholder="10000" required>
        </div>

        <div class="mb-2">
            <label for="note" class="block font-semibold">Bank account</label>
            <label class="text-xs">(BCA Nama-Sesuai-Rekening 123456789)</label>
            <textarea name="note" id="note" class="border p-2 rounded w-full" rows="3" required>
-BCA
-Nama sesuai rekening
-123456789
</textarea>

        </div>

        <button type="submit" class="bg-blue-200 hover:bg-blue-400 text-gray-800 px-4 py-2 rounded">
            Withdrawal
        </button>
    </form>
</div>
@endsection
