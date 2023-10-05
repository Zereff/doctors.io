<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

trait CommonQueryScope
{
    public function scopeGetAll(Builder $query, User $user, int $perPage = 10): LengthAwarePaginator
    {
        if ($user->isDoctor()) {
            return $query->where('doctor_id', $user->userable_id)->paginate($perPage);
        }

        return $query->paginate($perPage);
    }
}
