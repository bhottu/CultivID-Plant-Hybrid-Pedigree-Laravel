@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h3>Scan QR untuk bayar ☕</h3>

    <img src="{{ $qr_url }}" width="300">

    <p>Status: {{ $transaction->status }}</p>

    <p>Menunggu pembayaran...</p>
</div>
@endsection