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
        'plant_id', 'induk_jantan', 'induk_betina', 'penyilang', 'uploader_id', 'keterangan', 'image', 'status_review', 'reviewed_by', 'reviewed_at', 'uploader_approval'
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
