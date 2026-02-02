<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,failed',
            'note' => 'nullable|string|max:255',
        ]);

        $oldStatus = $withdrawal->status;

        $withdrawal->update([
            'status' => $request->status,
            'note' => $request->note,
        ]);

        

        return redirect()->back()->with('success', 'Withdrawal updated successfully.');
    }
}
