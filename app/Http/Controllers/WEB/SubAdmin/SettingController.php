<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cuisine;
use App\Models\Language;
use App\Models\RestaurantBusinesHour;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\UserCuisines;
use App\Models\UserImage;
use App\Traits\imageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    private $locales = '';
    use imageTrait;
    public function __construct()
    {
        $this->locales = Language::all();
        view()->share([
            'locales' => $this->locales,
        ]);
    }

    public function image_extensions(){

        return array('jpg','png','jpeg','gif','bmp','pdf','svg','txt','docx','doc','ppt','xls','zip','rar');

    }

    public function index()
    {

        $item = Subadmin::where('id',auth('subadmin')->id())->first();
        return view('subadmin.settings.edit', ['item' => $item]);
    }

    public function update(Request $request)
    {
        $user = Subadmin::where('id',auth('subadmin')->id())->first();

        $roles =[
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg',
            'mobile' => 'required|digits_between:8,12|unique:subadmins,mobile,' . $user->id,
            'email' => 'required|email|unique:subadmins,email,' . $user->id,
            'branch_name' => 'required',
//            'accept_pick_up' => 'required',
//            'latitude' => 'required',
//            'longitude' => 'required',
            'type' => 'required',
            'opening_status'=>'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $user->mobile = $request->mobile;
        $user->branch_name = $request->branch_name;
//        $user->latitude = $request->latitude;
//        $user->longitude = $request->longitude;
        $user->opening_status = $request->opening_status;
        $user->type = $request->type;
        $user->email = $request->email;
        $user->experiense_years_count = $request->experiense_years_count;
        $user->youtube_link = $request->youtube_link;

        if($request->get('is_about_us') == 'on'){
            $user->is_about_us = 'active' ;
        }else{
            $user->is_about_us = 'not_active' ;
        }

        if($request->get('is_reservation') == 'on'){
            $user->is_reservation = 'active' ;
        }else{
            $user->is_reservation = 'not_active' ;
        }

        if($request->get('is_chef') == 'on'){
            $user->is_chef = 'active' ;
        }else{
            $user->is_chef = 'not_active' ;
        }

        if($request->get('is_gallery') == 'on'){
            $user->is_gallery = 'active' ;
        }else{
            $user->is_gallery = 'not_active' ;
        }

        if($request->get('is_contactUs') == 'on'){
            $user->is_contactUs = 'active' ;
        }else{
            $user->is_contactUs = 'not_active' ;
        }

        if($request->get('is_menu') == 'on'){
            $user->is_menu = 'active' ;
        }else{
            $user->is_menu = 'not_active' ;
        }

        foreach ($locales as $locale)
        {
            $user->translateOrNew($locale)->name = $request->get('name_' . $locale);
            $user->translateOrNew($locale)->description = $request->get('description_' . $locale);
            $user->translateOrNew($locale)->title_about = $request->get('title_about_' . $locale);
            $user->translateOrNew($locale)->descrption_about = $request->get('descrption_about_' . $locale);
        }

        if ($request->hasFile('image') && $request->image != '') {
            if ($request->hasFile('image')) {
//            $setting->app_logo = $this->storeImage($request->file('app_logo'), 'settings', $setting->getRawOriginal('app_logo'));

                $name = time() . "_" . rand(10000, 99999) . "." . $request->file('image')
                        ->getClientOriginalExtension();
                $request->file('image')->move("uploads/subadmins/", $name);
                $user->image =  $name;
            }

//            $user->image = $this->storeImage($request->image, 'subadmins' , $user->getRawOriginal('image') );
        }

        if ($request->hasFile('image_reservation') && $request->image_reservation != '') {
            if ($request->hasFile('image_reservation')) {

                $name = time() . "_" . rand(10000, 99999) . "." . $request->file('image_reservation')
                        ->getClientOriginalExtension();
                $request->file('image_reservation')->move("uploads/subadmins/", $name);
                $user->image_reservation =  $name;
            }
        }


        if ($request->hasFile('image_contact_us') && $request->image_contact_us != '') {
            if ($request->hasFile('image_contact_us')) {

                $name = time() . "_" . rand(10000, 99999) . "." . $request->file('image_contact_us')
                        ->getClientOriginalExtension();
                $request->file('image_contact_us')->move("uploads/subadmins/", $name);
                $user->image_contact_us =  $name;
            }
        }

        if ($request->hasFile('image_about') && $request->image_about != '') {
            if ($request->hasFile('image_about')) {

                $name = time() . "_" . rand(10000, 99999) . "." . $request->file('image_about')
                        ->getClientOriginalExtension();
                $request->file('image_about')->move("uploads/subadmins/", $name);
                $user->image_about =  $name;
            }
        }

        if ($request->hasFile('video_about') && $request->video_about != '') {
            if ($request->hasFile('video_about')) {

                $name = time() . "_" . rand(10000, 99999) . "." . $request->file('video_about')
                        ->getClientOriginalExtension();
                $request->file('video_about')->move("uploads/subadmins/", $name);
                $user->video_about =  $name;
            }
        }
        //        if ($request->has('days') && $request->days != '') {
//            $in = 0;
//            foreach ($request->days as $day) {
//                if (isset($day) && $request->from[$in] != null && $request->to[$in] != null) {
//                    $from = Carbon::createFromFormat('H:i', $request->from[$in]);
//                    $to = Carbon::createFromFormat('H:i', $request->to[$in]);
//                    RestaurantBusinesHour::updateOrCreate(['day' => $day, 'user_id' => $user->id], ['from' => $from, 'to' => $to]);
//                } elseif (isset($day)) {
//                    RestaurantBusinesHour::where(['day' => $day, 'user_id' => $user->id])->delete();
//                }
//                $in++;
//            }
//
//
//        }

        activity('')->causedBy(auth('subadmin')->user())->log(' تحديث بياناته الشخصية ');
        $user->save();

//        if($request->cuisines != null){
//            $count = 1;
//            foreach($request->cuisines as $cuisineID){
//                if ($count <=2){
//                $cuisines[] = [
//                    'user_id' => $user->id,
//                    'cuisine_id' => $cuisineID,
//                ];
//                }
//                $count++;
//            }
//            UserCuisines::where('user_id',$user->id)->delete();
//            UserCuisines::insert($cuisines);
//
//        }

//        $imgsIds = $user->images->pluck('id')->toArray();
//        $newImgsIds = ($request->has('oldImages'))? $request->oldImages:[];
//        $diff = array_diff($imgsIds,$newImgsIds);
//        UserImage::whereIn('id',$diff)->delete();
//
//        if($request->has('filename')  && !empty($request->filename))
//        {
//            foreach($request->filename as $one)
//            {
//                if (isset(explode('/', explode(';', explode(',', $one)[0])[0])[1])) {
//                    $fileType = strtolower(explode('/', explode(';', explode(',', $one)[0])[0])[1]);
//                    $name = "" .str_random(8) . "" .  "" . time() . "" . rand(1000000, 9999999);
//                    $attachType = 0;
//                    if (in_array($fileType, ['jpg','jpeg','png','pmb'])){
//                        $newName = $name. ".jpg";
//                        $attachType = 1;
//                        Image::make($one)->resize(800, null, function ($constraint) {$constraint->aspectRatio();})->save("uploads/images/subadmins/$newName");
//                    }
//                    $user_image=new UserImage();
//                    $user_image->user_id = $user->id;
//                    $user_image->image = $newName;
//                    $user_image->save();
//                }
//            }
//        }


        return redirect()->back()->with('status', __('cp.update'));

    }

}
