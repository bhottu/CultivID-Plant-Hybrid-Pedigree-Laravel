<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'common_name', 'synonym', 'genus', 'family', 'origin', 'breeder', 'description', 'photos', 'user_id', 'edited_by', 'status'
    ];

    protected $casts = [
        'photos' => 'array', // Mengonversi foto menjadi array
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
