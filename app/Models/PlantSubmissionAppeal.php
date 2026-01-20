<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantSubmissionAppeal extends Model
{
    protected $fillable = [
        'plant_submission_id', 'user_id', 'keterangan', 'status', 'bukti'
    ];

    public function submission()
    {
        return $this->belongsTo(PlantSubmission::class, 'plant_submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
