@extends('layout.siteLayout')
@section('css')

@endsection

@section('content')

<section class="section_not_found">
		    <div class="container">
                <div class="cont-not-found">
                    <div class="thumb-not-found wow fadeInUp">
                        <figure><img src="{{asset('website/images/404.png')}}" alt="Images 404" /></figure>
                    </div>
                    <div class="txt-not-found wow fadeInUp">
                        <strong class="text-white">404</strong>
                        <h5 class="text-white">{{__('web.PageNotFound')}} !</h5>
                        <p class="text-white">{{__('web.we’re sorry, the page you requested could not be found.Please go back')}}. </p>
                        <a href="{{route('home' ,$subadmins->branch_name)}}" class="btn-site"><span>{{__('web.GoBack')}}</span></a>
                    </div>
                </div>
		    </div>
		</section>
@endsection

@section('script')
<script>
    $("#backLink").click(function(event) {
        event.preventDefault();
        history.back(1);
    });
</script>
@endsection

