@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-10 px-4">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8 text-center">

        {{-- Header --}}
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            ☕ Beli Kopi
        </h2>

        <p class="text-gray-500 mb-6">
            Dukung <span class="font-semibold text-gray-700">
                {{ $transaction->receiver->name ?? 'Creator' }}
            </span> dengan secangkir kopi
        </p>

        {{-- Nominal --}}
        <div class="bg-gray-50 rounded-xl py-4 mb-6 border">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-3xl font-bold text-green-600">
                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
            </p>
        </div>

        {{-- QR --}}
        <div class="flex justify-center mb-6">
            <img src="{{ $qr_url }}" class="w-64 h-64 object-contain border rounded-xl p-2 bg-white shadow">
        </div>

        {{-- Status --}}
        <div class="mb-4">
            @if($transaction->status === 'pending')
                <span class="px-4 py-2 rounded-full text-sm bg-yellow-100 text-yellow-700 font-semibold">
                    ⏳ Menunggu Pembayaran
                </span>
            @elseif($transaction->status === 'paid')
                <span class="px-4 py-2 rounded-full text-sm bg-green-100 text-green-700 font-semibold">
                    ✅ Pembayaran Berhasil
                </span>
            @else
                <span class="px-4 py-2 rounded-full text-sm bg-red-100 text-red-700 font-semibold">
                    ❌ Gagal
                </span>
            @endif
        </div>

        {{-- Pesan Dinamis --}}
        @if($transaction->status === 'pending')
            <p class="text-gray-500 text-sm">
                Silakan scan QR di atas menggunakan aplikasi e-wallet atau m-banking kamu.
            </p>
        @elseif($transaction->status === 'paid')
            <div class="mt-4">
                <p class="text-lg font-semibold text-green-600">
                    🎉 Terima kasih!
                </p>
                <p class="text-gray-600 text-sm mt-2">
                    Kopi kamu sudah berhasil dikirim ke 
                    <span class="font-semibold">
                        {{ $transaction->receiver->name ?? 'Creator' }}
                    </span>.
                </p>
            </div>
        @endif

    </div>
</div>
@endsection