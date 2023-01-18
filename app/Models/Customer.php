<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'address',
        'adult_amount',
        'children_amount',
        'baby_amount',
        'notes',
    ];

    public function foodPackages()
    {
        return $this->hasMany(FoodPackage::class);
    }
}
