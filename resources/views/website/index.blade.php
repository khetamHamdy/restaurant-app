@extends('layout.siteLayout')
@section('content')
    <section class="section_home">

        <div class="owl-carousel" id="slide-home">
            @foreach($slider as $one)
                <div class="item" style="background: url({{asset($one->image)}})">
                </div>
            @endforeach

        </div>
    </section>
    <!--section_home-->
@endsection
