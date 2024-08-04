<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

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
        'key',
    ];

    public static function getValue($key)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }

    public static function setValue($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
    
}
