<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTransaction;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Facades\Log;
use App\Models\PlantSubmission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class UserTransactionController extends Controller
{
    /**
     * Create invoice & redirect to qris
     */
  public function buy(Request $request)
{
    $request->validate([
        'amount' => 'required|integer|min:1000',
    ]);

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $senderId = auth()->id();

    // =============================
    // Tentukan penerima
    // =============================
    if ($request->plant_id) {
        $plant = PlantSubmission::find($request->plant_id);

        if (!$plant) {
            return back()->withErrors('Plant tidak ditemukan.');
        }

        $receiverId = $plant->uploader_id;
    } else {
        $receiverId = PlantSubmission::pluck('uploader_id')->first();
    }

    if (!$receiverId) {
        return back()->withErrors('Tidak ada penerima saldo.');
    }

    $amount = (int) $request->amount;
    $userShare  = (int) round($amount * 0.8);
    $adminShare = $amount - $userShare;

    $externalId = 'coffee_' . Str::uuid();

    // =============================
    // Simpan transaksi awal (pending)
    // =============================
    $transaction = UserTransaction::create([
        'user_id' => $senderId,
        'user_id_receiver' => $receiverId,
        'external_id' => $externalId,
        'type' => 'deposit',
        'amount' => $amount,
        'user_share' => $userShare,
        'admin_share' => $adminShare,
        'status' => 'pending',
        'payment_gateway' => 'qris',
    ]);

    try {

        $response = Http::timeout(20)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-API-Key' => config('services.qris.api_key'),
                'X-API-Secret' => config('services.qris.api_secret'),
            ])
            ->post(config('services.qris.base_url') . '/api/create-payment.php', [
                'amount' => $amount,
                'customer_name' => auth()->user()->name,
                'customer_email' => auth()->user()->email,
                'order_id' => $externalId,
                'description' => 'BMC#' . $externalId,
            ]);

        if (!$response->successful()) {
            $transaction->update(['status' => 'failed']);
            return back()->withErrors('Gagal membuat QR pembayaran.');
        }

        $qrData = $response->json();

        // =============================
        // ✅ SESUAI RESPONSE QRIS.PW
        // =============================
        $qrUrl = $qrData['qris_url'] ?? null;
        $providerId = $qrData['transaction_id'] ?? null;

        if (!$qrUrl) {
            $transaction->update(['status' => 'failed']);
            return back()->withErrors('QR tidak ditemukan dari response API.');
        }

        $transaction->update([
            'related_id' => $providerId,
        ]);

        return view('transactions.qris-pay', [
            'qr_url' => $qrUrl,
            'transaction' => $transaction
        ]);

    } catch (\Exception $e) {

        $transaction->update(['status' => 'failed']);

        return back()->withErrors('Terjadi kesalahan koneksi ke server pembayaran.');
    }
}

    public function qrisWebhook(Request $request)
{
    $payload = $request->all();

    \Log::info('QRIS WEBHOOK:', $payload);

    if (($payload['status'] ?? null) !== 'paid') {
        return response()->json(['message' => 'ignored']);
    }

    $externalId = $payload['order_id'] ?? null;

    if (!$externalId) {
        return response()->json(['message' => 'order_id not found']);
    }

    $transaction = UserTransaction::where('external_id', $externalId)->first();

    if (!$transaction) {
        return response()->json(['message' => 'transaction not found']);
    }

    if ($transaction->status === 'paid') {
        return response()->json(['message' => 'already processed']);
    }

    $transaction->update([
        'status' => 'paid'
    ]);

    return response()->json(['message' => 'success']);
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
