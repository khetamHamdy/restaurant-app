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
                    <h2>{{__('cp.DeliciousMenu')}}</h2>
                    <p>{{__('cp.chose_menu')}}</p>
                </div>
                <div class="owl-carousel" id="categori-menu">
                    @foreach($categories as $one)
                    <div class="item">
                        <div class="main-categ">
                            <a href="">{{$one->name}}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">

                    @foreach($categories as $one1)
                    @foreach($one1->meals as $one)

                    <div class="col-lg-6">
                        <div class="item-menu">
                            <figure><img src="{{$one->image}}" alt="" /></figure>
                            <div class="txt-menu">
                                <h4>{{$one->title}}</h4>
                                <p>{!!  $one->description!!}</p>
                                <div class="prc-qty">
                                    <h2>{!!  $one->price!!}</h2>
                                    <a href=""><i class="fa-solid fa-basket-shopping"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                </div>
            </div>
        </section>
        <!--section_home-->
@endsection
