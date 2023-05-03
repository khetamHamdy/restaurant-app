<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\Admin;
use App\Models\Setting;
use App\Models\Subadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class SubAdminController extends Controller
{

    public function image_extensions()
    {

        return array('jpg', 'png', 'jpeg', 'gif', 'bmp', 'pdf');

    }

    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,
        ]);

    }

    public function editMyProfile()
    {
        $item = Subadmin::findOrFail(auth()->guard('subadmin')->user()->id);
        return view('subadmin.subadmin.edit_profile', compact('item'));
    }

    public function updateProfile(Request $request)
    {
        $newAdmin = Subadmin::findOrFail(auth()->guard('subadmin')->user()->id);

        $roles = [
            'email' => 'required|string',
        ];
        if ($request->has('password')) {
            $roles = [
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password|min:6',
            ];
        }
        $validator = Validator::make($request->all(), $roles);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $check = Subadmin::findOrFail(auth()->guard('subadmin')->user()->id);
        if (!$check) {
            $validator = [__('api.whoops')];
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $newAdmin->email = $request->email;
        if ($request->has('password')) {
            $newAdmin->password = bcrypt($request->password);
        }
        $newAdmin->save();

        return redirect()->back()->with('status', __('cp.update'));

    }

}
