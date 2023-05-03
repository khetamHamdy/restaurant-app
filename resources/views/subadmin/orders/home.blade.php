@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.orders'))}}
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
                        <h3>{{ucwords(__('cp.orders'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->


                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                        <a  class="btn btn-secondary" href="{{url('provider/pdfOrders')}}">
                            <i class="icon-xl la la-file-pdf"></i>
                            <span>PDF</span>
                        </a>
                        <a  class="btn btn-secondary" href="{{url('provider/OrdersExportForProvider/excel/orders')}}">
                            <i class="icon-xl la la-file-excel"></i>
                            <span>@lang('cp.excel')</span>
                        </a>
                        <button type="button" class="btn btn-secondary" href="#deleteAll" role="button"
                                data-toggle="modal">
                            <i class="flaticon-delete"></i>
                            <span>{{__('cp.delete')}}</span>
                        </button>
                    </div>
                    <!--<a href="{{url('')}}" class="btn btn-secondary  mr-2 btn-success">-->
                    <!--    <i class="icon-xl la la-plus"></i>-->
                    <!--    <span>{{__('cp.add')}}</span>-->
                    <!--</a>-->

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
                <div class="gutter-b example example-compact">

                    <div class="contentTabel">
                        <button type="button" class="btn btn-secondar btn--filter mr-2"><i
                                class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                        <div class="container box-filter-collapse">
                            <div class="card">
                                <form class="form-horizontal" method="get" action="{{url(getLocal().'/provider/orders')}}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">ID</label>
                                                <input type="text"
                                                       value="{{request('id')?request('id'):''}}"
                                                       class="form-control" name="id"
                                                       placeholder="ID">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.customer_name')}}</label>
                                                <input type="text"
                                                       value="{{request('customer_name')?request('customer_name'):''}}"
                                                       class="form-control" name="customer_name"
                                                       placeholder="{{__('cp.customer_name')}}">
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.customer_mobile')}}</label>
                                                <input type="number"
                                                       value="{{request('customer_mobile')?request('customer_mobile'):''}}"
                                                       class="form-control" name="customer_mobile"
                                                       placeholder="{{__('cp.customer_mobile')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.customer_email')}}</label>
                                                <input type="text"
                                                       value="{{request('customer_email')?request('customer_email'):''}}"
                                                       class="form-control" name="customer_email"
                                                       placeholder="{{__('cp.customer_email')}}">
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('cp.status')}}</label>
                                                <select class="form-control form-control"
                                                        name="status">
                                                    <option
                                                        value="">
                                                        {{__('cp.all')}}
                                                    </option>
                                                    <option
                                                        value="1" {{request('status')  == '1'?'selected':''}}>
                                                        {{__('cp.confirmed')}}
                                                    </option>
                                                    <option
                                                        value="2" {{request('status')  == '2'?'selected':''}}>
                                                        {{__('cp.under_preparing')}}
                                                    </option>
                                                    <option
                                                        value="3" {{request('status')  == '3'?'selected':''}}>
                                                        {{__('cp.ready_for_pickup')}}
                                                    </option>
                                                    <option
                                                        value="4" {{request('status')  == '4'?'selected':''}}>
                                                        {{__('cp.completed')}}
                                                    </option>
                                                    <option
                                                        value="5" {{request('status')  == '5'?'selected':''}}>
                                                        {{__('cp.canceled')}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('cp.payment_method')}}</label>
                                                <select class="form-control form-control"
                                                        name="payment_method">
                                                    <option
                                                        value="">
                                                        {{__('cp.all')}}
                                                    </option>
                                                    <option
                                                        value="1" {{request('payment_method')  == '1'?'selected':''}}>
                                                        {{__('cp.online')}}
                                                    </option>
                                                    <option
                                                        value="2" {{request('payment_method')  == '2'?'selected':''}}>
                                                        {{__('cp.cache_on_pickup')}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <button type="submit"
                                                    class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <a href="{{url(app()->getLocale().'/provider/orders')}}" type="submit"
                                               class="btn sbold btn-default btnRest">{{__('cp.reset')}}
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div
                            class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                            <div>


                            </div>

                        </div>
                        <div class="table-responsive">
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

                                <!--{{--                                                        <th class="wd-5p"> {{ucwords(__('cp.image'))}}</th>--}}-->
                                    <th class="wd-25p">ID</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.customer_name'))}}</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.customer_mobile'))}}</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.customer_email'))}}</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.total_price'))}}</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.payment_method'))}}</th>
                                    <th class="wd-10p"> {{ucwords(__('cp.status'))}}</th>
                                    <th class="wd-10p"> {{ucwords(__('cp.created'))}}</th>
                                    <th class="wd-15p"> {{ucwords(__('cp.action'))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($items as $one)
                                    <tr class="odd gradeX" id="tr-{{$one->id}}">
                                        <td class="v-align-middle wd-5p">
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="{{$one->id}}" class="checkboxes"
                                                           name="chkBox"/>
                                                    <span></span></label>
                                            </div>
                                        </td>

                                        <td class="v-align-middle wd-25p">{{@$one->id}}</td>
                                        <td class="v-align-middle wd-25p">{{$one->customer_name}}</td>
                                        <td class="v-align-middle wd-25p">{{$one->customer_mobile}}</td>
                                        <td class="v-align-middle wd-25p">{{$one->customer_email}}</td>
                                        <td class="v-align-middle wd-25p">{{$one->total}}</td>
                                        <td data-field="Status" aria-label="6" class="datatable-cell"><span
                                                style="width: 108px;"><span
                                                    class="label font-weight-bold label-lg  label-light-{{$one->payment_method==1?'success':'warning'}} label-inline">{{$one->payment_method==1?__('cp.online'):__('cp.cache_on_pickup')}}</span></span>
                                        </td>


                                        <td class="v-align-middle wd-10p"> <span id="label-{{$one->id}}"
                                                                                 class="badge badge-pill badge-{{$one->status_badge}}">
                                                {{$one->status_text}}</span>
                                        </td>

                                        <td class="v-align-middle wd-10p">{{$one->created_at->format('Y-m-d')}}</td>

                                        <td class="v-align-middle wd-15p optionAddHours">


                                            <a href="{{url(getLocal().'/provider/orders/'.$one->id.'/edit')}}"
                                               class="btn btn-sm btn-bg-clean btn-icon" title="{{__('cp.show')}}">
                                                <i class="la la-eye"></i>

                                            </a>
                                            <a  href="{{route('provider.invoice',[$one->id])}}" target="_blank"
                                                class="btn btn-sm btn-bg-clean btn-icon" title="{{__('cp.invoice')}}">
                                                <i class="flaticon-interface-10"></i>

                                            </a>

                                            @if($one->status !=4 && $one->status!=5)
                                            <a href="#myModal{{$one->id}}" role="button" title="{{__('cp.change_status')}}"
                                               data-toggle="modal" class="btn btn-sm btn-clean btn-icon"><i
                                                    class="las la-exchange-alt"></i></a>
                                            @endif

                                            @if($one->status == '5' && $one->payment_status !='2' && $one->payment_status == '1' && $one->payment_method == '1')
                                                <a href="{{url(getLocal().'/provider/refund/orders/'.$one->id)}}" class="btn btn-sm btn-bg-clean btn-icon" title="{{__('cp.refund')}}">
                                                    <i class="la la-reply"></i>
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                    <div id="myModal{{$one->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">{{__('cp.change_status')}}</h4>
                                                </div>
                                                <form method="post" action="{{route('provider.changeOrderStatus',[$one->id])}}">
                                                    @csrf
                                                <div class="modal-body">
                                           <div class="radio-list">
																<label class="radio">
																<input type="radio" {{$one->status == '1' ? 'checked="checked"' : ''}} name="status" value='1'>
																<span></span>@lang('cp.confirmed')</label>
															
																<label class="radio">
																<input type="radio" {{$one->status == '2' ? 'checked="checked"' : ''}} name="status" value='2'>
																<span></span>@lang('cp.under_preparing')</label>
															
															
																<label class="radio">
																<input type="radio" {{$one->status == '3' ? 'checked="checked"' : ''}} name="status" value='3'>
																<span></span>@lang('cp.ready_for_pickup')</label>
															
															
																<label class="radio">
																<input type="radio" {{$one->status == '4' ? 'checked="checked"' : ''}} name="status" value='4'>
																<span></span>@lang('cp.completed')</label>
															
															
																<label class="radio">
																<input type="radio" {{$one->status == '5' ? 'checked="checked"' : ''}} name="status" value='5'>
																<span></span>@lang('cp.canceled')</label>
															
															
															</div>
													
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn default" data-dismiss="modal" aria-hidden="true">{{__('cp.cancel')}}</button>
                                                    <button class="btn btn-primary submitStatusForm">{{__('cp.Yes')}}</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                               
                                    </div>


                                @empty
                                @endforelse

                                </tbody>
                            </table>
                            {{$items->appends($_GET)->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
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

