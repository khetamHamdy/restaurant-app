<?php

namespace App\Http\Controllers\WEB\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Language;
use App\Models\Meal;
use App\Models\Page;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\Quote;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Subadmin;
use App\Models\UsAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Validator;

class HomeController2 extends Controller
{

    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,
        ]);
    }

    public function index()
    {
           return view('website.indexHome');
    }

}
