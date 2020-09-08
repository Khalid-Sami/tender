@extends('_layout')
@section('style')

@endsection
@section('title')
    {{trans('lang.system_settings')}}
@endsection
@section('head_title')
    {{trans('lang.system_settings')}}
@endsection

@section('msg')
    @if(session('msg'))
        <div class="alert alert-success alert-dismissible text-center"
             style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('msg') }}
        </div>
    @endif
    @if(session('error_msg'))
        <div class="alert alert-danger alert-dismissible text-center"
             style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('error_msg') }}
        </div>
    @endif
@endsection
@section('content')
    @if(!$settings->isEmpty())
        <div class="row">

            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase"></span>
                                </div>
                                <ul class="nav nav-tabs">
                                    @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state'))
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">@lang('lang.website_info')</a>
                                        </li>
                                    @else
                                        <li class="{{session('tab1_state')?session('tab1_state'):''}}">
                                            <a href="#tab_1_1" data-toggle="tab">@lang('lang.website_info')</a>
                                        </li>
                                    @endif

                                    <li class="{{session('tab2_state')?session('tab2_state'):''}}">
                                        <a href="#tab_1_2" data-toggle="tab">@lang('lang.smtp_info')</a>
                                    </li>
                                    <li class="{{session('tab3_state')?session('tab3_state'):''}}">
                                        <a href="#tab_1_3" data-toggle="tab">@lang('lang.sms_information')</a>
                                    </li>
                                    {{--<li id="mapTab" class="{{session('tab4_state')?session('tab4_state'):''}}">--}}
                                    {{--<a href="#tab_1_4" data-toggle="tab">@lang('lang.general_settings')</a>--}}
                                    {{--</li>--}}

                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state') )
                                        <div class="tab-pane active" id="tab_1_1">
                                            @else
                                                <div class="tab-pane {{session('tab1_state')?session('tab1_state'):''}}"
                                                     id="tab_1_1">
                                                    @endif


                                                    {!! Form::open(['id'=>'tab1Form','method' => 'post', 'action' => 'AdminController@storeSystemSettings']) !!}
                                                    <div class="form-group">
                                                        {!! Form::hidden('method','tab1') !!}
                                                        {!! Form::label('website_name',trans('lang.website_name'),['class'=>'control-label']) !!}
                                                        <span class="required font-red">*</span>
                                                        {!! Form::text('website_name',$settings->get('website_title')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('website_name'))
                                                            <strong class="font-red">{{ $errors->first('website_name') }}</strong>
                                                        @endif

                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('website_email',trans('lang.website_email'),['class'=>'control-label']) !!}
                                                        <span class="required font-red">*</span>
                                                        {!! Form::text('website_email',$settings->get('super_admin_email')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('website_email'))
                                                            <strong class="font-red">{{ $errors->first('website_email') }}</strong>
                                                        @endif

                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('website_url',trans('lang.website_url'),['class'=>'control-label']) !!}
                                                        {!! Form::text('website_url',$settings->get('website_url')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('website_url'))
                                                            <strong class="font-red">{{ $errors->first('website_url') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('facebook_url',trans('lang.facebook_url'),['class'=>'control-label']) !!}
                                                        {!! Form::text('facebook_url',$settings->get('facebook_url')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('facebook_url'))
                                                            <strong class="font-red">{{ $errors->first('facebook_url') }}</strong>
                                                        @endif

                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('twitter_url',trans('lang.twitter_url'),['class'=>'control-label']) !!}
                                                        {!! Form::text('twitter_url',$settings->get('twitter_url')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('twitter_url'))
                                                            <strong class="font-red">{{ $errors->first('twitter_url') }}</strong>
                                                        @endif
                                                    </div>


                                                    <div class="form-group" style="margin-top: 10px;">
                                                        {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}
                                                    </div>

                                                    {!! Form::close() !!}


                                                </div>
                                                <!-- END PERSONAL INFO TAB -->
                                                <!-- CHANGE AVATAR TAB -->
                                                <div class="tab-pane {{session('tab2_state')?session('tab2_state'):''}}"
                                                     id="tab_1_2">

                                                    {!! Form::open(['id'=>'tab2Form','method' => 'post', 'action' => 'AdminController@storeSystemSettings']) !!}
                                                    <div class="form-group">
                                                        {!! Form::hidden('method','tab2') !!}
                                                        {!! Form::label('smtp_mail_server',trans('lang.smtp_mail_server'),['class'=>'control-label']) !!}
                                                        <span class="required font-red">*</span>
                                                        {!! Form::text('smtp_mail_server',$settings->get('smtp_mail_server')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('smtp_mail_server'))
                                                            <strong class="font-red">{{ $errors->first('smtp_mail_server') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('smtp_port',trans('lang.smtp_port'),['class'=>'control-label']) !!}
                                                        <span class="required font-red">*</span>
                                                        {!! Form::text('smtp_port',$settings->get('smtp_port')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('smtp_port'))
                                                            <strong class="font-red">{{ $errors->first('smtp_port') }}</strong>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('smtp_email',trans('lang.smtp_email'),['class'=>'control-label']) !!}
                                                        <span class="required font-red">*</span>
                                                        {!! Form::text('smtp_email',$settings->get('smtp_email')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('smtp_email'))
                                                            <strong class="font-red">{{ $errors->first('smtp_email') }}</strong>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('smtp_password',trans('lang.smtp_password'),['class'=>'control-label']) !!}
                                                        <span class="required font-red">*</span>
                                                        {!! Form::text('smtp_password',$settings->get('smtp_password')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('smtp_password'))
                                                            <strong class="font-red">{{ $errors->first('smtp_password') }}</strong>
                                                        @endif

                                                    </div>

                                                    <div class="margin-top-10">
                                                        {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}

                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                                <!-- END CHANGE AVATAR TAB -->
                                                <!-- CHANGE PASSWORD TAB -->
                                                <div class="tab-pane {{session('tab3_state')?session('tab3_state'):''}}"
                                                     id="tab_1_3">

                                                    {!! Form::open(['id'=>'tab3Form','method' => 'post', 'action' => 'AdminController@storeSystemSettings']) !!}

                                                    <div class="form-group">
                                                        {!! Form::hidden('method','tab3') !!}
                                                        {!! Form::label('sms_api_url',trans('lang.sms_api_url'),['class'=>'control-label']) !!}
                                                        <span class="required" aria-required="true"> * </span>
                                                        {!! Form::text('sms_api_url',$settings->get('sms_api_url')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('sms_api_url'))
                                                            <strong class="font-red">{{ $errors->first('sms_api_url') }}</strong>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('sms_api_var',trans('lang.sms_api_var'),['class'=>'control-label']) !!}
                                                        <span class="required" aria-required="true"> * </span>
                                                        {!! Form::text('sms_api_var1',$settings->get('sms_api_var1')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('sms_api_var'))
                                                            <strong class="font-red">{{ $errors->first('sms_api_var') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('sms_api_var',trans('lang.sms_api_var'),['class'=>'control-label']) !!}
                                                        <span class="required" aria-required="true"> * </span>
                                                        {!! Form::text('sms_api_var2',$settings->get('sms_api_var2')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('sms_api_var'))
                                                            <strong class="font-red">{{ $errors->first('sms_api_var') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('sms_api_var',trans('lang.sms_api_var'),['class'=>'control-label']) !!}
                                                        <span class="required" aria-required="true"> * </span>
                                                        {!! Form::text('sms_api_var3',$settings->get('sms_api_var3')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('sms_api_var'))
                                                            <strong class="font-red">{{ $errors->first('sms_api_var') }}</strong>
                                                        @endif

                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('sms_api_var',trans('lang.sms_api_var'),['class'=>'control-label']) !!}
                                                        <span class="required" aria-required="true"> * </span>
                                                        {!! Form::text('sms_api_var4',$settings->get('sms_api_var4')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('sms_api_var'))
                                                            <strong class="font-red">{{ $errors->first('sms_api_var') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('sms_api_var_to',trans('lang.sms_api_var_to'),['class'=>'control-label']) !!}
                                                        <span class="required" aria-required="true"> * </span>
                                                        {!! Form::text('sms_api_var_to',$settings->get('sms_api_var_to')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('sms_api_var_to'))
                                                            <strong class="font-red">{{ $errors->first('sms_api_var_to') }}</strong>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('sms_api_var_message',trans('lang.sms_api_var_message'),['class'=>'control-label']) !!}
                                                        <span class="required" aria-required="true"> * </span>
                                                        {!! Form::text('sms_api_var_message',$settings->get('sms_api_var_message')->s_value,['class' => 'form-control']) !!}
                                                        @if($errors->has('sms_api_var_message'))
                                                            <strong class="font-red">{{ $errors->first('sms_api_var_message') }}</strong>
                                                        @endif
                                                    </div>

                                                    <div class="margin-top-10">
                                                        {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                                <!-- END CHANGE PASSWORD TAB -->

                                                <!-- LOCATIONS  TAB -->
                                                {{--<div class="tab-pane {{session('tab4_state')?session('tab4_state'):''}}"--}}
                                                {{--id="tab_1_4">--}}


                                                {{--{!! Form::open(['id'=>'userLocationForm','method' => 'post', 'action' =>['ProfileController@addUserLocation',$user->pk_i_id]]) !!}--}}

                                                {{--<div class="margin-top-10">--}}
                                                {{--{!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}--}}

                                                {{--</div>--}}
                                                {{--{!! Form::close() !!}--}}

                                                {{--</div>--}}
                                                        <!-- END LOCATIONS TAB -->
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>

    @endif

@endsection
@section('scripts')


    <script>
        $('#tab1Form').validate({
            rules: {
                website_name: "required",
                website_email: "required"
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
                error.css('color', 'red');
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                website_name: "اسم الموقع حقل مطلوب",
                website_email: "ايميل الموقع حقل مطلوب",
                @else
                website_name: "website name is required field",
                website_email: "website email is required field"
                @endif
            }, submitHandler: function (form) {
                $.ajax({
                    method: "POST",
                    url: "{{action('AdminController@storeSystemSettings')}}",
                    dataType: "json",
                    data: $('#tab1Form').serialize(),
                    success: function (data, textStatus, jqXHR) {
                        swal({
                            type: "success",
                            title: "{{trans('lang.success')}}",
                            text: "",
                            confirmButtonText: "{{trans('lang.cancel')}}"
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
        });
    </script>
    <script>
        $('#tab2Form').validate({
            errorElement: "div",
            rules: {
                smtp_mail_server: "required",
                smtp_port: "required",
                smtp_email: "required",
                smtp_password: "required"
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
                error.css('color', 'red');
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                smtp_mail_server: "SMTP Mail Server حقل مطلوب",
                smtp_port: "SMTP Port حقل مطلوب",
                smtp_email: " SMTPالبريد الالكتروني ل حقل مطلوب",
                smtp_password: "SMTPكلمة المرور ل حقل مطلوب",
                @else
                smtp_mail_server: "smtp mail server is required field",
                smtp_port: "smtp port is required field",
                smtp_email: "smtp email is required field",
                smtp_password: "smtp password is required field"
                @endif
            }, submitHandler: function (form) {
                $.ajax({
                    method: "POST",
                    url: "{{action('AdminController@storeSystemSettings')}}",
                    dataType: "json",
                    data: $('#tab2Form').serialize(),
                    success: function (data, textStatus, jqXHR) {
                        swal({
                            type: "success",
                            title: "{{trans('lang.success')}}",
                            text: "",
                            confirmButtonText: "{{trans('lang.cancel')}}"
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
        });
    </script>
    <script>
        $('#tab3Form').validate({
            rules: {
                sms_api_url: "required",
                sms_api_var1: "required",
                sms_api_var2: "required",
                sms_api_var3: "required",
                sms_api_var4: "required",
                sms_api_var_to: "required",
                sms_api_var_message: "required"
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
                error.css('color', 'red');
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                sms_api_url: "رابط sms api حقل مطلوب",
                sms_api_var1: "متغير sms api حقل مطلوب",
                sms_api_var2: "متغير sms api حقل مطلوب",
                sms_api_var3: "متغير sms api حقل مطلوب",
                sms_api_var4: "متغير sms api حقل مطلوب",
                sms_api_var_to: "المتغير الخاص برقم الجوال المرسلة له sms api حقل مطلوب",
                sms_api_var_message: "المتغير الخاص بالرسالة المرسلة ل sms api حقل مطلوب",
                @else
                sms_api_url: "sms api url is required field",
                sms_api_var1: "sms api var1 is required field",
                sms_api_var2: "sms api var2 is required field",
                sms_api_var3: "sms api var3 is required field",
                sms_api_var4: "sms api var4 is required field",
                sms_api_var_to: "sms api var to is required field",
                sms_api_var_message: "sms api var message is required field"
                @endif
            }, submitHandler: function (form) {
                $.ajax({
                    method: "POST",
                    url: "{{action('AdminController@storeSystemSettings')}}",
                    dataType: "json",
                    data: $('#tab3Form').serialize(),
                    success: function (data, textStatus, jqXHR) {
                        swal({
                            type: "success",
                            title: "{{trans('lang.success')}}",
                            text: "",
                            confirmButtonText: "{{trans('lang.cancel')}}"
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
        });
    </script>
@endsection