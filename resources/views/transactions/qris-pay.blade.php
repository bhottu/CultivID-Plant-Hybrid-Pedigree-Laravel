@extends('layouts.app')

@section('content')
<div class="items-center flex items-center justify-center bg-gray-100 py-10 px-4">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8 text-center">

        {{-- Header --}}
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Donate
        </h2>

        <p class="text-gray-500 mb-6">
            Dukung <span class="font-semibold text-gray-700">
                {{ $transaction->receiver->name ?? 'Creator' }}
            </span> atas kontribusinya dengan secangkir kopi
        </p>

        {{-- Nominal --}}
        <div class="bg-gray-50 rounded-xl py-4 mb-6 border">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-3xl font-bold text-green-600">
                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
            </p>
        </div>

        {{-- QR --}}
        <div id="qr-section" class="flex justify-center mb-6">
            <img src="{{ $qr_url }}" class="w-64 h-64 object-contain border rounded-xl p-2 bg-white shadow">
        </div>

        {{-- Status --}}
        <div class="mb-4">
            @if($transaction->status === 'pending')
                <span class="status-badge px-4 py-2 rounded-full text-sm bg-yellow-100 text-yellow-700 font-semibold">
                    ⏳ Menunggu Pembayaran
                </span>
            @elseif($transaction->status === 'completed')
                <span class="px-4 py-2 rounded-full text-sm bg-green-100 text-green-700 font-semibold">
                    ✅ Pembayaran Berhasil
                </span>
            @else
                <span class="px-4 py-2 rounded-full text-sm bg-red-100 text-red-700 font-semibold">
                    ❌ Gagal
                </span>
            @endif
        </div>

        {{-- Pesan Pending --}}
        <div id="pending-section"
            @if($transaction->status !== 'pending') style="display:none;" @endif
            class="text-gray-500 text-sm">
            Silakan scan QR di atas menggunakan aplikasi e-wallet atau m-banking kamu.
        </div>

        {{-- Pesan Success --}}
        <div id="success-section"
            @if($transaction->status !== 'completed') style="display:none;" @endif
            class="mt-4">

            <p class="text-lg font-semibold text-green-600">
                🎉 Terima kasih!
            </p>
            <p class="text-gray-600 text-sm mt-2">
                Kopi kamu sudah berhasil dikirim ke 
                <span class="font-semibold">
                    {{ $transaction->receiver->name ?? 'Creator' }}
                </span>.
            </p>

            <a href="{{ url()->previous() }}"
            class="mt-6 inline-block bg-green-600 text-white px-6 py-2 rounded-lg shadow hover:bg-green-700 transition">
                ⬅ Kembali
            </a>
        </div>

        {{-- Pesan Failed --}}
        <div id="failed-section"
            @if($transaction->status !== 'failed') style="display:none;" @endif
            class="mt-4">

            <p class="text-red-600 font-semibold">
                Pembayaran gagal atau kadaluarsa.
            </p>

            <a href="{{ url()->previous() }}"
            class="mt-6 inline-block bg-gray-600 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-700 transition">
                ⬅ Kembali
            </a>
        </div>

    </div>
</div>

@if($transaction->status === 'pending')
<script>
    const interval = setInterval(() => {

        fetch("{{ route('transaction.check', $transaction->id) }}")
            .then(res => res.json())
            .then(data => {

                const badge   = document.querySelector('.status-badge');
                const qr      = document.querySelector('#qr-section');
                const pending = document.querySelector('#pending-section');
                const success = document.querySelector('#success-section');
                const failed  = document.querySelector('#failed-section');

                if (!badge) return; // safety guard

                // ===== COMPLETED =====
                if (data.status === 'completed') {

                    clearInterval(interval);

                    badge.innerHTML = '✅ Pembayaran Berhasil';
                    badge.className =
                        'status-badge px-4 py-2 rounded-full text-sm bg-green-100 text-green-700 font-semibold';

                    if (qr) qr.style.display = 'none';
                    if (pending) pending.style.display = 'none';
                    if (success) success.style.display = 'block';
                }

                // ===== FAILED =====
                if (data.status === 'failed') {

                    clearInterval(interval);

                    badge.innerHTML = '❌ Gagal';
                    badge.className =
                        'status-badge px-4 py-2 rounded-full text-sm bg-red-100 text-red-700 font-semibold';

                    if (qr) qr.style.display = 'none';
                    if (pending) pending.style.display = 'none';
                    if (failed) failed.style.display = 'block';
                }

            })
            .catch(err => {
                console.error('Polling error:', err);
            });

    }, 5000);
</script>
@endif

@endsection

