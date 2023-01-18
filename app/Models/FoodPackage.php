<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPackage extends Model
{
    use HasFactory;

    protected $table = 'food_package';

    protected $fillable = [
        'customer_id',
        'notes',
        'retrieved_at',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(FoodPackageItem::class);
    }

    public function addItem($id)
    {
        FoodPackageItem::create([
            'food_package_id' => $this->id,
            'product_id' => $id
        ]);
    }
}
