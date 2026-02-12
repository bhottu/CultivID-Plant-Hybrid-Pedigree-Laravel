<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name', 'slug', 'description', 'price', 'category_id','discount'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

public function finalPrice()
{
    return $this->discounted_price && $this->discounted_price > 0
        ? $this->discounted_price
        : $this->price;
}


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount) {
            return $this->price - ($this->price * ($this->discount / 100));
        }
        return $this->price;
    }

    public function getFinalPriceAttribute()
{
    if ($this->discount_price && $this->discount_price > 0) {
        return $this->discount_price;
    }

    return $this->price;
}

    
}
