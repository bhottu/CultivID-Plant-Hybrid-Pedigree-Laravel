<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id','discount'];

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
    
}
