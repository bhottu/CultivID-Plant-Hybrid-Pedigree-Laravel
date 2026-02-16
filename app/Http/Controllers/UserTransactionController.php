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

    // 🔒 CEGAH DOUBLE CALLBACK
    if ($transaction->status === 'completed') {
        return response()->json(['message' => 'Already processed'], 200);
    }

    if (in_array($status, ['PAID', 'SETTLED'])) {

        $transaction->update([
            'status' => 'completed',
        ]);

        // ☕ HANYA UNTUK COFFEE / NON PLATFORM ONLY
        if (!$transaction->is_platform_only && $transaction->user_id_receiver) {
            $receiver = $transaction->receiver;
            if ($receiver) {
                $receiver->balance += $transaction->user_share;
                $receiver->save();
            }
        }

    } elseif (in_array($status, ['EXPIRED', 'FAILED'])) {

        $transaction->update([
            'status' => 'failed',
        ]);
    }

    Log::info('XENDIT CALLBACK SUCCESS', [
        'transaction_id' => $transaction->id,
        'final_status' => $transaction->status,
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

        $transaction = UserTransaction::with('plant')->findOrFail($transaction->id);

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

        // Check if the transaction is platform-only
        if ($transaction->is_platform_only == 0) {
            $userShare = null;
            $adminShare = null;
        } else {
            $userShare  = (int) ($amount * 0.8);
            $adminShare = $amount - $userShare;
        }

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

    public function buyCertificate(Request $request)
{
    $request->validate([
        'plant_id' => 'required'
    ]);

   // $plant = PlantSubmission::where('plant_id',$request->plant_id)->firstOrFail();
    $plant = PlantSubmission::findOrFail($request->plant_id);


    // 2️⃣ CEK: apakah user sudah pernah beli certificate ini?
    $alreadyPaid = UserTransaction::where('user_id', auth()->id())
        ->where('plant_id', $plant->id)
        ->where('type', 'certificate')
        ->where('status', 'completed')
        ->exists();

    if ($alreadyPaid) {
        return redirect()
            ->route('plant-submissions.show', $plant->plant_id)
            ->with('info', 'Certificate sudah kamu miliki');
    }
    

    Configuration::setXenditKey(config('services.xendit.secret'));

    $amount = 75000; // 💰 HARGA CERTIFICATE
    $externalId = 'cert_' . \Illuminate\Support\Str::uuid();

    UserTransaction::create([
        'external_id' => $externalId,
        'user_id' => auth()->id(),
        'user_id_receiver' => null,
        'plant_id' => $plant->id,
        'type' => 'certificate',
        'amount' => $amount,
        'user_share' => 0,
        'admin_share' => $amount,
        'status' => 'pending',
        'payment_gateway' => 'xendit',
        'is_platform_only' => true,
    ]);

    $apiInstance = new \Xendit\Invoice\InvoiceApi();

    $invoice = $apiInstance->createInvoice([
        'external_id' => $externalId,
        'amount' => $amount,
        'description' => 'Certificate of Pedigree',
        'callback_url' => url('/api/xendit/callback'),
        'success_redirect_url' => route(
            'plant-submissions.show',
            $plant->plant_id
        ),
    ]);

    return redirect($invoice['invoice_url']); // 🔥 INI KUNCI
}


public function certificateReturn(Request $request)
{
    $transaction = UserTransaction::where(
        'external_id',
        $request->external_id
    )->firstOrFail();

    return redirect()
        ->route('plant-submissions.show', $transaction->plant_id)
        ->with('success', 'Payment successful. Certificate unlocked.');
}


/**
     * Show payment page for plant submission
     */
    public function showPaymentPage(PlantSubmission $plantSubmission)
    {
        $basePrice = 75000;
        $uniqueCode = rand(10, 99); // Generate a unique code
        $uniquePrice = $basePrice + $uniqueCode;

        // Save transaction to database
        UserTransaction::create([
            'user_id' => auth()->id(),
            'plant_id' => $plantSubmission->id,
            'type' => 'certificate',
            'amount' => $uniquePrice,
            'status' => 'pending',
            'is_platform_only' => 0,
            'external_id' => uniqid('txn_'), // Generate a unique external ID
        ]);

        return view('plant_submissions.payment', [
            'plantSubmission' => $plantSubmission,
            'uniquePrice' => $uniquePrice,
        ]);
    }
}
