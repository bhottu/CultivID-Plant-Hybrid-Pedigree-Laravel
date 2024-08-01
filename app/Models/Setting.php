<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Daftar atribut yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'value',
        'social_media',
        'logo',
        'banner',
        'about_us',
        'terms_conditions',
        'privacy_policy',
        'contact_us',
        'currency',
        'web_description',
        'fav_icon',
        'website_name',
    ];
}
