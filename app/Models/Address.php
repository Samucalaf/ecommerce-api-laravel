<?php

namespace App\Models;

use App\Traits\BelongsTouser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use SebastianBergmann\CodeCoverage\Node\Builder;

class Address extends Model
{

    use SoftDeletes, HasFactory, BelongsTouser;
    protected $fillable = [
        'user_id',
        'owner',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'federation_unit',
        'zip_code',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
