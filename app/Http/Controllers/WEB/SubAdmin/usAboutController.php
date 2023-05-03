<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\UsAbout;
use App\Traits\imageTrait;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Image;

class usAboutController extends Controller
{
    use imageTrait;

    public function __construct()
    {
        $route = Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use ($route_name) {

            if ($route_name == 'index') {
                if (can(['usAbout-show', 'usAbout-edit'])) {
                    return $next($request);
                }
            } elseif ($route_name == 'edit' || $route_name == 'update') {
                if (can('usAbout-edit')) {
                    return $next($request);
                }
            } else {
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
        $uses = UsAbout::where('vendor_id', auth('subadmin')->id())->get();
        return view('subadmin.us_about.home', ['uses' => $uses]);
    }

    public function create()
    {
        return view('subadmin.us_about.create');
    }

    public function store(Request $request)
    {
        $roles = [

        ];
        $uses = new UsAbout();
        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        foreach ($locales as $locale) {
            $uses->translateOrNew($locale)->title = $request->get('title_' . $locale);
            $uses->translateOrNew($locale)->description = $request->get('description_' . $locale);

        }

        $uses->vendor_id = auth('subadmin')->id();
        $uses->order = $request->get('order');

        if ($uses->save()) {
            return redirect()->back()->with('status', __('cp.create'));
        }
        return redirect()->back()->withErrors('errors', ['Page not updated']);
    }

    public function edit($id)
    {
        $item = UsAbout::query()->findOrFail($id);
        return view('subadmin.us_about.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {

        $roles = [

        ];
        $uses = UsAbout::query()->findOrFail($id);
        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        foreach ($locales as $locale) {
            $uses->translate($locale)->title = $request->get('title_' . $locale);
            $uses->translate($locale)->description = $request->get('description_' . $locale);

        }

        $uses->vendor_id = auth('subadmin')->id();
        $uses->order = $request->get('order');

        if ($uses->save()) {
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
