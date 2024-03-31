<?php

namespace App\Models;

use App\Models\Cat_product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'price', 'cat_id', 'des', 'detail', 'img', 'deleted_at', 'slug', 'bestselling'];

    function cat()
    {
        return $this->belongsTo(Cat_product::class);

    }

// Lấy ra ds sản phẩm nổi bậc
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
// Lấy ds sản phẩm bán chạy
    public function scopeBestselling($query){
        return $query->where('bestselling', true);
    }





}
