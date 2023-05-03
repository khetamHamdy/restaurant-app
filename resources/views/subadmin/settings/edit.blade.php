@extends('layout.subAdminLayout')
@section('title')
    {{ucwords(__('cp.settings'))}}
@endsection
@section('css')
    <style>
        a:link {
            text-decoration: none;
        }

        #map-canvas {
            width: 100%;
            height: 320px;

        }
    </style>

@endsection
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.edit')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <form class="form" method="post" action="{{url(app()->getLocale().'/provider/settings/')}}"
                          id="form" role="form" enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.contact_info')}}</h3>
                        </div>
                        <div class="card-body">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('cp.opening_status')}}</label>
                                        <select class="form-control form-control-solid"
                                                name="opening_status" required>
                                            <option
                                                value="1" {{$item->opening_status=='1'?'selected':''}}>
                                                {{__('cp.open')}}
                                            </option>

                                            <option
                                                value="2" {{$item->opening_status=='2'?'selected':''}}>
                                                {{__('cp.crowded')}}
                                            </option>

                                            <option
                                                value="3" {{$item->opening_status=='3'?'selected':''}}>
                                                {{__('cp.closed')}}
                                            </option>


                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.name_'.$locale->lang)}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="name_{{$locale->lang}}"
                                                   {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} value="{{old('name_'.$locale->lang,@$item->translate($locale->lang)->name)}}"
                                                   required/>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.mobile')}}</label>
                                        <input type="text" class="form-control form-control-solid" name="mobile"
                                               onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                               value="{{$item->mobile}}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">{{__('cp.email')}}</label>
                                        <input type="email" class="form-control form-control-solid" name="email"
                                               value="{{ old('email',$item->email) }}" id="email" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.branch_name')}}</label>
                                        <input type="text" class="form-control form-control-solid" name="branch_name"
                                               value="{{$item->branch_name}}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.experiense_years')}}</label>
                                        <input type="text" class="form-control form-control-solid" name="experiense_years_count"
                                               value="{{$item->experiense_years_count}}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.youtube_link')}}</label>
                                        <input type="text" class="form-control form-control-solid" name="youtube_link"
                                               value="{{$item->youtube_link}}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.type')}}</label>
                                        <select class="form-control form-control-solid"
                                                name="type" required>
                                            <option
                                                value="2" {{$item->type=='2'?'selected':''}}>
                                                {{__('cp.restaurant')}}
                                            </option>
                                            <option
                                                value="3" {{$item->type=='3'?'selected':''}}>
                                                {{__('cp.food_truck')}}
                                            </option>

                                            <option
                                                value="4" {{$item->type=='4'?'selected':''}}>
                                                {{__('cp.store')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-6 col-form-label">{{__('cp.is_about_us')}}</label>
                                        <div class="col-3">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" name="is_about_us" {{$item->is_about_us == 'active'?'checked':''}}/>
                                            <span></span>
                                        </label>
                                    </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-6 col-form-label">{{__('cp.is_menu')}}</label>
                                        <div class="col-3">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" name="is_menu" {{$item->is_menu == 'active'?'checked':''}}/>
                                            <span></span>
                                        </label>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-6 col-form-label">{{__('cp.is_reservation')}}</label>
                                        <div class="col-3">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" name="is_reservation" {{$item->is_reservation == 'active'?'checked':''}}/>
                                            <span></span>
                                        </label>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-6 col-form-label">{{__('cp.is_chef')}}</label>
                                        <div class="col-3">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" name="is_chef" {{$item->is_chef == 'active'?'checked':''}}/>
                                            <span></span>
                                        </label>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-6 col-form-label">{{__('cp.is_gallery')}}</label>
                                        <div class="col-3">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" name="is_gallery" {{$item->is_gallery == 'active'?'checked':''}}/>
                                            <span></span>
                                        </label>
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-6 col-form-label">{{__('cp.is_contactUs')}}</label>
                                        <div class="col-3">
                                    <span class="switch">
                                        <label>
                                            <input type="checkbox" name="is_contactUs" {{$item->is_contactUs == 'active'?'checked':''}}/>
                                            <span></span>
                                        </label>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.description_')}} <span class="text-danger"> {{$locale->name}} <span></label> <span
                                                style="color: #7b7878; font-size: 13px;"> ( @lang('cp.max150') )</span>
                                            <textarea type="text" class="form-control form-control-solid"
                                                      rows="3"
                                                      {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}  name="description_{{$locale->lang}}"
                                                      required>{{old('description_'.$locale->lang,@$item->translate($locale->lang)->description)}}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.title_about')}} <span class="text-danger"> {{$locale->name}} <span></label>
                                            <input type="text" class="form-control form-control-solid"
                                                      {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}  name="title_about_{{$locale->lang}}"
                                                      required
                                            value="{{old('title_about_'.$locale->lang,@$item->translate($locale->lang)->title_about)}}"
                                            >
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.descrption_about')}} <span class="text-danger"> {{$locale->name}} <span></label>
                                            <textarea type="text" class="form-control form-control-solid"
                                                      rows="3"
                                                      {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}  name="descrption_about_{{$locale->lang}}"
                                                      required>{{old('descrption_about_'.$locale->lang,@$item->translate($locale->lang)->descrption_about)}}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        {{--                        <div class="card-header">--}}
                        {{--                            <h3 class="card-title">{{__('cp.businessHours')}}</h3>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="card-body">--}}



                        {{--                            <div class="row">--}}
                        {{--                                <div class="col-md-4">--}}
                        {{--                                    <div class="form-group">--}}
                        {{--                                        <label class="control-label">{{__('cp.day')}}</label>--}}
                        {{--                                        <select class="form-control form-control-solid"  name="days[]" required>--}}
                        {{--                                            <option value="1" selected>@lang('cp.Monday')</option>--}}
                        {{--                                        </select>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-md-3">--}}
                        {{--                                    <div class="form-group">--}}
                        {{--                                        <label>{{__('cp.from')}}</label>--}}
                        {{--                                        <input type="time" class="form-control form-control-solid"--}}
                        {{--                                               value="{{old('from[]',$items->where('day','1')->first()? $items->where('day','1')->first()->from:'')}}"--}}
                        {{--                                               name="from[]"/>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-md-3">--}}
                        {{--                                    <div class="form-group">--}}
                        {{--                                        <label>{{__('cp.to')}}</label>--}}
                        {{--                                        <input type="time" class="form-control form-control-solid"--}}
                        {{--                                               value="{{old('to[]',$items->where('day','1')->first()? $items->where('day','1')->first()->to:'')}}" --}}
                        {{--                                               name="to[]"--}}
                        {{--                                        />--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-md-1 delete">--}}
                        {{--                                    <div class="form-group">--}}
                        {{--                                        <i class="fa fa-trash" style="margin-top: 40px"></i>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                        </div>--}}


                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.image')}}</label>
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image').click()"
                                             style="cursor:pointer">
                                            <img src="{{$item->image}}" id="editImage" alt="{{$item->name}}">
                                        </div>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image').click()">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image"
                                               id="edit_image"
                                               style="display:none">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.image_reservation')}}</label>
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image1').click()"
                                             style="cursor:pointer">
                                            <img src="{{$item->image_reservation}}" id="editImage1"
                                                 alt="image_reservation">
                                        </div>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image1').click()">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image_reservation"
                                               id="edit_image1"
                                               style="display:none">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.image_contact_us')}}</label>
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image2').click()"
                                             style="cursor:pointer">
                                            <img src="{{$item->image_contact_us}}" id="editImage2"
                                                 alt="image_contact_us">
                                        </div>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image2').click()">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image_contact_us"
                                               id="edit_image2"
                                               style="display:none">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.aboutus_image')}}</label>
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image3').click()"
                                             style="cu rsor:pointer">
                                            <img src="{{$item->image_about}}" id="editImag3" alt="image_about">
                                        </div>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image3').click()">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image_about"
                                               id="edit_image3"
                                               style="display:none">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.aboutus_video')}}</label>
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image4').click()"
                                             style="cursor:pointer">
                                            <img src="{{$item->video_about}}" id="editImage4" alt="video_about">
                                        </div>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image4').click()">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="file" class="form-control" name="video_about"
                                               id="edit_image4"
                                               style="display:none">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.location')}}</label>
                                        <div id="map-canvas"></div>
                                        <input type="hidden" class="form-control input-sm"
                                               data-id="{{$item->latitude}}" value="{{$item->latitude}}"
                                               name="latitude" id="latitude">

                                        <input type="hidden" class="form-control input-sm"
                                               data-id="{{$item->longitude}}" value="{{$item->longitude}}"
                                               name="longitude" id="longitude">
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{--                        <div class="card-body">--}}
                        {{--                            <fieldset>--}}
                        {{--                                <legend>{{__('cp.images')}}</legend>--}}
                        {{--                                <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">--}}
                        {{--                                    <div class="col-md-12 col-md-offset-0">--}}
                        {{--                                        @if ($errors->has('image'))--}}
                        {{--                                            <span class="help-block">--}}
                        {{--                                            <strong>{{ $errors->first('image') }}</strong>--}}
                        {{--                                        </span>--}}
                        {{--                                        @endif--}}
                        {{--                                        <div class="imageupload" style="display:flex;flex-wrap:wrap">--}}
                        {{--                                            @foreach($item->images as $one)--}}
                        {{--                                                <div class="imageBox text-center"--}}
                        {{--                                                     style="width:150px;height:190px;margin:5px">--}}
                        {{--                                                    <img src="{{$one->image}}"--}}
                        {{--                                                         style="width:150px;height:150px">--}}
                        {{--                                                    <button class="btn btn-danger deleteImage"--}}
                        {{--                                                            type="button">{{__("cp.remove")}}</button>--}}
                        {{--                                                    <input class="attachedValues" type="hidden" name="oldImages[]"--}}
                        {{--                                                           value="{{$one->id}}">--}}
                        {{--                                                </div>--}}
                        {{--                                            @endforeach--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="input-group control-group increment">--}}
                        {{--                                            <div class="input-group-btn"--}}
                        {{--                                                 onclick="document.getElementById('all_images').click()">--}}
                        {{--                                                <button class="btn btn-success" type="button"><i--}}
                        {{--                                                        class="glyphicon glyphicon-plus"></i>{{__("cp.addImages")}}--}}
                        {{--                                                </button>--}}
                        {{--                                            </div>--}}
                        {{--                                            <input type="file" class="form-control hidden" accept="image/*"--}}
                        {{--                                                   id="all_images" multiple/>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </fieldset>--}}
                        {{--                        </div>--}}

                        <!--end::Card-->
                        <button type="submit" id="submitForm" style="display:none"></button>
                    </form>

                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
        </div>
    </div>

@endsection
@section('js')

    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });

        $('#edit_image1').on('change', function (e) {
            readURL(this, $('#editImage1'));
        });

        $('#edit_image2').on('change', function (e) {
            readURL(this, $('#editImage2'));
        });

        $('#edit_image3').on('change', function (e) {
            readURL(this, $('#editImage3'));
        });

        $('#edit_image4').on('change', function (e) {
            readURL(this, $('#editImage4'));
        });
    </script>
    <script>
        $(document).on('click', '.delete', function () {
            $(this).parent().find('input').val('');
        });
    </script>
@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('APIGoogleKey')}}&libraries=places"
            type="text/javascript"></script>
    <script>
        var latitude = $('#latitude').data("id");
        var longitude = $('#longitude').data("id");
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            center: {
                lat: latitude,
                lng: longitude
            },
            zoom: 4
        });
        var marker = new google.maps.Marker({
            position: {
                lat: latitude,
                lng: longitude
            },
            map: map,
            draggable: true
        });
        var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
        google.maps.event.addListener(searchBox, 'places_changed', function () {
            var places = searchBox.getPlaces();
            var bounds = new google.maps.LatLngBounds();
            var i, place;
            for (i = 0; place = places[i]; i++) {
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location); //set marker position new...
            }
            map.fitBounds(bounds);
            map.setZoom(15);
        });
        google.maps.event.addListener(marker, 'position_changed', function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        });
    </script>
    <script>
        function readURLMultiple(input, target) {
            if (input.files) {
                var filesAmount = input.files.length;
                for (var i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        target.append('<div class="imageBox text-center" style="width:150px;height:190px;margin:5px"><img src="' + event.target.result + '" style="width:150px;height:150px"><button class="btn btn-danger deleteImage" type="button">{{__("cp.delete")}}</button><input class="attachedValues" type="hidden" name="filename[]" value="' + event.target.result + '"></div>');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        $(document).on("click", ".deleteImage", function () {
            $(this).parent().remove();
        });
        $('#all_images').on('change', function (e) {
            readURLMultiple(this, $('.imageupload'));
        });
    </script>
    <script>
        $('#cuisines').change(function (e) {
            if ($("#cuisines option:selected").length > 2) {
                swal('@lang('cp.cuisines_must_be_in_one_to_two')');
                $("#cuisines option:last").remove();
            }
        });
    </script>
@endsection
