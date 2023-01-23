<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Role extends Model implements Searchable
{
    use HasFactory;

    protected $table = 'user_role';

    protected $fillable = [
        'name',
        'permissions'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function getSearchResult(): SearchResult
    {       
        return new SearchResult($this, $this->name);
    }
}
