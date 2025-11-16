<?php

namespace App\Traits;

trait BelongsTouser
{
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
