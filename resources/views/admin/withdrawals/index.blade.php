@extends('admin.layout')

@section('content')
<div class="container mx-auto p-4 text-sm">
    <h1 class="text-2xl font-bold mb-4">Withdrawal Requests</h1>

    @if(session('success'))
        <div class="bg-green-200 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">User</th>
                <th class="border px-2 py-1">Amount</th>
                <th class="border px-2 py-1">Status</th>
                <th class="border px-2 py-1">Note</th>
                <th class="border px-2 py-1">Created At</th>
                <th class="border px-2 py-1">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $withdrawal)
                <tr>
                    <td class="border px-2 py-1">{{ $withdrawal->id }}</td>
                    <td class="border px-2 py-1">{{ $withdrawal->user->name }}</td>
                    <td class="border px-2 py-1">Rp {{ number_format($withdrawal->amount,0,",",".") }}</td>
                    <td class="border px-2 py-1 text-center">
                        <span
                            class="px-2 py-1 rounded text-xs
                            @if($withdrawal->status === 'approved')
                                bg-green-600 text-gray-200 
                            @elseif($withdrawal->status === 'pending')
                                bg-gray-200 text-gray 
                            @elseif($withdrawal->status === 'failed')
                                bg-red-600 text-white 
                            @endif
                            "
                        >
                            {{ ucfirst($withdrawal->status) }}
                        </span>
                    </td>
                    <td class="border px-2 py-1">{{ $withdrawal->note ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $withdrawal->created_at }}</td>
                    <td class="border px-2 py-1">
                        <form action="{{ route('admin.withdrawals.update', $withdrawal->id) }}" method="POST" class="flex space-x-2">
                            @csrf
                            <select name="status" class="border rounded px-1">
                                <option value="pending" @if($withdrawal->status==='pending') selected @endif>Pending</option>
                                <option value="approved" @if($withdrawal->status==='approved') selected @endif>Approved</option>
                                <option value="failed" @if($withdrawal->status==='failed') selected @endif>Failed</option>
                            </select>
                            
                            <button
                                type="submit"
                                class="px-2 py-1 rounded text-white
                                    {{ $withdrawal->status === 'approved'
                                        ? 'bg-gray-200 cursor-not-allowed'
                                        : 'bg-blue-600 hover:bg-blue-700' }}"
                                {{ $withdrawal->status === 'approved' ? 'disabled' : '' }}
                            >
                                Update
                            </button>

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
