<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<section class="section_page_site">
    <div class="container">
        <div class="sec-head">
            <h2>@lang('website.Forgot PASSWORD')</h2>
        </div>
        <div class="content-order">
            <form class="form-account" method="POST" action="{{ route('password.new') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">


                    <input id="email" type="email" class="form-control" placeholder="@lang('website.email')" name="email" value="{{ $email or old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>



                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">



                    <input id="password" type="password" class="form-control" placeholder="@lang('website.email')" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif

                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">


                    <input id="password-confirm" type="password" class="form-control" placeholder="@lang('website.password_confirmation')" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                    @endif

                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">

                        <button class="btn-site h60 sendForm"><span>@lang('website.Send')</span></button>

                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>


    </div>
    </div>
</section>

</body>
</html>




