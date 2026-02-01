<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
   

    protected $fillable = [
        'user_id',
        'user_id_receiver',
        'external_id',
        'type',
        'amount',
        'user_share',
        'admin_share',
        'status',
        'payment_gateway',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id_receiver');
    }
}
