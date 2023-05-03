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
                <div class="row">
                    @foreach($gallery as $one)
                    <div class="col-lg-4">
                        <div class="thumb-gallery wow fadeInUp">
                            <a data-fancybox="gallery" href="{{asset($one->image)}}"><img src="{{asset($one->image)}}" alt="Image" /></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--section_home-->
@endsection
