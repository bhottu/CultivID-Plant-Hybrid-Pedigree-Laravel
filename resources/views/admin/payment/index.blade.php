@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto py-6">

    <h1 class="text-2xl font-bold mb-6">
        💳 Data Transaksi (Buy Me a Coffee)
    </h1>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Pengirim</th>
                    <th class="px-4 py-2 border">Penerima</th>
                    <th class="px-4 py-2 border">Amount</th>
                    <th class="px-4 py-2 border">User Share</th>
                    <th class="px-4 py-2 border">Admin Share</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($transactions as $trx)
                    <tr class="text-center">
                        <td class="px-3 py-2 border">{{ $trx->id }}</td>
                        <td class="px-3 py-2 border">
                            {{ $trx->user->name ?? 'Guest' }}  <br><span class="text-xs text-gray-500">ID: {{ $trx->user->id ?? 'Guest' }}</span>
                        </td>
                        <td class="px-3 py-2 border">
                            {{ $trx->receiver->name ?? 'Unknown User' }}
                            <br>
                            <span class="text-xs text-gray-500">
                                ID: {{ $trx->user_id_receiver }}
                            </span>
                        </td>
                        <td class="px-3 py-2 border">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 border text-green-600">
                            Rp {{ number_format($trx->user_share, 0, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 border text-blue-600">
                            Rp {{ number_format($trx->admin_share, 0, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 border">
                            @if($trx->status === 'completed')
                                <span class="text-green-600 font-semibold">COMPLETED</span>
                            @elseif($trx->status === 'pending')
                                <span class="text-yellow-600 font-semibold">PENDING</span>
                            @else
                                <span class="text-red-600 font-semibold">FAILED</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 border">
                            {{ $trx->created_at->format('d-m-Y H:i') }}
                        </td>
                        <td class="px-3 py-2 border text-center space-x-2">

                            <!-- EDIT -->
                            <a
                                href="{{ route('admin.payment.edit', $trx->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm"
                            >
                                ✏️ Edit
                            </a>

                            <!-- DELETE -->
                            <form
                                action="{{ route('admin.payment.destroy', $trx->id) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm"
                                >
                                    🗑 Hapus
                                </button>
                            </form>

                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
