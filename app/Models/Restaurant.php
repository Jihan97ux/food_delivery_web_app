<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['user_id', 'restaurant_name', 'phone', 'address', 'image_path'];

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

}