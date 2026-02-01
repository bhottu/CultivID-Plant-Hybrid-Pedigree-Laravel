@extends('admin.layout')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        ✏️ Edit Transaksi #{{ $transaction->id }}
    </h2>

    <form
        action="{{ route('admin.payment.update', $transaction->id) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <!-- AMOUNT -->
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Nominal (Rp)
            </label>
            <input
                type="number"
                name="amount"
                value="{{ old('amount', $transaction->amount) }}"
                class="w-full border rounded px-3 py-2"
                required
            >
        </div>

        <!-- STATUS -->
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Status
            </label>
            <select
                name="status"
                class="w-full border rounded px-3 py-2"
                required
            >
                <option value="pending"   {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed"    {{ $transaction->status === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <!-- ACTION -->
        <div class="flex justify-between">
            <a
                href="{{ route('admin.payment.index') }}"
                class="text-gray-600 hover:underline"
            >
                ← Kembali
            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
            >
                💾 Simpan
            </button>
        </div>

    </form>
</div>
@endsection
