@extends('layout.siteLayout')
@section('content')

        <div class="banner-page" style="background: url({{asset($page->image)}});">
            <div class="container">
                <div class="txt-banner wow fadeInUp">
                    <h3>{{$page->title}}</h3>
                </div>
            </div>
        </div>

        <section class="section_page_site">
            <div class="container">
                <div class="sec_head wow fadeInUp">
                    <h2>{{__('cp.our_chef')}}</h2>
                </div>
                <div class="row">
                    @foreach($chefs as $one)
                    <div class="col-lg-4">
                        <div class="item-chef wow fadeInUp">
                            <figure><img src="{{asset($one->image)}}" alt="Chef" /></figure>
                            <div class="txt-chef">
                                <h5>{{$one->name}}</h5>
                                <p> {{$one->job_title}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--section_home-->
@endsection
