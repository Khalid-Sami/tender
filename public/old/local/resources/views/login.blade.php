<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>Services</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css"/>
    <link href="{{asset('/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{asset('/assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->

    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<body class=" login">

<!-- BEGIN LOGIN -->
<div class="content">
    @if(session('msg'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('msg') }}
        </div>
    @endif
    @if(session('error_msg'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('error_msg') }}
        </div>
    @endif

    @if(session('resend'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('resend') }}
            <a href="#">resend</a>
        </div>
        @endif

                <!-- BEGIN LOGIN FORM -->
        {!! Form::open(['method' => 'post', 'action' => 'LoginController@check','class'=>'login-form']) !!}
        <h3 class="form-title font-green">Sign In</h3>

        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            {!! Form::label('email','Email',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('email', null,['class' =>'form-control placeholder-no-fix','placeholder'=>'Email','autocomplete' => 'off']) !!}
            @if($errors->has('email'))
                <strong class="font-red">{{ $errors->first('email') }}</strong>
            @endif

        </div>
        <div class="form-group">
            {!! Form::label('password','Password',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::input('password','password', null,['class' =>'form-control placeholder-no-fix','placeholder'=>'Password']) !!}
            @if($errors->has('password'))
                <strong class="font-red">{{ $errors->first('password') }}</strong>
            @endif
        </div>

        <div class="form-actions">
            {!! Form::submit('Login',['class' => 'btn green uppercase']) !!}
            <a href="{{url('/')}}/restore" id="forget-password" class="forget-password">Forgot Password?</a>
        </div>
            <div class="form-actions">
            <a href="{{route('auth.login','google')}}" class="btn"><i class="fa fa-google" aria-hidden="true"></i>Google Login</a>
            <a href="{{route('auth.login','facebook')}}" class="btn"><i class="fa fa-facebook"></i> Facebook</a>
        </div>
        <div class="create-account">
            <p>
                <a href="{{ action('LoginController@register') }}" id="register-btn" class="uppercase">Create an account</a>
            </p>
        </div>

        {!! Form::close() !!}
                <!-- END LOGIN FORM -->
</div>
{{--<div class="copyright"> 2014 © Metronic. Admin Dashboard Template. </div>--}}
<!--[if lt IE 9]>
<script src="{{asset('/assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('/assets/global/plugins/excanvas.min.js')}}"></script>
<script src="{{asset('/assets/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/moment-timezone-with-data.min.js')}}" type="text/javascript"></script>

<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->



<script>

    // get user timezone
    var timezone = moment.tz.guess();
    //    alert(timezone);
    var token = "{{ csrf_token() }}";
    $.ajax({
        method: "POST",
        dataType: "json",
        url: '{{url('/')}}/client/timezone',
        data: {
            "_token": token,
            'timezone': timezone
        },
        success: function (data, textStatus, jqXHR) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
</script>

</body>

</html>

