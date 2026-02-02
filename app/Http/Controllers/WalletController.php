<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTransaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // Halaman wallet
    public function index()
    {
        $user = Auth::user();

        // Ambil saldo user
        $balance = $user->balance;

        // Transaction history -> hanya yang completed dan tampilkan user yang mengirim
        $transactions = UserTransaction::with('user') // relasi pengirim
            ->where('user_id_receiver', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        // Withdrawals user
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.wallet.index', compact('balance', 'transactions', 'user', 'withdrawals'));
    }

    // Halaman withdraw
    public function withdrawForm()
    {
        $user = Auth::user();
        return view('profile.wallet.withdraw', compact('user'));
    }

    // Submit withdraw manual
    public function submitWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10000',
            'note' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if ($request->amount > $user->balance) {
            return redirect()->back()->withErrors('Insufficient balance.');
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'note' => $request->note,
        ]);

        return redirect()->route('wallet.index')->with('success', 'Withdrawal request submitted.');
    }
}
