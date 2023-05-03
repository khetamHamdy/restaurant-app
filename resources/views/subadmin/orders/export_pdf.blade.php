@extends('layout.exportPdfLayout')
@section('content')
    <tr>
        <th>ID</th>
        <th>@lang('cp.customer_name')</th>
        <th>@lang('cp.customer_mobile')</th>
        <th>@lang('cp.customer_email')</th>
        <th>@lang('cp.total_price')</th>
        <th>@lang('cp.payment_method')</th>
        <th>@lang('cp.status')</th>
        <th>@lang('cp.created')</th>
    </tr>
    @foreach($items as $one)
        <tr>
            <td>{{$one->id}}</td>
            <td>{{@$one->customer_name}}</td>
            <td>{{@$one->customer_mobile}}</td>
            <td>{{@$one->customer_email}}</td>
            <td>{{@$one->total}}</td>
            <td>{{$one->payment_method==1?__('cp.online'):__('cp.cache_on_pickup')}}</td>
            <td>{{$one->status_text}}</td>
            <td>{{$one->created_at->format('Y-m-d')}}</td>
        </tr>
    @endforeach

@endsection



