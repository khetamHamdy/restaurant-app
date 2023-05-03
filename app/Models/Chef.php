<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chef extends Model
{
    use HasFactory,Translatable;
    protected $translatedAttributes=['name','job_title'];


    public function getImageAttribute($value)
    {
        if (!is_null($value) && isset($value) && $value!=''){
            return url('uploads/chefs/' . $value) ;
        }else{
            return url('uploads/images/d.jpeg');
        }
    }

    public function scopeFilter($query)
    {
        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status', request()->get('status'));
        }

        if (request()->has('user_id')) {
            if (request()->get('user_id') != null)
                $query->where('user_id', request()->get('user_id'));
        }


        if (request()->has('name')) {
            if (request()->get('name') != null)
                $query->where(function ($q) {
                    $q->whereTranslationLike('name', '%' . request()->get('name') . '%');
                });
        }
    }
}
