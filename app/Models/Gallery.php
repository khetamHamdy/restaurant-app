<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    public function getImageAttribute($value)
    {
        if (!is_null($value) && isset($value) && $value!=''){
            return url('uploads/galleries/' . $value) ;
        }else{
            return url('uploads/images/d.jpeg');
        }
    }
}
