@extends('layout.subAdminLayout')
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
                        <h3>{{__('cp.show_order')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/provider/orders')}}"
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
                    <form method="post" action="{{url(app()->getLocale().'/provider/orders/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.main_info')}}</h3>
                        </div>
                        <div class="row col-sm-12">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('cp.status')}}</label>
                                            <select class="form-control form-control-solid"
                                                    name="status" @if($item->status == '4' || $item->status == '5') disabled @endif required>
                                                <option
                                                    value="1" {{$item->status == '1'?'selected':''}}>
                                                    {{__('cp.confirmed')}}
                                                </option>
                                                <option
                                                    value="2" {{$item->status == '2'?'selected':''}}>
                                                    {{__('cp.under_preparing')}}
                                                </option>
                                                <option
                                                    value="3" {{$item->status == '3'?'selected':''}}>
                                                    {{__('cp.ready_for_pickup')}}
                                                </option>
                                                <option
                                                    value="4" {{$item->status == '4'?'selected':''}}>
                                                    {{__('cp.completed')}}
                                                </option>
                                                <option
                                                    value="5" {{$item->status == '5'?'selected':''}}>
                                                    {{__('cp.canceled')}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.payment_method')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="payment_method"
                                                   value="{{@$item->payment_method=='1'?__('cp.online'):__('cp.cache_on_pickup')}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.payment_ref')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="payment_ref"
                                                   value="{{@$item->payment_id}}" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.customer_name')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="customer_name"
                                                   value="{{old('customer_name',@$item->customer_name)}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.customer_email')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="customer_email"
                                                   value="{{old('customer_email',@$item->customer_email)}}" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.customer_mobile')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                    value="{{@$item->customer_mobile}}  {{@$item->customer_second_mobile?'-':''}} {{@$item->customer_second_mobile}}" disabled/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.order_date')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->order_date}}"
                                                   disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.payment_status')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="payment_status"
                                                   value="{{@$item->payment_status==1 ?__('cp.payed') : __('cp.not_payed')}}" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header col-md-12">
                                <h3 class="card-title">{{__('cp.price')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.total')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->sub_total}}" disabled/>
                                        </div>
                                    </div>
                                    @if($item->discount > 0)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('cp.total_after_discount')}}</label>
                                                <input type="text" class="form-control form-control-solid"
                                                       value="{{@$item->total}}" disabled/>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>


                        @if($item->discount > 0)
                            <div class="card-header col-md-12">
                                <h3 class="card-title">{{__('cp.discount')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('cp.promo_code_name')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->promo_code_name}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('cp.promo_code_amount')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->promo_code_amount}}  {{$item->promo_code_type==0 ? '%' : ''}}" disabled/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('cp.total_discount')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->discount}}" disabled/>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        @endif

   @if($item->payment_method == 1 && $item->status ==5)
                            <div class="card-header col-md-12">
                                <h3 class="card-title">{{__('cp.refund')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>{{__('cp.status')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->payment_status==2 ? __('cp.refund_success'): __('cp.refund_error')}}" disabled/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('cp.refund_amount')</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->refund_amount}}" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Refund Id</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->refund_id}}" disabled/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Refund Reference</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->refund_reference}}" disabled/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Refund Key</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$item->refund_Key}}" disabled/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif


                            @foreach($item->meals as $one)
                                <div class="card-header col-md-12">
                                    <h3 class="card-title">{{@$one->meal->title}}</h3>
                                </div>
                                <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.quantity')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$one->quantity}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.price')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   value="{{@$one->price}}" disabled/>
                                        </div>
                                    </div>
                                </div>


                                    <div class="row">
                                        @if(count($one->extras) > 0)
                                            <div class="table-responsive col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('cp.extras')</label>
                                                </div>
                                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-1p no-sort">
                                                            <div class="checkbox-inline">
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="checkAll"/>
                                                                    <span></span></label>
                                                            </div>
                                                        </th>
                                                        <th class="wd-25p"> {{ucwords(__('cp.name'))}}</th>
                                                        <th class="wd-25p"> {{ucwords(__('cp.price'))}}</th>
                                                        <th class="wd-25p"> {{ucwords(__('cp.quantity'))}}</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($one->extras as $extra)
                                                        <tr class="odd gradeX" id="tr-{{$extra->id}}">
                                                            <td class="v-align-middle wd-5p">
                                                                <div class="checkbox-inline">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" value="{{$one->id}}" class="checkboxes"
                                                                               name="chkBox"/>
                                                                        <span></span></label>
                                                                </div>
                                                            </td>
                                                            <td class="v-align-middle wd-25p">{{@$extra->extra->name}}</td>
                                                            <td class="v-align-middle wd-25p">{{@$extra->price}}</td>
                                                            <td class="v-align-middle wd-25p">{{@$extra->quantity}}</td>
                                                        </tr>

                                                    @empty

                                                    @endforelse

                                                    <!-- Modal Backdrop for all -->

                                                    <!--Modal Create Folder -->

                                                    </tbody>
                                                </table>
                                                {{--                                                                                {{$item->appends($_GET)->links("pagination::bootstrap-4") }}--}}
                                            </div>
                                        @endif

                                        @if(count($one->options) > 0)
                                                <div class="table-responsive col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('cp.options')</label>
                                                </div>
                                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-1p no-sort">
                                                            <div class="checkbox-inline">
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="checkAll"/>
                                                                    <span></span></label>
                                                            </div>
                                                        </th>
                                                        <th class="wd-25p"> {{ucwords(__('cp.name'))}}</th>
                                                        <th class="wd-25p"> {{ucwords(__('cp.price'))}}</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($one->options as $option)
                                                        <tr class="odd gradeX" id="tr-{{$option->id}}">
                                                            <td class="v-align-middle wd-5p">
                                                                <div class="checkbox-inline">
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" value="{{$one->id}}" class="checkboxes"
                                                                               name="chkBox"/>
                                                                        <span></span></label>
                                                                </div>
                                                            </td>
                                                            <td class="v-align-middle wd-25p">{{@$option->option->name}}</td>
                                                            <td class="v-align-middle wd-25p">{{@$option->option->price}}</td>
                                                        </tr>

                                                    @empty

                                                    @endforelse
                                                    </tbody>
                                                </table>
                                                {{--                                                                                {{$item->appends($_GET)->links("pagination::bootstrap-4") }}--}}
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            @endforeach

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

@endsection
