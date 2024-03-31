<?php

namespace App\Models;
use App\Models\product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cat_product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'parent_id', 'status'];

    function products(){
        return $this->hasMany(Product::class, 'cat_id');

    }
}
