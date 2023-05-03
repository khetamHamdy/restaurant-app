<!DOCTYPE html>
<html
    lang="{{ App::currentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}"
>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=G-PN4W1TBCSH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'G-PN4W1TBCSH');
    </script>
    <!-- end:: Global site tag (gtag.js) - Google Analytics -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title> @yield('title')</title>
    <!-- Stylesheets -->
    <link rel="icon" href="{{@$setting->favicon}}">


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Restaurant</title>
    <!-- Stylesheets -->
    <link rel="icon" href="{{asset('website/images/favicon.svg')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
    <link href="{{asset('website/css/style.css')}}" rel="stylesheet">
    <!-- Responsive -->
    <link href="{{asset('website/css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if lt IE 9]>
    <script src="{{asset('website/js/respond.js')}}"></script><![endif]-->
    <script src="{{asset('website/js/jquery-3.2.1.min.js')}}"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    {{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>--}}
    {{--    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}

    {{--    @if(app()->getLocale() == 'ar')--}}
    {{--		 <link href="{{asset('website/css/rtl.css')}}" rel="stylesheet" type="text/css" />--}}
    {{--	@endif--}}
    @yield('css')
</head>

<body>

<div class="main-wrapper">

    <header id="header">
        <div class="container">
            <div class="logo-site">
                <a href="index.blade.php">
                    <img src="{{$subadmins->image}}" alt=""/>
                </a>
            </div>
            <ul class="main_menu clearfix">

                <li class="hide-mobile @if(Route::currentRouteName() == 'sub_home') active @endif">
                    <a class="page-scroll" href="{{route('sub_home' ,$subadmins->branch_name)}}">{{__('cp.home')}}</a>
                </li>

                @if($subadmins->is_about_us=='active')
                    <li class="@if(Route::currentRouteName() == 'about') active @endif">
                        <a class="page-scroll"
                           href="{{route('about' ,$subadmins->branch_name)}}"> {{__('cp.about')}}</a></li>
                @endif

                @if($subadmins->is_menu=='active')
                    <li class="hide-mobile @if(Route::currentRouteName() == 'menu') active @endif">
                        <a class="page-scroll" href="{{route('menu' ,$subadmins->branch_name)}}">{{__('cp.menu')}}</a>
                    </li>
                @endif

                @if($subadmins->is_reservation=='active')
                    <li class="hide-mobile @if(Route::currentRouteName() == 'reservation') active @endif">
                        <a class="page-scroll"
                           href="{{route('reservation' ,$subadmins->branch_name)}}">{{__('cp.reservation')}}</a>
                    </li>
                @endif


                @if($subadmins->is_chef=='active')
                    <li class="hide-mobile @if(Route::currentRouteName() == 'chef') active @endif">
                        <a class="page-scroll" href="{{route('chef' ,$subadmins->branch_name)}}">{{__('cp.chefs')}}</a>
                    </li>
                @endif

                @if($subadmins->is_gallery=='active')
                    <li class="hide-mobile @if(Route::currentRouteName() == 'photos') active @endif">
                        <a class="page-scroll"
                           href="{{route('photos' ,$subadmins->branch_name)}}">{{__('cp.gallery')}}</a></li>
                @endif

                @if($subadmins->is_contactUs=='active')
                    <li class="hide-mobile @if(Route::currentRouteName() == 'contact') active @endif">
                        <a class="page-scroll"
                           href="{{route('contact' ,$subadmins->branch_name)}}">{{__('cp.contact_info')}}</a></li>
                @endif

                <li class="lang-site">
                    @if(app()->getLocale()=='ar')
                        <a class="page-scroll" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">English </a>
                    @elseif(app()->getLocale()=='en')
                        <a class="page-scroll" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">عربي</a>
                    @endif
                </li>


            </ul>
            <ul class="opt-mobail">
                <li><a href="{{route('home' ,$subadmins->branch_name)}}"><i
                            class="fa-solid fa-house"></i><span>Home</span></a></li>
                <li><a href="{{route('menu' ,$subadmins->branch_name)}}"><i
                            class="fa-solid fa-utensils"></i><span>Menu</span></a></li>
                <li><a href="{{route('reservation' ,$subadmins->branch_name)}}"><i
                            class="fa-solid fa-toilet-portable"></i><span>Reservation</span></a>
                </li>
                <li><a class="hamburger"><i class="fa-solid fa-bars"></i><span>Other</span></a></li>
            </ul>
        </div>
    </header>
    <!--header-->
    @yield('content')

    @if(Route::currentRouteName() != 'sub_home')
        <footer id="footer">
            <div class="container">
                <div class="cont-bt">
                    <p class="copyRight wow fadeInUp">Copyright © 2022 HexaQR. Co. - All
                        Rights Reserved</p>
                    <p>Powered By <a href="https://hexacit.com/">Hexa CIT</a></p>
                </div>
            </div>
        </footer>
        <!--footer-->
    @endif
    <!--main-wrapper-->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/all.min.js')}}"></script>
    <script src="{{asset('website/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('website/js/wow.js')}}"></script>
    <script src="{{asset('website/js/jquery.easing.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="{{asset('website/js/script.js')}}"></script>
    <script>
        new WOW().init();
        Fancybox.bind("[data-fancybox-plyr]", {
            on: {
                reveal: (fancybox, slide) => {
                    if (typeof Plyr === undefined) {
                        return;
                    }

                    let $el;

                    if (slide.type === "html5video") {
                        $el = slide.$content.querySelector("video");
                    } else if (slide.type === "video") {
                        $el = document.createElement("div");
                        $el.classList.add("plyr__video-embed");

                        $el.appendChild(slide.$iframe);

                        slide.$content.appendChild($el);
                    }

                    if ($el) {
                        slide.player = new Plyr($el);
                    }
                },
                "Carousel.unselectSlide": (fancybox, carousel, slide) => {
                    if (slide.player) {
                        slide.player.pause();
                    }
                },
                "Carousel.selectSlide": (fancybox, carousel, slide) => {
                    if (slide.player) {
                        slide.player.play();
                    }
                },
            },
        });
    </script>

@yield('js')
@yield('script')
</body>

</html>
