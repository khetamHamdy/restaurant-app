@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.orders'))}} - {{ucwords(__('cp.report'))}}
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
                        <h3>{{ucwords(__('cp.orders_report'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->


                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                        <a  class="btn btn-secondary btn_export">
                            <i class="icon-xl la la-file-excel"></i>
                            <span>{{__('cp.report')}}</span>
                        </a>
                    </div>

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
                                <form class="form-horizontal form_filter" method="get" action="{{url(getLocal().'/provider/report/orders')}}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.from')}}</label>
                                                <input type="date"
                                                       value="{{request('from')?request('from'):''}}"
                                                       class="form-control" name="from"
                                                       placeholder="{{__('cp.from')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.to')}}</label>
                                                <input type="date"
                                                       value="{{request('to')?request('to'):''}}"
                                                       class="form-control" name="to"
                                                       placeholder="{{__('cp.to')}}">
                                            </div>
                                        </div>



                                        <div class="col-md-4">
                                            <button type="submit"
                                                    class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <a href="{{url(app()->getLocale().'/provider/report/orders')}}" type="submit"
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

                                <!--{{--                                                        <th class="wd-5p"> {{ucwords(__('cp.image'))}}</th>--}}-->
                                    <th class="wd-25p"> ID</th>
{{--                                    <th class="wd-25p"> {{ucwords(__('cp.vendor'))}}</th>--}}
                                    <th class="wd-25p"> {{ucwords(__('cp.amount'))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($items as $one)
                                    <tr class="odd gradeX" id="tr-{{$one->id}}">

                                        <td class="v-align-middle wd-25p">{{@$one->id}}</td>
{{--                                        <td class="v-align-middle wd-25p">{{@$one->provider->name}}</td>--}}
                                        <td class="v-align-middle wd-25p">{{$one->total}}</td>
                                    </tr>
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

@section('script')
    <script>
        $(document).on('click','.btn_export',function () {
            $('.form_filter').attr('action', "{{url('provider/OrdersReportForProvider/excel/orders')}}");
            $('.form_filter').submit();
            $('.form_filter').attr('action', "{{url(getLocal().'/provider/report/orders')}}");
        })
    </script>
@endsection
