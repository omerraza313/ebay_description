<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_name', 'sku', 'price', 'description','html'];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function attributesWithValue()
    {
        // return $this->belongsToMany(Attribute::class)
        //             ->withPivot('id', 'value');
        return $this->belongsToMany(Attribute::class)
                ->withPivot('id', 'value')
                ->orderBy('sort_order', 'asc');

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class);
    }
}
