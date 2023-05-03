@extends('layout.siteLayout')
@section('content')

        <div class="banner-page" style="background: url({{asset($page->image)}});">
            <div class="container">
                <div class="txt-banner wow fadeInUp">
                    <h3>{{$page->title}}</h3>
                </div>
            </div>
        </div>

        @if($subadmins->title_about != '')
        <section class="section_page_site">
            <div class="container">
                <div class="sec_head wow fadeInUp">
                    <h2>Welcome to you</h2>
                    <p> Let's get to know the family of Al-Hana restaurant</p>
                </div>
                <div class="cont-founder">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="thumb-founder wow fadeInUp">
                                <figure><img src="{{$subadmins->image_about}}" alt="" /></figure>
                                <div class="sec-experience">
                                    <div class="cont-exper">
                                        <h2>{{$subadmins->experiense_years_count}}</h2>
                                        <p>Years Experiense</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ph-founder wow fadeInUp">
                                <h2>{{$subadmins->title_about}}</h2>
                                <p>
                                    {{$subadmins->descrption_about}}
                                </p>

                                <figure>><img src="{{asset('images/signature.png')}}" alt="" /></figure>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cont-video">
                    <div class="thumb-video wow fadeInUp">
                        <img src="{{$subadmins->video_about}}" alt="Image" />
                        <div class="pt-video-icon">
                            <a data-fancybox-plyr href="{{$subadmins->youtube_link}}" class="pt-video default popup-youtube">
                                <i class="fa-solid fa-play"></i></a>
                        </div>
                    </div>
                </div>
                <div class="cont-whyus">
                    <div class="sec_head wow fadeInUp">
                        <h2>Why Us</h2>
                        <p>A set of features that distinguish us at Al Hana Restaurant</p>
                    </div>
                    <div class="row">
                        @foreach($uses as $one)
                        <div class="col-lg-4">
                            <div class="item-feat wow fadeInUp">
                                <div class="num-feat">
                                    <span>{{$one->order}}</span>
                                </div>
                                <div class="txt-feat">
                                    <h3>{{$one->title}}</h3>
                                    <p>
                                        {{$one->description}} </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif
        <!--section_home-->
@endsection
