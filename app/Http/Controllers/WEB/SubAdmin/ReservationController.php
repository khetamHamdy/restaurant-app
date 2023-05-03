<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ReservationController extends Controller
{
    //
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
                if (can(['reservations-show', 'reservations-edit', 'reservations-delete'])) {
                    return $next($request);
                }
            } elseif ($route_name == 'edit' || $route_name == 'update') {
                if (can('reservations-edit')) {
                    return $next($request);
                }
            } elseif ($route_name == 'destroy' || $route_name == 'delete') {
                if (can('reservations-delete')) {
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
        $items = Reservation::filter()->where('vendor_id',auth('subadmin')->id())->orderBy('id', 'desc')->paginate(30);
        return view('subadmin.reservations.home', [
            'items' => $items,
        ]);
    }

    public function show($id)
    {
        $item = Reservation::where('id', $id)->first();

        activity($item->id)->causedBy(auth('admin')->user())->log(' تعديل حجز طاولة  ');
        return view('subadmin.reservations.show', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'is_read' => 'required'
        ];

        $this->validate($request, $roles);

        $item = Reservation::where('id', $id)->first();
        $item->is_read = $request->is_read;
        $item->save();
        return redirect()->back()->with('status', __('cp.update'));
    }


    public function destroy($id)
    {
        $ad = Reservation::query()->findOrFail($id);
        if ($ad) {
            Reservation::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

    public function exportExcel(Request $request)
    {
        activity()->causedBy(auth('admin')->user())->log(' تصدير ملف إكسل لبيانات الرسائل ');
        return Excel::download(new ContactExport($request), 'contacts.xlsx');
    }

    public function pdfContacts(Request $request)
    {
        activity()->causedBy(auth('admin')->user())->log(' تصدير ملف PDF لبيانات الرسائل ');
        $items = Reservation::orderByDesc('id')->get();
        $pdf = PDF::loadView('admin.contacts.export_pdf', ['items' => $items]);
        return $pdf->download('contacts.pdf');
    }

}
