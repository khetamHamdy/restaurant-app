<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Traits\imageTrait;
class CategoryController extends Controller
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


        $route=Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use($route_name){

            if($route_name== 'index' ){
                if(can(['categories-show' , 'categories-create' , 'categories-edit' , 'categories-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'create' || $route_name== 'store'){
                if(can('categories-create')){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('categories-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('categories-delete')){
                    return $next($request);
                }
            }else{
                return $next($request);
            }
            return redirect()->back()->withErrors(__('cp.you_dont_have_permission'));
        });

    }
    public function index()
    {
        $items = Category::where('parent_id','0')->filter()->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('admin.categories.home', [
            'items' =>$items,
        ]);
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $roles = [
            'user_id' => 'required',
            'sort_order' => 'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item= new Category();
        $item->user_id = $request->user_id;
        $item->sort_order = $request->sort_order;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        if ($request->hasFile('image')) {
            $item->image =  $this->storeImage( $request->file('image'), 'categories',$item->getRawOriginal('image'),null,512);
        }
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Category::where('id',$id)->first();
        return view('admin.categories.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

        $roles = [
            'user_id' => 'required',
            'sort_order' => 'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = Category::query()->findOrFail($id);
        $item->user_id = $request->user_id;
        $item->sort_order = $request->sort_order;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        if ($request->hasFile('image')) {
            $item->image =  $this->storeImage( $request->file('image'), 'categories',$item->getRawOriginal('image'),null,512);
        }
        $item->save();
        return redirect()->back()->with('status', __('cp.update'));
    }




}
