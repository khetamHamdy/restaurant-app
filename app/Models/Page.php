<?php



namespace App\Models;



use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model

{
    use SoftDeletes, Translatable;

    public $translatedAttributes = ['title'];
    protected $hidden=['translations','updated_at','deleted_at'];



    protected $fillable = ['image'];


    public function getImageAttribute($image)
    {
        return !is_null($image) ? url('uploads/pages/' . $image) : url('uploads/images/d.png');
    }



}

