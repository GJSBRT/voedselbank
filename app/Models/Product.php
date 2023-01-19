<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'ean_number',
        'product_category_id',
        'quantity',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function getSearchResult(): SearchResult
    {       
        return new SearchResult($this, "{$this->name} ({$this->ean_number})");
    }
}
