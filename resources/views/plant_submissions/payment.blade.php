@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-10">

    <h1 class="text-2xl p-4 font-bold hidden md:block mt-8">Checkout</h1>

    <div class="grid md:grid-cols-2 gap-8">

        <div class="md:col-span-2 bg-white rounded-xl shadow-sm mb-4">
            <div class="bg-white p-3 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Payment Details</h2>
                <p><strong>Plant Name:</strong> {{ $plantSubmission->plant_id }}</p>
                <p><strong>Certificate Number:</strong> <span class="text-green-600 text-sm">Appears after payment is verified</span></p>
               
                <div class="mt-4">
                    <div id="priceBox"
                        onclick="copyPrice()"
                        class="cursor-pointer flex items-center justify-center gap-2 text-xl font-bold text-blue-600 bg-blue-50 p-3 rounded-lg transition hover:bg-blue-100">
                        
                        <span>Rp {{ number_format($uniquePrice, 0, ',', '.') }}</span>

                        <!-- Copy Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-blue-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                    </div>

                    <div id="copyAlert"
                        class="text-sm text-green-600 text-center mt-2 hidden">
                        ✅ Copied to clipboard!
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Scan QRIS Payment</h3>
                    <span class="text-xs text-gray-600">Scan the QR code below to complete your payment and input the amount of <strong>Rp {{ number_format($uniquePrice, 0, ',', '.') }}</strong> 
                    <img src="{{ asset('qris-1000036271y.png') }}" alt="QRIS Payment" class="w-48 h-48 mx-auto">
                    
                </div>

                
            </div>
        </div>
    

     {{-- RIGHT SIDE - SUMMARY --}}
            <div class="bg-white rounded-xl shadow-sm p-6 h-fit">

                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>

                <div class="flex justify-between mb-2 text-gray-600">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($uniquePrice, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between mb-4 text-gray-600">
                    <span>Shipping</span>
                    <span>Rp 0</span>
                </div>

                <div class="border-t pt-4 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-blue-600">
                        Rp {{ number_format($uniquePrice, 0, ',', '.') }}
                    </span>
                </div>

             
                <div class="mt-6 w-full">
                    <a href="https://wa.me/6288901309732?text={{ urlencode('Hi, I have completed the payment of Rp ' . number_format($uniquePrice, 0, ',', '.') . ' for Plant ID ' . $plantSubmission->plant_id . '. (Please do not delete or modify this message)') }}"
                    class="block w-full text-center py-3 bg-blue-600 hover:bg-blue-700 transition text-white font-semibold rounded-lg shadow-sm">
                        
                        <i class="fab fa-whatsapp text-lg"></i> Confirm Payment
                        
                    </a> 
                </div>



                <p class="text-xs text-gray-400 mt-3 text-center">
                    You will be redirected to whatsapp to confirm your payment.
                </p>

            </div>
</div>
</div>

<script>
function copyPrice() {
    const text = "{{ $uniquePrice }}";
    
    navigator.clipboard.writeText(text).then(() => {
        const alertBox = document.getElementById('copyAlert');
        alertBox.classList.remove('hidden');

        setTimeout(() => {
            alertBox.classList.add('hidden');
        }, 2000);
    });
}
</script>
@endsection