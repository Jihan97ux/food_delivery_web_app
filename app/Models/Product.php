<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;
    protected $table = 'product_tables'; 
    protected $fillable = ['restaurant_id', 'product_category_id', 'name', 'price', 'image', 'stock'];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}