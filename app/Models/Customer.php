<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Customer extends Model implements Searchable
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
        'child_amount',
        'baby_amount',
        'notes',
    ];

    public function foodPackages()
    {
        return $this->hasMany(FoodPackage::class);
    }
    
    public function getSearchResult(): SearchResult
    {       
        return new SearchResult($this, "{$this->first_name} {$this->last_name}");
    }
}
