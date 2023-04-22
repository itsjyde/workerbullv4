<?php

namespace App\Models\Auth\Traits\Scope;

/**
 * Class UserScope.
 */
trait UserScope
{
    /**
     * @param  bool  $confirmed
     * @return mixed
     */
    public function scopeConfirmed($query, $confirmed = true)
    {
        return $query->where('confirmed', $confirmed);
    }

    /**
     * @param  bool  $status
     * @return mixed
     */
    public function scopeActive($query, $status = true)
    {
        return $query->where('active', $status);
    }
}
