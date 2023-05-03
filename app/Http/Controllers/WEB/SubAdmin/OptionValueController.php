<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\OptionValue;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class OptionValueController extends Controller
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
        $items = OptionValue::filter()->where('user_id',auth('subadmin')->id())->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('subadmin.chefs.home', [
            'items' =>$items,
        ]);
    }


    public function create()
    {
        return view('subadmin.chefs.create');
    }


    public function store(Request $request)
    {
        $roles = [
//            'user_id' => 'required',
            'price' => 'numeric|nullable',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item= new OptionValue();
        $item->user_id = auth('subadmin')->id();
        $item->price = $request->price;
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = OptionValue::where('id',$id)->first();
        return view('subadmin.chefs.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

        $roles = [
//            'user_id' => 'required',
            'price' => 'numeric|nullable',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = OptionValue::query()->findOrFail($id);
        $item->user_id = auth('subadmin')->id();
        $item->price = $request->price;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        //
        $ad = OptionValue::query()->findOrFail($id);
        if ($ad) {
            OptionValue::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
