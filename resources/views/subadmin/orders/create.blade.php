@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.show_order'))}}
@endsection
@section('css')

@endsection
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.add_order')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/orders')}}"
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
                    <form method="post" action="{{url(app()->getLocale().'/admin/orders')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}

                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.main_info')}}</h3>
                        </div>
                        <div class="row col-sm-12">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.customer_name')}}</label>
                                            <select class="form-control form-control-solid"
                                                    name="user_id" required>
                                                <option value="">@lang('cp.select')</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->user_name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.provider')}}</label>
                                            <select class="form-control form-control-solid"
                                                    name="user_id" required>
                                                <option value="">@lang('cp.select')</option>
                                            @foreach($providers as $provider)
                                                <option value="{{$provider->id}}">{{$provider->name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>




                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between flex-column flex-md-row font-size-lg">
                                            <div class="d-flex flex-column mb-10 mb-md-0">
                                                <div class="d-flex justify-content-between">
                                                    <span class="mr-15 font-weight-bold">sub total : </span>
                                                    <span class="text-right">00000</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span class="mr-15 font-weight-bold">discount</span>
                                                    <span class="text-right"> 00000</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span class="mr-15 font-weight-bold">total</span>
                                                    <span class="text-right">000000</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
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

@endsection

@section('script')

    <script>
        $(document).on('click', '#submitButton', function () {
            // $('#submitButton').addClass('spinner spinner-white spinner-left');
            $('#submitForm').click();
        });
    </script>
@endsection
