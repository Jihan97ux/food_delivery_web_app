<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['user_id', 'restaurant_name', 'phone', 'address','profile_photo','image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_restaurant');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // Tambahkan relasi ini
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}