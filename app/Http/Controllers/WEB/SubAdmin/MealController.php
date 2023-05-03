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

class MealController extends Controller
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
        $items = Meal::filter()->where('user_id',auth('subadmin')->id())->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        $categories = Category::all();
        return view('subadmin.meals.home', [
            'items' =>$items,
            'categories' =>$categories,
        ]);
    }

    public function report()
    {
        $items = Meal::where('user_id',auth('subadmin')->id())->orderBy('count_selling', 'desc')->limit(10)->get();
        return view('subadmin.meals.report', [
            'items' =>$items,
        ]);
    }

    public function create()
    {
        $users = Subadmin::get();
        $categories = Category::where('user_id',auth('subadmin')->id())->get();

        return view('subadmin.meals.create')->with(compact('users','categories'));
    }


    public function store(Request $request)
    {
//        return $request;
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
//            'user_id' => 'required',
            'category_id' => 'nullable',
            'price' => 'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = new Meal();
        $item->user_id = auth('subadmin')->id();
        $item->category_id = $request->category_id;
        $item->price = $request->price;
        $item->sort_order = $request->sort_order;
//        if($request->get('best_selling') == 'on'){
//            $item->best_selling = '1' ;
//        }else{
//            $item->best_selling = '0' ;
//        }

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->title = $request->get('title_' . $locale);
            $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }

        if ($request->hasFile('image') && $request->image != '') {
            $item->image = $this->storeImage($request->image, 'meals');
        }
        $item->save();

//        if($request->has('filename')  && !empty($request->filename))
//        {
//            foreach($request->filename as $one)
//            {
//                if (isset(explode('/', explode(';', explode(',', $one)[0])[0])[1])) {
//                    $fileType = strtolower(explode('/', explode(';', explode(',', $one)[0])[0])[1]);
//                    $name = "" .str_random(8) . "" .  "" . time() . "" . rand(1000000, 9999999);
//                    $attachType = 0;
//                    if (in_array($fileType, ['jpg','jpeg','png','pmb'])){
//                        $newName = $name. ".jpg";
//                        $attachType = 1;
//                        Image::make($one)->resize(800, null, function ($constraint) {$constraint->aspectRatio();})->save("uploads/images/meals/$newName");
//                    }
//                    $image=new MealImage();
//                    $image->meal_id = $item->id;
//                    $image->image = $newName;
//                    $image->save();
//                }
//            }
//        }
        activity($item->title)->causedBy(auth('subadmin')->user())->log('إضافة الوجبة ');

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $users = Subadmin::get();
        $item = Meal::where('id',$id)->first();
        if ($item->user_id != auth('subadmin')->id()){
            return redirect()->back()->with('status', __('cp.this_meal_not_for_you'));
        }
        $categories = Category::where('user_id',auth('subadmin')->id())->get();
        return view('subadmin.meals.edit', [
            'item' => $item,
            'users' => $users,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png,gif',
//            'user_id' => 'required',
            'category_id' => 'nullable',
            'price' => 'required',
            'sort_order' => 'required',
//            'status' => 'required',
//            'extras.name_en' => 'required',
//            'extras.name_ar' => 'required',
//            'extras.price' => 'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = Meal::query()->findOrFail($id);

        if (isset($request->category_id) && $request->category_id >0 &&$request->category_id!=null) {
            $item->category_id = $request->category_id;
        }else{
            $item->category_id = 0;
        }
        $item->price = $request->price;

        $item->sort_order = $request->sort_order;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->title = $request->get('title_' . $locale);
            $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }
        if ($request->hasFile('image') && $request->image != '') {
            $item->image = $this->storeImage($request->image, 'meals' , $item->getRawOriginal('image') );
        }
        $item->save();

//        $imgsIds = $item->images->pluck('id')->toArray();
//        $newImgsIds = ($request->has('oldImages'))? $request->oldImages:[];
//        $diff = array_diff($imgsIds,$newImgsIds);
//        MealImage::whereIn('id',$diff)->delete();
//
//        if($request->has('filename')  && !empty($request->filename))
//        {
//            foreach($request->filename as $one)
//            {
//                if (isset(explode('/', explode(';', explode(',', $one)[0])[0])[1])) {
//                    $fileType = strtolower(explode('/', explode(';', explode(',', $one)[0])[0])[1]);
//                    $name = "" .str_random(8) . "" .  "" . time() . "" . rand(1000000, 9999999);
//                    $attachType = 0;
//                    if (in_array($fileType, ['jpg','jpeg','png','pmb'])){
//                        $newName = $name. ".jpg";
//                        $attachType = 1;
//                        Image::make($one)->resize(800, null, function ($constraint) {$constraint->aspectRatio();})->save("uploads/images/meals/$newName");
//                    }
//                    $image=new MealImage();
//                    $image->meal_id = $item->id;
//                    $image->image = $newName;
//                    $image->save();
//                }
//            }
//        }
        activity($item->title)->causedBy(auth('subadmin')->user())->log('تعديل الوجبة ');
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
