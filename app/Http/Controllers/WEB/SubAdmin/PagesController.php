<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Traits\imageTrait;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Image;

class PagesController extends Controller
{
    use imageTrait;
    public function __construct()
    {
        $route = Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use ($route_name) {

            if ($route_name == 'index') {
                if (can(['pages-show', 'pages-edit'])) {
                    return $next($request);
                }
            }  elseif ($route_name == 'edit' || $route_name == 'update') {
                if (can('pages-edit')) {
                    return $next($request);
                }
            }else {
                return $next($request);
            }
            return redirect()->back()->withErrors(__('cp.you_dont_have_premession'));
        });
    }


    public function image_extensions()
    {

        return array('jpg', 'png', 'jpeg', 'gif', 'bmp');

    }

    public function index()
    {
        $pages = Page::where('vendor_id', auth('subadmin')->id())->get();
        return view('subadmin.pages.home', ['pages' => $pages]);
    }

    public function create()
    {
        return view('subadmin.pages.create');
    }

    public function store(Request $request)
    {
        $roles = [

        ];
        $page =new Page();
        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        foreach ($locales as $locale) {
            $page->translateOrNew($locale)->title = $request->get('title_' . $locale);

        }

        if ($request->hasFile('image')) {
            $page->image =  $this->storeImage( $request->file('image'), 'pages',$page->getRawOriginal('image'));
        }
        $page->vendor_id =auth('subadmin')->id();
        $word= $request->get('title_en');
        $page->slug=Str::slug($word);
        if ($page->save()) {
            return redirect()->back()->with('status', __('cp.create'));
        }
        return redirect()->back()->withErrors('errors', ['Page not updated']);
    }

    public function edit($id)
    {
        $item = Page::query()->findOrFail($id);
        return view('subadmin.pages.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {

        $roles = [

            ];
        $page = Page::query()->findOrFail($id);
        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        foreach ($locales as $locale) {
            $page->translate($locale)->title = $request->get('title_' . $locale);

        }

        if ($request->hasFile('image')) {
            $page->image =  $this->storeImage( $request->file('image'), 'pages',$page->getRawOriginal('image'));
        }
        $page->vendor_id =auth('subadmin')->id();
        $word= $request->get('title_en');
        $page->slug=Str::slug($word);
        if ($page->save()) {
            return redirect()->back()->with('status', __('cp.update'));
        }
        return redirect()->back()->withErrors('errors', ['Page not updated']);
    }

    public function destroy($id)
    {
        $page = Page::query()->findOrFail($id);
        if ($page->delete()) {
            return 'success';
        }
        return 'fail';
    }


}
