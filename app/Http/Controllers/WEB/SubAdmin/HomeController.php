<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\Subadmin;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
//        $sales_this_day = Order::whereDate('created_at', Carbon::today())->where('status','4')->where('provider_id',auth('subadmin')->id())->sum('total');
//        $orders_this_day = Order::whereDate('created_at', Carbon::today())->where('provider_id',auth('subadmin')->id())->count();
//        $avg = round(Order::where('status','!=','5')->where('provider_id',auth('subadmin')->id())->average('total'),2);
//        $total_sales = Order::where('status','!=','5')->where('provider_id',auth('subadmin')->id())->sum('total');
//        $total_orders = Order::where('provider_id',auth('subadmin')->id())->count();
//        $confirmed_orders = Order::where('status','1')->where('provider_id',auth('subadmin')->id())->count();
//        $under_preparing_orders = Order::where('status','2')->where('provider_id',auth('subadmin')->id())->count();
//        $ready_to_pick_orders = Order::where('status','3')->where('provider_id',auth('subadmin')->id())->count();
//        $completed_orders = Order::where('status','4')->where('provider_id',auth('subadmin')->id())->count();
//        $canceled_orders = Order::where('status','5')->where('provider_id',auth('subadmin')->id())->count();


        return view('subadmin.home');
    }


    public function changeStatus($model, Request $request)
    {
        $role = "";
        if ($model == "admins") $role = 'App\Models\Admin';
        if ($model == "categories") $role = 'App\Models\Category';
        if ($model == "meals") $role = 'App\Models\Meal';
        if ($model == "chefs") $role = 'App\Models\Chef';
        if ($model == "promo_codes") $role = 'App\Models\PromoCode';
        if ($model == "orders") $role = 'App\Models\Order';
        if ($model == "cuisines") $role = 'App\Models\Cuisine';
        if ($model == "banners") $role = 'App\Models\Banner';
        if ($model == "contacts") $role = 'App\Models\Contact';
        if ($model == "roles") $role = 'App\Models\Role';
        if ($model == "sliders") $role = 'App\Models\Slider';
        if ($model == "gallery") $role = 'App\Models\Gallery';

        if ($role != "") {
            if ($request->action == 'delete') {
                $role::query()->whereIn('id', $request->IDsArray)->delete();
            } else {
                if ($request->action) {
                    $role::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->action]);
                }
            }

            return $request->action;
        }
        return false;


    }


}
