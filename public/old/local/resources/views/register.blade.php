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
    <link href="{{url('/')}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('/')}}/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css"/>
    <link href="{{url('/')}}/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{url('/')}}/assets/pages/css/login.min.css" rel="stylesheet" type="text/css"/>
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
        {!! Form::open(['method' => 'post', 'action' => 'RegisterController@store','class'=>'register']) !!}
        <h3 class="font-green">Service Account</h3>
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
            {!! Form::label('email','Email',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('email', old('email'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Email']) !!}
            @if($errors->has('email'))
                <strong class="font-red">{{ $errors->first('email') }}</strong>
            @endif

        </div>

        <div class="form-group">
            {!! Form::label('mobile_number','Mobile Number',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('mobile_number', old('mobile_number'),['class' =>'form-control placeholder-no-fix','placeholder'=>'Mobile Number']) !!}
            @if($errors->has('mobile_number'))
                <strong class="font-red">{{ $errors->first('mobile_number') }}</strong>
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
        <div class="form-actions">
            <a href="/participation" type="button" class="btn green btn-outline">Back</a>
            {!! Form::submit('Register',['class' =>'btn btn-success uppercase pull-right','id'=>'register-submit-btn']) !!}
        </div>
        {!! Form::close() !!}
                <!-- END REGISTRATION FORM -->
</div>
{{--<div class="copyright"> 2014 © Metronic. Admin Dashboard Template. </div>--}}
<!--[if lt IE 9]>
<script src="{{url('/')}}/assets/global/plugins/respond.min.js"></script>
<script src="{{url('/')}}/assets/global/plugins/excanvas.min.js"></script>
<script src="{{url('/')}}/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{url('/')}}/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('/')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->


</body>

</html>