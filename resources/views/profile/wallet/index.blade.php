@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg text-xs">

    {{-- Saldo --}}
    <div class="py-6 text-center">
        <span class="text-gray-600">Available to withdraw</span>
        <h1 class="text-xl font-bold mt-1">Rp {{ number_format($user->balance, 0, ',', '.') }}</h1>
        <a href="{{ route('wallet.withdraw') }}" class="mt-2 inline-block bg-blue-200 hover:bg-blue-400 text-gray-700 px-4 py-2 rounded">
            Withdraw
        </a>
    </div>

    @if (session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
        {{ session('error') }}
    </div>
@endif


    {{-- Tabs --}}
    <div class="mb-6">
        <div class="flex  mb-2">
            <button class="tab-button px-4 py-2 border rounded border-gray-800 font-semibold" data-tab="transactions">Transaction History</button>
            <button class="ml-2 tab-button px-4 py-2 border rounded border-gray-800 font-semibold" data-tab="withdrawals">Withdrawal History</button>
        </div>

        {{-- Transaction Tab --}}
        <div id="transactions" class="tab-content">
            <table class="w-full border mt-2">
                <thead>
                    <tr class="bg-gray-100">
                        
                        <th class="border px-2 py-1">Amount</th>
                        <th class="border px-2 py-1">Status</th>
                        <th class="border px-2 py-1">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                        <tr> 
                            <td class="border px-2 py-1">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            <td class="border px-2 py-1">{{ ucfirst($trx->status) }}</td>
                           <td class="border px-2 py-1">

                                {{-- DESCRIPTION DINAMIS --}}
                                @if($trx->type === 'certificate')
                                    Pembelian Certificate
                                @elseif($trx->type === 'deposit')

                                    @if(auth()->id() === $trx->user_id_receiver)
                                        Anda dikirim kopi oleh {{ $trx->user->name ?? 'User' }}
                                    @else
                                        Anda mengirim kopi ke {{ $trx->receiver->name ?? 'User' }}
                                    @endif

                                @else
                                    Transaksi
                                @endif

                                <br>

                                {{-- EARNING INFO --}}
                                Creator Earnings :
                                {{ number_format($trx->user_share ?? 0, 0, ',', '.') }}

                                |
                                Platform Fee :
                                {{ number_format($trx->admin_share ?? 0, 0, ',', '.') }}

                            </td>
                        </tr>
                    @endforeach
                    @if($transactions->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center border px-2 py-2">No transactions yet.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Withdrawals Tab --}}
        <div id="withdrawals" class="tab-content hidden">
            <table class="w-full border mt-2">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-2 py-1">Amount</th>
                        <th class="border px-2 py-1">Status</th>
                        <th class="border px-2 py-1">Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $wd)
                    <tr>
                        <td class="border px-2 py-1">
                            Rp {{ number_format($wd->amount, 0, ',', '.') }}<br>
                            <span class="text-xxxs">{{ $wd->created_at->format('d-m-Y H:i') }}</span>
                        </td>
                        <td class="border px-2 py-1">{{ ucfirst($wd->status) }}</td>
                        <td class="border px-2 py-1">{{ \Illuminate\Support\Str::words($wd->note ?? '-', 5, '...') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="border px-2 py-1 text-center">No withdrawals found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tab JS --}}
<script>
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;

            // Hide all tab contents
            tabContents.forEach(tc => tc.classList.add('hidden'));

            // Remove active class from all buttons
            tabButtons.forEach(b => b.classList.remove('border-blue-500'));
            tabButtons.forEach(b => b.classList.add('border-transparent'));

            // Show target tab
            document.getElementById(target).classList.remove('hidden');

            // Set active class on button
            btn.classList.add('border-blue-500');
            btn.classList.remove('border-transparent');
        });
    });
</script>
@endsection
