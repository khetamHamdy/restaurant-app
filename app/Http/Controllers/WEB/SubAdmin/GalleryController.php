<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Http\Traits\imageTrait;
use App\Models\Gallery;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class GalleryController extends Controller
{
    use \App\Traits\imageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $route = Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use ($route_name) {

            if ($route_name == 'index') {
                if (can(['gallery-show', 'gallery-create', 'gallery-edit', 'gallery-delete'])) {
                    return $next($request);
                }
            } elseif ($route_name == 'create' || $route_name == 'store') {
                if (can('gallery-create')) {
                    return $next($request);
                }
            } elseif ($route_name == 'edit' || $route_name == 'update') {
                if (can('gallery-edit')) {
                    return $next($request);
                }
            } elseif ($route_name == 'destroy' || $route_name == 'delete') {
                if (can('gallery-delete')) {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
            return redirect()->route('provider.home')->with('info', __('you dont have permeation'));
        });
    }

    public function index(Request $request)
    {

        $dataGallery = Gallery::where('vendor_id', auth('subadmin')->id())->latest()->paginate();
        return view('subadmin.gallery.home', compact('dataGallery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $status = [
            'active' => 'Active', 'not_active' => 'Not Active'
        ];
        return view('subadmin.gallery.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->Roles($request);

        $gallery = new Gallery();
        if ($request->hasFile('image')) {
            $gallery->image = $this->storeImage($request->file('image'), 'galleries', $gallery->getRawOriginal('sliders'));

        }
        $gallery->status = $request->status;
        $gallery->vendor_id = auth('subadmin')->id();

        $gallery->save();
        if ($gallery) {
            return redirect()->back()->with('status', __('cp.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public
    function show(Gallery $gallery)
    {
        return view('subadmin.sliders.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public
    function edit(Gallery $gallery)
    {
        $status = [
            'active' => 'Active', 'not_active' => 'Not Active'
        ];

        return view('subadmin.gallery.edit', compact('status', 'gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Gallery $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function update(Request $request, Gallery $gallery)
    {
        $data = $request->all();
        $this->Roles($request);

        $gallery = Gallery::where('id', $gallery->id)->first();
        if ($request->hasFile('image')) {
            $gallery->image = $this->storeImage($request->file('image'), 'galleries', $gallery->getRawOriginal('galleries'), null, 512);

        }
        $gallery->status = $request->status;
        $gallery->vendor_id = auth('subadmin')->id();

        $gallery->save();
        if ($gallery) {
            return redirect()->back()->with('status', __('cp.update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Slider $slider
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function destroy(Slider $slider)
    {
        if ($slider) {
            $slider->delete();
            return redirect()->route('subadmin.slider.index')->with('info', __('done_deleted'));
        }
    }

    public function Roles(Request $request)
    {
        $roles = [];

        $roles['image'] = 'required|sometimes|mimes:jpeg,png,jpg,gif';
        $roles['status'] = 'nullable|in:active,not_active';

        $data = $this->validate($request, $roles);
    }

}
