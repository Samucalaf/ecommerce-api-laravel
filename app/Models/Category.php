<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\SlugOptions;   
use App\Policies\CategoryPolicy;


class Category extends Model
{
    use SoftDeletes;
    use HasFactory; 
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    protected $casts = [
        'description' => 'array',
        'is_active' => 'boolean',
    ];
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
