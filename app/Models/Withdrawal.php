<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $table = 'withdrawals';

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
{
    static::updated(function ($withdrawal) {
        // jika status berubah menjadi approved dan sebelumnya bukan approved
        if ($withdrawal->isDirty('status') && $withdrawal->status === 'approved') {
            $user = $withdrawal->user;
            if ($user && $user->balance >= $withdrawal->amount) {
                $user->balance -= $withdrawal->amount;
                $user->save();
            }
        }
    });
}


}
