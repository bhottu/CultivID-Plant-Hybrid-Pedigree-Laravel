<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantSubmission extends Model
{
    public function getRouteKeyName()
    {
        return 'plant_id';
    }
    protected $fillable = [
        'plant_id', 
        'plant_id_var',
        'induk_jantan', 
        'induk_jantan_var',
        'induk_betina', 
        'induk_betina_var',
        'penyilang', 
        'uploader_id', 
        'keterangan', 
        'image', 
        'status_review', 
        'reviewed_by', 
        'reviewed_at', 
        'uploader_approval',
        'certificate_number',
        'certificate_issued_at'
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    protected $casts = [
    'certificate_issued_at' => 'datetime',
    ];
}
