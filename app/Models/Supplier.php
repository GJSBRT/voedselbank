<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'company_name',
        'address',
        'email',
        'phone_number',
        'contact_name',
        'notes',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
