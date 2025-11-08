<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'status',
    ];
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculateTotal()
    {
        return $this->items->sum(function ($item) {
            return $item->calculateTotal();
        });
    }

    /**
     * Finds the active cart for a user, or creates a new one if it doesn't exist.
     * Ensures a user has only one active cart.
     *
     * @param int $userId The user's ID.
     * @return self The active cart instance.
     */
    public static function findOrCreateActiveCart($userId): Cart
    {
        return self::firstOrCreate(
            [
                'user_id' => $userId,
                'status' => 'active',
            ]
        );
    }


    public function markAsCompleted(): bool
    {
        return $this->update(['status' => 'completed']);
    }

    public function markAsAbandoned(): bool
    {
        return $this->update(['status' => 'abandoned']);
    }

    public function markAsActive(): bool
    {
        return $this->update(['status' => 'active']);
    }
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isAbandoned(): bool
    {
        return $this->status === 'abandoned';
    }
}
