<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\Meal;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
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
        $items = Category::where('user_id', auth('subadmin')->id())->where('parent_id', '0')->filter()
            ->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('subadmin.categories.home', [
            'items' => $items,
        ]);
    }


    public function create()
    {
        return view('subadmin.categories.create');
    }


    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');
        $roles = [
            'sort_order' => 'required',
        ];

        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = new Category();

        $item->user_id = auth('subadmin')->id();
        $item->sort_order = $request->sort_order;

        foreach ($locales as $locale) {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();
        activity($item->name)->causedBy(auth('subadmin')->user())->log('إضافة التصنيف ');

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Category::where('id', $id)->first();
        return view('subadmin.categories.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

        $roles = [
            'sort_order' => 'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = Category::query()->findOrFail($id);
        $item->sort_order = $request->sort_order;

        foreach ($locales as $locale) {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();
        activity($item->name)->causedBy(auth('subadmin')->user())->log('تعديل التصنيف ');

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function meals($id)
    {
        $item = Category::where('id', $id)->first();
        $items = Meal::where('category_id', $id)->paginate($this->settings->paginateTotal);
        return view('subadmin.categories.meals')->with(compact('item', 'items'));
    }


    public function destroy($id)
    {
        //
        $ad = Category::query()->findOrFail($id);
        if ($ad) {
            Category::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

}
