<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Http\Traits\imageTrait;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SliderController extends Controller
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
//            if (can('admins')) {
//                return $next($request);
//            }
            if ($route_name == 'index') {
                if (can(['slider-show', 'slider-create', 'slider-edit', 'slider-delete'])) {
                    return $next($request);
                }
            } elseif ($route_name == 'create' || $route_name == 'store') {
                if (can('slider-create')) {
                    return $next($request);
                }
            } elseif ($route_name == 'edit' || $route_name == 'update') {
                if (can('slider-edit')) {
                    return $next($request);
                }
            } elseif ($route_name == 'destroy' || $route_name == 'delete') {
                if (can('slider-delete')) {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
            return redirect()->route('subadmin.home')->with('info', __('you dont have permeation'));
        });
    }

    public function index(Request $request)
    {
        $dataSlider = Slider::where('vendor_id', auth('subadmin')->id())->latest()->paginate();
        return view('subadmin.sliders.home', compact('dataSlider'));
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
        return view('subadmin.sliders.create', compact('status'));
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

        $slider = new Slider();
        if ($request->hasFile('image')) {
            $slider->image = $this->storeImage($request->file('image'), 'sliders', $slider->getRawOriginal('sliders'));

        }
        $slider->status = $request->status;
        $slider->vendor_id = auth('subadmin')->id();

        $slider->save();
        if ($slider) {
            return redirect()->back()->with('status', __('cp.create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Slider $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public
    function show(Slider $slider)
    {
        return view('subadmin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Slider $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public
    function edit(Slider $slider)
    {
        $status = [
            'active' => 'Active', 'not_active' => 'Not Active'
        ];

        return view('subadmin.sliders.edit', compact('status', 'slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Slider $slider
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function update(Request $request, Slider $slider)
    {
        $data = $request->all();
        $this->Roles($request);

        $slider = Slider::where('id', $slider->id)->first();
        if ($request->hasFile('image')) {
            $slider->image = $this->storeImage($request->file('image'), 'sliders', $slider->getRawOriginal('sliders'), );

        }
        $slider->status = $request->status;
        $slider->vendor_id = auth('subadmin')->id();

        $slider->save();
        if ($slider) {
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
