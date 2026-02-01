<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTransaction;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Facades\Log;
use App\Models\PlantSubmission;

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
        
        $senderId = auth()->id(); // pengirim
        $receiverId = null;       // penerima

        // Ambil penerima dari plant_submission
        if ($request->plant_id) {
            $plant = PlantSubmission::find($request->plant_id);
            $receiverId = $plant ? $plant->uploader_id : null;
        } else {
            // default: ambil uploader pertama
            $receiverId = PlantSubmission::pluck('uploader_id')->first();
        }

        if (!$receiverId) {
            return redirect()->back()->withErrors('Tidak ada penerima saldo.');
        }

        Configuration::setXenditKey(config('services.xendit.secret'));

        $amount = (int) $request->amount;
        $userShare  = (int) ($amount * 0.8);
        $adminShare = $amount - $userShare;

        $transaction = UserTransaction::create([
            'user_id' => auth()->id(),
            'user_id_receiver' => $receiverId, // catat penerima
            'type' => 'deposit',
            'amount' => $amount,
            'user_share' => $userShare,
            'admin_share' => $adminShare,
            'status' => 'pending',
            'payment_gateway' => 'xendit',
        ]);

        $apiInstance = new InvoiceApi();

        $invoice = $apiInstance->createInvoice([
            // 🔑 SIMPAN ID TRANSAKSI
            'external_id' => (string) $transaction->id,
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
    Log::info('XENDIT CALLBACK RAW', $request->all());

    $payload = $request->all();

    // ✅ AMAN DARI ERROR ARRAY
    $data = $payload['data'] ?? [];

    $externalId = $data['external_id'] ?? null;
    $status     = strtoupper($data['status'] ?? '');

    if (!$externalId) {
        Log::error('XENDIT CALLBACK: external_id missing');
        return response()->json(['message' => 'No external_id'], 400);
    }

    $transaction = UserTransaction::find($externalId);

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
    } elseif ($status === 'EXPIRED') {
        $transaction->update([
            'status' => 'failed',
        ]);
    }

    Log::info('XENDIT CALLBACK SUCCESS', [
        'transaction_id' => $transaction->id,
        'status' => $status,
    ]);

    return response()->json(['message' => 'OK'], 200);
}


}
