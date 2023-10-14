<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

trait CommonQueryScope
{
    public function scopeGetAll(Builder $query, ?User $user = null, int $perPage = 10): LengthAwarePaginator
    {
        if ($user && $user->isDoctor()) {
            $query->where('doctor_id', $user->userable_id);
        }

        return $query->orderBy('doctor_id')->paginate($perPage);
    }
}
