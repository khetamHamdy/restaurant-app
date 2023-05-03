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
                <h2>{{__('cp.book_table')}}</h2>
                <p>{{__('cp.booking_request')}} {{ $subadmins->mobile }}</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="thumb-reservation wow fadeInUp">
                        <img src="{{asset($subadmins->image_reservation)}}" alt="Image"/>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="form-reserv wow fadeInUp" method="post"
                    >
                        @csrf
                        <div class="form-group">
                            <input type="hidden" value="{{$subadmins->branch_name}}" id="branch_name">
                            <label> {{__('cp.name')}}</label>
                            <input type="text" class="form-control" id="input_full_name" placeholder="Write Here"
                                   name="full_name"/>
                            <span class="text-danger" id="name_error"></span>
                        </div>
                        <div class="d-flex">
                            <div class="form-group">
                                <label>{{__('cp.mobile')}} </label>
                                <input type="text" class="form-control" id="input_mobile" placeholder="Write Here" \
                                       name="mobile"/>
                                <span class="text-danger" id="mobile_error"></span>
                            </div>
                            <div class="form-group">
                                <label>{{__('cp.persons')}}</label>
                                <input type="text" class="form-control" id="input_persons"
                                       placeholder="Write Persons" name="persons"/>
                                <span class="text-danger" id="persons_error"></span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-group">
                                <label>{{__('cp.date')}}</label>
                                <input type="text" class="form-control" placeholder="Choose Date" id="input_date"
                                       name="date"/>
                                <span class="text-danger" id="date_error"></span>
                            </div>
                            <div class="form-group">
                                <label>{{__('cp.time')}}</label>
                                <input type="text" class="form-control" placeholder="Choose Time"
                                       id="input_time" name="time"/>
                                <span class="text-danger" id="time_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{__('cp.additional_details')}}</label>
                            <textarea class="form-control" placeholder="Write Here" id="input_description_details"
                                      name="description_details"></textarea>
                            <span class="text-danger" id="additional_details_error"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn-site click_action"><span>{{__('cp.BookTable')}}</span></button>
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

        $(document).on('click', '.click_action', function (e) {
            e.preventDefault();
            let branch_name = $('#branch_name').val();
            let full_name = $('#input_full_name').val();
            let mobile = $('#input_mobile').val();
            let persons = $('#input_persons').val();
            let date = $('#input_date').val();
            let time = $('#input_time').val();
            let description_details = $('#input_description_details').val();

            $.ajax({
                url: url(`${branch_name} +'/'+"reservation"`),
                method: 'post',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    full_name: full_name,
                    mobile: mobile,
                    persons: persons,
                    date: date,
                    time: time,
                    description_details: description_details,
                },
                success: function (response) {
                    alert('done');
                    $('form').trigger("reset");
                    swal.fire(response.message, 'Message', "success");
                },
                error: function (error) {
                    $('#name_error').text(error.responseJSON.errors.full_name);
                    $('#mobile_error').text(error.responseJSON.errors.mobile);
                    $('#persons_error').text(error.responseJSON.errors.persons);
                    $('#date_error').text(error.responseJSON.errors.date);
                    $('#time_error').text(error.responseJSON.errors.time);
                    $('#additional_details_error').text(error.responseJSON.errors.description_details);
                }
            });

        });
    </script>
@endsection
