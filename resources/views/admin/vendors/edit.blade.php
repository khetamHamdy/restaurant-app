@extends('layout.adminLayout')
@section('title')
    {{ucwords(__('cp.vendors'))}}
@endsection
@section('css')

    <style>
        a:link {
            text-decoration: none;
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
                        <h3>{{__('cp.edit')}} {{@$item->name}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/vendors')}}"
                       class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
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
                    <form method="post" action="{{url(app()->getLocale().'/admin/vendors/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.main_info')}}</h3>
                        </div>

                        <div class="row col-sm-12">
                        @foreach($locales as $locale)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.name')}} <span class="text-danger"> {{$locale->name}} <span></label>

                                    <input type="text" class="form-control form-control-solid"
                                           {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}  name="name_{{$locale->lang}}"
                                           value="{!! @$item->translate($locale->lang)->name!!}" required/>
                                </div>
                            </div>
                        @endforeach

                        @foreach($locales as $locale)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.description')}} <span class="text-danger"> {{$locale->name}} <span></label>
                                    <textarea class="form-control ckEditor-y"   {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} name="description_{{$locale->lang}}"
                                              id="order" rows="4" required>{!! @$item->translate($locale->lang)->description!!}</textarea>
                                </div>
                            </div>
                        @endforeach

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.email')}}</label>
                                    <input type="email" class="form-control form-control-solid" name="email"
                                           value="{{ $item->email}}" required/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.mobile')}}</label>
                                    <input
                                        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"

                                        type="text" class="form-control form-control-solid" name="mobile"
                                        value="{{ $item->mobile}}" required/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.branch_name')}}</label>
                                    <input
                                        type="text" class="form-control form-control-solid" name="branch_name"
                                        value="{{ $item->branch_name}}" required/>
                                </div>
                            </div>

                        </div>

                        <button type="submit" id="submitForm" style="display:none"></button>

                    </form>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection
@section('js')
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });
        $(document).on('click', '#submitButton', function () {
            // $('#submitButton').addClass('spinner spinner-white spinner-left');
            $('#submitForm').click();
        });
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/super-build/ckeditor.js"></script>
    <script>
        @include('admin.settings.editor_script')
    </script>
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {

            $(document).on('click', '.deletevendorsImageBtn', function () {
                var vendors_image_id = $(this).val();
                var this_click = $(this);
                alert(vendors_image_id)
                $.ajax({
                    type: "GET",
                    url: "/admin/" + "vendors-image/" + vendors_image_id + "/delete",
                    success: function (response) {
                        alert(response.message);
                        this_click.closest('.prod_image_tr').remove();
                    }
                })
            });
        })
    </script>
@endsection
