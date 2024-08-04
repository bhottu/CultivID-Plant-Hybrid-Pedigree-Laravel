<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAdsense extends Model
{
    use HasFactory;
    protected $table = 'google_adsense';

    protected $fillable = [
        'publisher_id',
        'display_ads',
        'in_feed_ads',
        'multiplex_ads',
    ];
}
