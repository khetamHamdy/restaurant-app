<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes,Translatable;
    protected $translatedAttributes=['name'];


    protected $hidden = ['translations' , 'created_at','updated_at','deleted_at','parent_id','sort_order','user_id','status'];

    public function user(){
        return $this->belongsTo(Subadmin::class,'user_id','id')->withTrashed();
    }

    public function meals(){
       return $this->hasMany(Meal::class);
    }

    public function getImageAttribute($value)
    {
        if (!is_null($value) && isset($value) && $value!=''){
            return url('uploads/images/categories/' . $value) ;
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
