<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

// class User extends Model
class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_photo_path',
        'is_admin',
        'phone_number',
        'latitude',
        'longitude',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            foreach ($user->products as $product) {
                $product->delete();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function isBanned()
    {
        return $this->deleted_at !== null;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

     // 🔥 TAMBAHKAN INI
    public function isFollowing(User $user): bool
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function plantSubmissions()
    {
        return $this->hasMany(\App\Models\PlantSubmission::class, 'uploader_id');
    }

public static function generateUsername($name)
{
    $base = Str::slug($name);
    $username = $base;
    $i = 1;

    while (self::where('username', $username)->exists()) {
        $username = $base . $i;
        $i++;
    }

    return $username;
}
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];
}
