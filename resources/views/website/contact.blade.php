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
                <h2> {{__('cp.contact_us')}}</h2>
                <p>Booking request {{$subadmins->mobile}} or fill out the order form</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="thumb-reservation wow fadeInUp">
                        <img src="{{asset($subadmins->image_contact_us)}}" alt="Image"/>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="lst-contact">
                        <div class="item-contact wow fadeInUp">
                            <figure><i class="fa-solid fa-phone"></i></figure>
                            <div class="txt-contact">
                                <h5>{{__('cp.phone')}}</h5>
                                <p>{{$subadmins->mobile}} </p>
                            </div>
                        </div>
                        <div class="item-contact wow fadeInUp">
                            <figure><i class="fa-solid fa-envelope"></i></figure>
                            <div class="txt-contact">
                                <h5>{{__('cp.email')}}</h5>
                                <p>{{$subadmins->email}} </p>
                            </div>
                        </div>
                    </div>
                    <form class="form-reserv wow fadeInUp" method="post"
                          action="{{route('contact.store' , $subadmins->branch_name)}}">
                        @csrf
                        <input type="hidden" value="{{$subadmins->branch_name}}" id="branch_name">

                        <div class="form-group">
                            <label>{{__('cp.name')}}</label>
                            <input type="text" class="form-control" placeholder="Write Here" name="name" id="name_id"/>
                            <span class="text-danger" id="name_error"></span>
                        </div>
                        <div class="form-group">
                            <label>{{__('cp.phone')}} </label>
                            <input type="text" class="form-control" placeholder="Write Here" name="phone"
                                   id="phone_id"/>
                            <span class="text-danger" id="phone_error"></span>

                        </div>
                        <div class="form-group">
                            <label>{{__('cp.topic')}}</label>
                            <select class="form-control" name="topic" id="topic_id">
                                <option value="suggestion">{{__('cp.suggestion')}}</option>
                                <option value="complaint">{{__('cp.complaint')}}</option>
                            </select>
                            <span class="text-danger" id="topic_error"></span>

                        </div>
                        <div class="form-group">
                            <label>{{__('cp.additional_details')}} </label>
                            <textarea class="form-control" placeholder="Write Here" id="message_id"
                                      name="message"></textarea>
                            <span class="text-danger" id="message_error"></span>

                        </div>
                        <div class="form-group">
                            <button class="btn-site send_btn"><span>{{__('cp.send')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--section_home-->

@endsection


@section('js')

    <script>

        $(document).on('click', '.send_btn', function (e) {
            e.preventDefault();
            let branch_name = $('#branch_name').val();
            let name = $('#name_id').val();
            let topic = $('#topic_id').val();
            let phone = $('#phone_id').val();
            let message = $('#message_id').val();

            $.ajax({
                url: url(`${branch_name} +'/'+"contact"`),
                method: 'post',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    name: name,
                    topic: topic,
                    phone: phone,
                    message: message,
                },
                success: function (response) {
                    alert('done');
                    $('form').trigger("reset");
                    swal.fire(response.message, 'Message', "success");
                },
                error: function (error) {
                    $('#name_error').text(error.responseJSON.errors.name);
                    $('#phone_error').text(error.responseJSON.errors.phone);
                    $('#topic_error').text(error.responseJSON.errors.topic);
                    $('#message_error').text(error.responseJSON.errors.message);
                }
            });

        });
    </script>
@endsection
