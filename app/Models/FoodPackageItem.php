<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPackageItem extends Model
{
    use HasFactory;

    protected $table = 'food_package_item';

    protected $fillable = [
        'food_package_id',
        'product_id',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
