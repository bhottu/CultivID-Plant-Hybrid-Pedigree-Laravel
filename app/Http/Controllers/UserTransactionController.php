<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UserTransactionController extends Controller
{
    /**
     * BUY ME A COFFEE (DUITKU)
     */
    public function buyCoffee(Request $request)
    {
        $request->validate([
            'to_user_id'     => 'required|exists:users,id',
            'amount'         => 'nullable|numeric|min:5000',
            'custom_amount'  => 'nullable|numeric|min:5000',
        ]);

        $amount = (int) ($request->custom_amount ?: $request->amount);

        if ($amount < 5000) {
            return back()->withErrors(['payment' => 'Minimal 5.000']);
        }

        // Split
        $userShare  = (int) round($amount * 0.8);
        $adminShare = (int) round($amount * 0.2);

        // Create transaction
        $trx = UserTransaction::create([
            'user_id'         => $request->to_user_id,
            'type'            => 'deposit',
            'amount'          => $amount,
            'user_share'      => $userShare,
            'admin_share'     => $adminShare,
            'status'          => 'pending',
            'payment_gateway' => 'duitku',
        ]);

        // Duitku config
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey       = config('services.duitku.api_key');
        $baseUrl      = config('services.duitku.base_url');

        $merchantOrderId = 'COFFEE-' . $trx->id;
        $signature = md5($merchantCode . $merchantOrderId . $amount . $apiKey);

        // === WAJIB SESUAI DOKUMENTASI DUITKU ===
        $payload = [
            'merchantCode'     => $merchantCode,
            'merchantOrderId' => $merchantOrderId,
            'paymentAmount'   => $amount,
            'productDetails'  => 'Buy Me a Coffee',
            'customerVaName'  => Auth::user()->name,
            'email'           => Auth::user()->email,
            'callbackUrl'     => route('duitku.callback'),
            'returnUrl'       => config('services.duitku.return_url'),
            'signature'       => $signature,

            'itemDetails' => [
                [
                    'name'     => 'Buy Me a Coffee',
                    'price'    => $amount,
                    'quantity' => 1,
                ]
            ],

            'expiryPeriod' => 60
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($baseUrl . '/createInvoice', $payload);

        $data = $response->json();

        // DEBUG KALAU GAGAL
        if (!isset($data['paymentUrl'])) {
            logger()->error('DUITKU CREATE INVOICE FAILED', [
                'response' => $data,
                'payload'  => $payload,
            ]);

            return back()->withErrors([
                'payment' => $data['statusMessage'] ?? 'Gagal membuat invoice Duitku',
            ]);
        }

        // 🔥 INI YANG KAMU HARAPKAN
        return redirect()->away($data['paymentUrl']);
    }

    /**
     * DUITKU CALLBACK
     */
    public function duitkuCallback(Request $request)
    {
        $merchantOrderId = $request->merchantOrderId;
        $resultCode      = $request->resultCode;

        if ($resultCode !== '00') {
            return response('FAILED', 400);
        }

        $trxId = str_replace('COFFEE-', '', $merchantOrderId);
        $trx = UserTransaction::find($trxId);

        if (!$trx || $trx->status === 'completed') {
            return response('OK');
        }

        DB::transaction(function () use ($trx) {
            $user  = User::find($trx->user_id);
            $admin = User::find(1); // ADMIN ID

            if ($user) {
                $user->increment('balance', $trx->user_share);
            }

            if ($admin) {
                $admin->increment('balance', $trx->admin_share);
            }

            $trx->update(['status' => 'completed']);
        });

        return response('OK');
    }
}
