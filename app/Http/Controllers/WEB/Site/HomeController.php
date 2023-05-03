<?php

namespace App\Http\Controllers\WEB\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Language;
use App\Models\Meal;
use App\Models\Page;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\Quote;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Subadmin;
use App\Models\UsAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Validator;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->locales = Language::all();

        $this->branch_name = explode("/", request()->url())[4];
        $this->subadmins = Subadmin::where("branch_name", '=', $this->branch_name)->first();
        if (!$this->subadmins) {
            $this->subadmins = '';
            abort(404);
        }
        if ($this->subadmins) {
            $this->id = Subadmin::where("branch_name", '=', $this->branch_name)->first()->id;
            $this->uses = UsAbout::where('vendor_id', $this->id)->get();
        }
        $this->silder = Slider::query()->where('status', 'active')->get();
        view()->share([
            'locales' => $this->locales,
            'subadmins' => $this->subadmins,
            'uses' => $this->uses,
        ]);
    }


    public function index($name)
    {
        if ($this->subadmins) {
            if ($name) {
                $slider = Slider::where('vendor_id', $this->id)->where('status', 'active')->get();

                return view('website.index', [
                    'slider' => $slider,
                ]);

            } else {
                return 123;
            }
        } else {
            return abort(500);
        }
    }

    public function about($name = '')
    {
        if ($this->subadmins) {
            if ($name) {
                $page = Page::where('vendor_id', $this->id)->where('slug', 'about-us')->first();
                $slider = Slider::where('vendor_id', $this->id)->where('status', 'active')->get();
                if (!$page) {
                    abort(404);
                }
                return view('website.about', [
                    'slider' => $slider,
                    'page' => $page
                ]);

            } else {
                return 123;
            }
        } else {
            return abort(500);
        }
    }

    public function menu($name = '')
    {
        if ($this->subadmins) {
            if ($name) {
                $page = Page::where('vendor_id', $this->id)->where('slug', 'like', '%' . 'menu' . '%')->first();

                $meals = Meal::where('user_id', $this->id)->where('status', 'active')->with('category')->get();
                $category = Category::with(['meals'])->where('user_id', $this->id)->where('status', 'active')->get();
                if (!$page) {
                    abort(404);
                }
                return view('website.menu', [
                    'meals' => $meals,
                    'categories' => $category,
                    'page' => $page

                ]);

            } else {
                return 123;
            }
        } else {
            return abort(500);
        }

    }

    public function reservation($name = '')
    {
        if ($this->subadmins) {
            if ($name) {

                $page = Page::where('vendor_id', $this->id)->where('slug', 'reservation')->first();

                $slider = Slider::where('vendor_id', $this->id)->where('status', 'active')->get();
                if (!$page) {
                    abort(404);
                }
                return view('website.reservation', [
                    'slider' => $slider,
                    'page' => $page

                ]);

            } else {
                return 123;
            }
        } else {
            return abort(500);
        }
    }

    public function chef($name = '')
    {
        if ($this->subadmins) {
            if ($name) {
                $page = Page::where('vendor_id', $this->id)->where('slug', 'meet-our-chef')->first();

                $chefs = Chef::where('user_id', $this->id)->where('status', 'active')->get();
                if (!$page) {
                    abort(404);
                }
                return view('website.chefs', [
                    'chefs' => $chefs,
                    'page' => $page

                ]);

            } else {
                return 123;
            }
        } else {
            return abort(500);
        }
    }

    public function gallery($name = '')
    {
        if ($this->subadmins) {
            if ($name) {
                $page = Page::where('vendor_id', $this->id)->where('slug', 'gallery')->first();

                $gallery = Gallery::where('vendor_id', $this->id)->where('status', 'active')->get();

                if (!$page) {
                    abort(404);
                }
                return view('website.gallery', [
                    'gallery' => $gallery,
                    'page' => $page
                ]);

            } else {
                return 123;
            }
        } else {
            return abort(500);
        }
    }

    public function contact()
    {
        $page = Page::where('vendor_id', $this->id)->where('slug', 'contact-us')->first();
        if (!$page) {
            abort(404);
        }
        return view('website.contact', ['page' => $page]);
    }

    public function storeQuote(Request $request, $name = '')
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'phone' => 'required',
            'topic' => 'required|in:complaint,suggestion',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => implode("\n", $validator->messages()->all()), 'errors' => $validator->errors(), 'code' => 400]);
        }

        $quote = new Contact();
        $quote->name = $request->get('name');
        $quote->topic = $request->get('topic');
        $quote->phone = $request->get('phone');
        $quote->message = $request->get('message');
        $quote->user_id = $this->id;
        $quote->save();
        return response()->json(['status' => true, 'code' => 200]);
    }

    public function reservation_store(Request $request, $name = '')
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:4',
            'mobile' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => implode("\n", $validator->messages()->all()), 'errors' => $validator->errors(), 'code' => 400]);
        }

        $quote = new Reservation();
        $quote->full_name = $request->get('full_name');
        $quote->mobile = $request->get('mobile');
        $quote->persons = $request->get('persons');
        $quote->date = $request->get('date');
        $quote->time = $request->get('time');
        $quote->description_details = $request->get('description_details');
        $quote->vendor_id = $this->id;

        if ($quote->save()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => __('done_added')
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('done_failed')
                ]
            );
        }

    }
}
