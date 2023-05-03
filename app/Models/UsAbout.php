<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsAbout extends Model
{
    use HasFactory,Translatable;
    protected $translatedAttributes=['title' ,'description'];
}
