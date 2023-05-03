<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $translatedAttributes = ['description', 'title'];


    protected $hidden = ['translations', 'created_at', 'updated_at', 'deleted_at'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageAttribute($value)
    {
        if (!is_null($value) && isset($value) && $value != '') {
            return url('uploads/meals/' . $value);
        } else {
            return url('uploads/images/d.jpeg');
        }
    }

    public function scopeFilter($query)
    {
        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status', request()->get('status'));
        }

        if (request()->has('title')) {
            if (request()->get('title') != null)
                $query->where(function ($q) {
                    $q->whereTranslationLike('title', '%' . request()->get('title') . '%');
                });
        }
    }
}
