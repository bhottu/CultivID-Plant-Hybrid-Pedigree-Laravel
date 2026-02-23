<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
   public function index()
    {
        $userId = Auth::id();

        // Ambil semua notifikasi user
        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->get();

        // Tandai semua yang belum dibaca jadi sudah dibaca
        Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'updated_at' => now()
            ]);

        return view('notifications.index', compact('notifications'));
    }
}
