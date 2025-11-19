<?php

namespace App\Models;

use App\Traits\BelongsTouser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, BelongsTouser, HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'total',
        'status',
    ];

    public function generateUniqueOrderNumber(){
        return 'ORD-' . strtoupper(uniqid());
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrdersItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    
}
