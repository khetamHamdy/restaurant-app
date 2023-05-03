<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Language;
use App\Models\productCategories;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\Subadmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Traits\imageTrait;
use Throwable;

class VendorsController extends Controller
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


        $route = Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use ($route_name) {

            if ($route_name == 'index') {
                if (can(['products-show', 'products-create', 'products-edit', 'products-delete'])) {
                    return $next($request);
                }
            } elseif ($route_name == 'create' || $route_name == 'store') {
                if (can('products-create')) {
                    return $next($request);
                }
            } elseif ($route_name == 'edit' || $route_name == 'update') {
                if (can('products-edit')) {
                    return $next($request);
                }
            } elseif ($route_name == 'destroy' || $route_name == 'delete') {
                if (can('products-delete')) {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
            return redirect()->back()->withErrors(__('cp.you_dont_have_permission'));
        });

    }

    public function index()
    {
        $items = Subadmin::filter()->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('admin.vendors.home', [
            'items' => $items,
        ]);
    }


    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $roles = [
            'branch_name' => ['required', 'string'],
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
            'mobile' => 'required|digits_between:8,12|unique:admins',
        ];
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);
        DB::beginTransaction();
        try {
            $item = new Subadmin();

            foreach ($locales as $locale) {
                $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
                $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
            }

            $item->email = $request->email;
            $item->branch_name = $request->branch_name;
            $item->mobile = $request->mobile;
            $item->password = bcrypt($request->password);

            $item->save();

            DB::commit();
            activity()->causedBy(auth('admin')->user())->log(' اضافة البائع ');
            return redirect()->back()->with('status', __('cp.create'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function edit($id)
    {
        $item = Subadmin::where('id', $id)->first();

        $status = ['active' => 'Active', 'not_active' => 'Not Active'];
        return view('admin.vendors.edit', [
            'item' => $item,
            'status' => $status,
        ]);
    }

    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');

        $roles = [
            'branch_name' => ['required', 'string'],
            'email' => 'required|email',
            'mobile' => 'required|digits_between:8,12|unique:admins',
        ];

        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);
        DB::beginTransaction();
        try {
            $item = Subadmin::query()->findOrFail($id);
            foreach ($locales as $locale) {
                $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
                $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
            }

            $item->email = $request->email;
            $item->branch_name = $request->branch_name;
            $item->mobile = $request->mobile;
            $item->password = bcrypt($request->password);

            $item->save();
            DB::commit();
            activity($item->title)->causedBy(auth('admin')->user())->log(' تعديل البائع ');
            return redirect()->back()->with('status', __('cp.update'));

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function show($id)
    {
        $item = Product::with(['user'])->find($id);
        return view('admin.product.sideMenu', compact('item'));
    }

    public function edit_password(Request $request, $id)
    {
        $item = Admin::findOrFail($id);
        return view('admin.vendors.edit_password', ['item' => $item]);
    }

    public function update_password(Request $request, $id)
    {
        $users_rules = array(
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
        );
        $users_validation = Validator::make($request->all(), $users_rules);

        if ($users_validation->fails()) {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }
        $user = Subadmin::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();
//send notification
        return redirect()->back()->with('status', __('cp.update'));
    }
}
