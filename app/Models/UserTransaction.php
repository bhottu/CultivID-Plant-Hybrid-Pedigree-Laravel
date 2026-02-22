<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
   

    protected $fillable = [
        'user_id',
        'user_id_receiver',
        'external_id',
        'plant_id',
        'type',
        'amount',
        'user_share',
        'admin_share',
        'status',
        'payment_gateway',
        'is_platform_only',
        'related_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id_receiver');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }
    public function plantSubmission()
{
    // Parameter 1: Nama Model Tujuan
    // Parameter 2: Nama kolom FK di tabel 'user_transactions' (plant_id)
    // Parameter 3: Nama kolom PK di tabel 'plant_submissions' (id)
    return $this->belongsTo(\App\Models\PlantSubmission::class, 'plant_id', 'id');
}
}
