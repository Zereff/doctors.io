<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

trait CommonQueryScope
{
    public function scopeGetAll(Builder $query, int $perPage = 10): LengthAwarePaginator
    {
//        $user = \Auth::user();

//        if ($user->isDoctor()) {
//            return $query->where('doctor_id', $user->id)->paginate($perPage);
//        }

        return $query->paginate($perPage);
    }
}
