<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTransaction;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Facades\Log;
use App\Models\PlantSubmission;
use Illuminate\Support\Str;

class UserTransactionController extends Controller
{
    /**
     * Create invoice & redirect to Xendit
     */
    public function buy(Request $request)
{
    $request->validate([
        'amount' => 'required|integer|min:1000',
    ]);

    $senderId = auth()->id();
    $receiverId = null;

    if ($request->plant_id) {
        $plant = PlantSubmission::find($request->plant_id);
        $receiverId = $plant?->uploader_id;
    } else {
        $receiverId = PlantSubmission::pluck('uploader_id')->first();
    }

    if (!$receiverId) {
        return redirect()->back()->withErrors('Tidak ada penerima saldo.');
    }

    Configuration::setXenditKey(config('services.xendit.secret'));

    $amount = (int) $request->amount;
    $userShare  = (int) ($amount * 0.8);
    $adminShare = $amount - $userShare;

    // 🔑 external_id unik & stabil
    $externalId = 'trx_' . Str::uuid();

    $transaction = UserTransaction::create([
        'user_id' => $senderId,
        'user_id_receiver' => $receiverId,
        'external_id' => $externalId,
        'type' => 'deposit',
        'amount' => $amount,
        'user_share' => $userShare,
        'admin_share' => $adminShare,
        'status' => 'pending',
        'payment_gateway' => 'xendit',
    ]);

    $apiInstance = new InvoiceApi();

    $invoice = $apiInstance->createInvoice([
        'external_id' => $externalId,
        'amount' => $amount,
        'description' => 'Buy Me a Coffee',
        'callback_url' => url('/api/xendit/callback'),
        'success_redirect_url' => url('/'),
        'failure_redirect_url' => url('/'),
    ]);

    return redirect($invoice['invoice_url']);
}

    /**
     * Xendit Callback
     */
    public function callback(Request $request)
    {
        Log::info('XENDIT CALLBACK', $request->all());

        $externalId = $request->external_id;
        $status = strtoupper($request->status ?? '');

        if (!$externalId) {
            Log::error('XENDIT CALLBACK: external_id missing');
            return response()->json(['message' => 'No external_id'], 400);
        }

        $transaction = UserTransaction::where('external_id', $externalId)->first();

        if (!$transaction) {
            Log::error('XENDIT CALLBACK: transaction not found', [
                'external_id' => $externalId
            ]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if (in_array($status, ['PAID', 'SETTLED'])) {
            $transaction->update([
                'status' => 'completed',
            ]);
            // ==============================
            // MULAI REVISI: update balance
            $receiver = $transaction->receiver; // pastikan ada relasi receiver di model UserTransaction
            if ($receiver) {
                $receiver->balance += $transaction->user_share;
                $receiver->save();
            }
        } elseif ($status === 'EXPIRED') {
            $transaction->update([
                'status' => 'failed',
            ]);
        }

        Log::info('XENDIT CALLBACK SUCCESS', [
            'transaction_id' => $transaction->id,
            'status' => $status,
        ]);

        return response()->json(['message' => 'OK']);
    }


    public function adminPayment()
    {
        $transactions = UserTransaction::with(['user', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payment.index', compact('transactions'));
    }

    public function destroy(UserTransaction $transaction)
    {
        // Optional: proteksi admin
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $transaction->delete();

        return redirect()
            ->route('admin.payment.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    public function edit(UserTransaction $transaction)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        return view('admin.payment.edit', compact('transaction'));
    }

    public function update(Request $request, UserTransaction $transaction)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|integer|min:1000',
            'status' => 'required|in:pending,completed,failed',
        ]);

        $amount = (int) $request->amount;
        $userShare  = (int) ($amount * 0.8);
        $adminShare = $amount - $userShare;

        $transaction->update([
            'amount' => $amount,
            'user_share' => $userShare,
            'admin_share' => $adminShare,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.payment.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }



}
