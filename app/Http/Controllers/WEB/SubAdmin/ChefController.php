<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Exports\MealsExport;
use App\Exports\MealsExportForAdmin;
use App\Exports\MealsReportExport;
use App\Exports\MealsReportForProvider;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Extra;
use App\Models\Language;
use App\Models\Meal;
use App\Models\MealImage;
use App\Models\Option;
use App\Models\OptionOptionValue;
use App\Models\OptionValue;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\User;
use App\Models\UserImage;
use App\Traits\imageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class ChefController extends Controller
{
    use imageTrait;

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
        $items = Chef::filter()->where('user_id',auth('subadmin')->id())->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('subadmin.chefs.home', [
            'items' =>$items,
        ]);
    }


    public function create()
    {
        $users = Subadmin::get();
        return view('subadmin.chefs.create')->with(compact('users'));
    }


    public function store(Request $request)
    {
//        return $request;
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['job_title_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = new Chef();
        $item->user_id = auth('subadmin')->id();

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
            $item->translateOrNew($locale)->job_title = $request->get('job_title_' . $locale);
        }

        if ($request->hasFile('image') && $request->image != '') {
            $item->image = $this->storeImage($request->image, 'chefs');
        }
        $item->save();

        activity($item->title)->causedBy(auth('subadmin')->user())->log('إضافة الشيف ');

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $users = Subadmin::get();
        $item = Chef::where('id',$id)->first();
        if ($item->user_id != auth('subadmin')->id()){
            return redirect()->back()->with('status', __('cp.this_chef_not_for_you'));
        }
        return view('subadmin.chefs.edit', [
            'item' => $item,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png,gif',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['job_title_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = Chef::query()->findOrFail($id);

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
            $item->translateOrNew($locale)->job_title = $request->get('job_title_' . $locale);
        }
        if ($request->hasFile('image') && $request->image != '') {
            $item->image = $this->storeImage($request->image, 'chefs' , $item->getRawOriginal('image') );
        }
        $item->save();

        activity($item->title)->causedBy(auth('subadmin')->user())->log('تعديل الشيف ');
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {

        $ad = Meal::query()->findOrFail($id);
        if ($ad) {
            Meal::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

    public function exportExcel(Request $request)
    {
        activity()->causedBy(auth('subadmin')->user())->log(' تصدير ملف إكسل لبيانات الوجبات ');
        return Excel::download(new MealsExportForAdmin($request), 'meals.xlsx');
    }

    public function MealsReportForProvider(Request $request)
    {
        activity()->causedBy(auth('subadmin')->user())->log(' تصدير تقرير لبيانات الوجبات ');
        return Excel::download(new MealsReportForProvider($request), 'meals.xlsx');
    }


}
