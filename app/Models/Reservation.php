<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function scopeFilter($query)
    {
        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status', request()->get('status'));
        }

        if (request()->has('full_name')) {
            if (request()->get('full_name') != null)
                $query->where(function ($q) {
                    $q->whereTranslationLike('full_name', '%' . request()->get('title') . '%');
                });
        }
    }
}
