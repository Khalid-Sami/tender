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
    <title>Company Account</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{ asset('/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ asset('/assets/pages/css/login.min.css') }}" rel="stylesheet" type="text/css"/>
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
                <!-- BEGIN REGISTRATION FORM -->
        {!! Form::open(['method' => 'post', 'action' => 'RegisterController@storeServiceProvider','class'=>'register']) !!}


        <h3 class="font-green">Company Account</h3>
        <h4 class="font-green">Account Information</h4>
        <div class="form-group">
            {!! Form::label('first_name','First Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('first_name', old('first_name'),['class' =>'form-control placeholder-no-fix','placeholder'=>'First Name']) !!}
            @if($errors->has('first_name'))
                <strong class="font-red">{{ $errors->first('first_name') }}</strong>
            @endif
        </div>

        <div class="form-group">
            {!! Form::label('last_name','Last Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('last_name', old('last_name'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Last Name']) !!}
            @if($errors->has('last_name'))
                <strong class="font-red">{{ $errors->first('last_name') }}</strong>
            @endif
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            {!! Form::label('user_email','Email',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('user_email', old('user_email'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Email']) !!}
            @if($errors->has('user_email'))
                <strong class="font-red">{{ $errors->first('user_email') }}</strong>
            @endif

        </div>

        <div class="form-group">
            {!! Form::label('user_mobile_number','Mobile Number',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('user_mobile_number', old('user_mobile_number'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Mobile Number']) !!}
            @if($errors->has('user_mobile_number'))
                <strong class="font-red">{{ $errors->first('user_mobile_number') }}</strong>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('password','Password',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::input('password','password', old('password'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Password']) !!}
            @if($errors->has('password'))
                <strong class="font-red">{{ $errors->first('password') }}</strong>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('confirm','Re-type Your Password',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::input('password','confirm', old('confirm'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Re-type Your Password']) !!}
            @if($errors->has('confirm'))
                <strong class="font-red">{{ $errors->first('confirm') }}</strong>
            @endif
        </div>

        <h4 class="font-green">Company Information</h4>
        <div class="form-group">
            {!! Form::label('service_provider_name_ar','Service Provider Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_name_ar', old('service_provider_name_ar'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Company (Arabic)']) !!}
            @if($errors->has('service_provider_name_ar'))
                <strong class="font-red">{{ $errors->first('service_provider_name_ar') }}</strong>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('service_provider_name_en','Service Provider Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_name_en', old('service_provider_name_en'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Company (English)']) !!}
            @if($errors->has('service_provider_name_en'))
                <strong class="font-red">{{ $errors->first('service_provider_name_en') }}</strong>
            @endif
        </div>
        {{--<div class="form-group">--}}
            {{--{!! Form::label('company_name','Company Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}--}}
            {{--{!! Form::text('company_name', old('company_name'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Company Name']) !!}--}}
            {{--@if($errors->has('company_name'))--}}
                {{--<strong class="font-red">{{ $errors->first('company_name') }}</strong>--}}
            {{--@endif--}}
        {{--</div>--}}

        <div class="form-group">
            {!! Form::label('service_provider_telephone_number','Telephone Number',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_telephone_number', old('clinic_telephone_number'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Telephone Number']) !!}
            @if($errors->has('service_provider_telephone_number'))
                <strong class="font-red">{{ $errors->first('service_provider_telephone_number') }}</strong>
            @endif
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            {!! Form::label('service_provider_email','Email',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_email', old('service_provider_email'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Email']) !!}
            @if($errors->has('service_provider_email'))
                <strong class="font-red">{{ $errors->first('service_provider_email') }}</strong>
            @endif

        </div>

        <div class="form-group">
            {!! Form::label('service_provider_mobile_number','Mobile Number',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_mobile_number', old('service_provider_mobile_number'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Mobile Number']) !!}
            @if($errors->has('service_provider_mobile_number'))
                <strong class="font-red">{{ $errors->first('service_provider_mobile_number') }}</strong>
            @endif
        </div>


        <div class="form-actions">
            <a href="{{url('/')}}/login" type="button" class="btn green btn-outline">Back</a>
            {{--<a href="{{url('/')}}/login"  class="btn btn-success">Already have account?</a>--}}
            {!! Form::submit('Register',['class' =>'btn btn-success uppercase pull-right','id'=>'register-submit-btn']) !!}
        </div>

        <div class="create-account">
            <p>
                <a href="{{url('/')}}/login" id="register-btn" class="uppercase">Already have account ?</a>
            </p>
        </div>

        {!! Form::close() !!}
                <!-- END REGISTRATION FORM -->
</div>
{{--<div class="copyright"> 2014 © Metronic. Admin Dashboard Template. </div>--}}
<!--[if lt IE 9]>
<script src="{{ asset('/assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ asset('/assets/global/plugins/excanvas.min.js') }}"></script>
<script src="{{ asset('/assets/global/plugins/ie8.fix.min.js') }}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->


</body>

</html>