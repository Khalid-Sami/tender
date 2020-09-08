@extends('_layout')

@section('styles')
    <style>

        .error {
            color: red;
        }
    </style>
@endsection
@section('head_title')
    {{trans('lang.add_new_company')}}
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

    {!! Form::open(['id'=>'addUserForm','method' =>'post','action'=>['AdminController@storeCompanyAccount']]) !!}
    <h3 class="font-green">@lang("lang.add_new_company")</h3>
    <h4 class="font-green">@lang("lang.account_information")</h4>

    <div class="row">
        <div class="form-group col-sm-5">
            {!! Form::label('first_name','First Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('first_name', old('first_name'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.firstName')]) !!}
            @if($errors->has('first_name'))
                <strong class="font-red">{{ $errors->first('first_name') }}</strong>
            @endif
            <div id="first_name_validate" class="font-red"></div>
        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('last_name','Last Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('last_name', old('last_name'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.lastName')]) !!}
            @if($errors->has('last_name'))
                <strong class="font-red">{{ $errors->first('last_name') }}</strong>
            @endif
            <div id="last_name_validate" class="font-red"></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-5">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            {!! Form::label('user_email','Email',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('user_email', old('user_email'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.email')]) !!}
            @if($errors->has('user_email'))
                <strong class="font-red">{{ $errors->first('user_email') }}</strong>
            @endif
            <div id="user_email_validate" class="font-red"></div>
        </div>
        <div class="form-group col-sm-5">
            {!! Form::label('user_mobile_number','Mobile Number',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('user_mobile_number', old('user_mobile_number'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.mobileNumber')]) !!}
            @if($errors->has('user_mobile_number'))
                <strong class="font-red">{{ $errors->first('user_mobile_number') }}</strong>
            @endif
            <div id="user_mobile_number_validate" class="font-red"></div>

        </div>
    </div>


    <div class="row">

        <div class="form-group col-sm-5">
            {!! Form::label('password','Password',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::input('password','password', old('password'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.password')]) !!}
            @if($errors->has('password'))
                <strong class="font-red">{{ $errors->first('password') }}</strong>
            @endif
            <div id="password_validate" class="font-red"></div>
        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('confirm','Re-type Your Password',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::input('password','confirm', old('confirm'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.confirm_pass')]) !!}
            @if($errors->has('confirm'))
                <strong class="font-red">{{ $errors->first('confirm') }}</strong>
            @endif
            <div id="confirm_validate" class="font-red"></div>

        </div>
    </div>
    <h4 class="font-green">@lang("lang.company_account")</h4>

        <div class="row">

        <div class="form-group col-sm-5">
            {!! Form::label('service_provider_name_ar','Service Provider Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_name_ar', old('service_provider_name_ar'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.company_arabic')]) !!}
            @if($errors->has('service_provider_name_ar'))
                <strong class="font-red">{{ $errors->first('service_provider_name_ar') }}</strong>
            @endif
            <div id="service_provider_name_ar_validate" class="font-red"></div>

        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('service_provider_name_en','Service Provider Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_name_en', old('service_provider_name_en'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.company_english')]) !!}
            @if($errors->has('service_provider_name_en'))
                <strong class="font-red">{{ $errors->first('service_provider_name_en') }}</strong>
            @endif
            <div id="service_provider_name_en_validate" class="font-red"></div>

        </div>
    </div>
        <div class="row">

        <div class="form-group col-sm-5">
            {!! Form::label('company_name','Company Name',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('company_name', old('company_name'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.company_name')]) !!}
            @if($errors->has('company_name'))
                <strong class="font-red">{{ $errors->first('company_name') }}</strong>
            @endif
            <div id="company_name_validate" class="font-red"></div>

        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('service_provider_telephone_number','Telephone Number',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_telephone_number', old('clinic_telephone_number'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.tel')]) !!}
            @if($errors->has('service_provider_telephone_number'))
                <strong class="font-red">{{ $errors->first('service_provider_telephone_number') }}</strong>
            @endif
            <div id="service_provider_telephone_number_validate" class="font-red"></div>

        </div>
    </div>
    <div class="row">

        <div class="form-group col-sm-5">
            {!! Form::label('service_provider_email','Email',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_email', old('service_provider_email'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.email')]) !!}
            @if($errors->has('service_provider_email'))
                <strong class="font-red">{{ $errors->first('service_provider_email') }}</strong>
            @endif
            <div id="service_provider_email_validate" class="font-red"></div>

        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('service_provider_mobile_number','Mobile Number',['class'=>'control-label visible-ie8 visible-ie9']) !!}
            {!! Form::text('service_provider_mobile_number', old('service_provider_mobile_number'),['class' =>'form-control placeholder-no-fix','placeholder'=>trans('lang.mobile_number')]) !!}
            @if($errors->has('service_provider_mobile_number'))
                <strong class="font-red">{{ $errors->first('service_provider_mobile_number') }}</strong>
            @endif
            <div id="service_provider_mobile_number_validate" class="font-red"></div>

        </div>
    </div>
    <div class="row">

        <div class="form-group " style="margin-top: 24px;text-align: center">
            {!! Form::submit(trans('lang.create'),['class'=> 'btn green']) !!}
            <a href="{{url("/")}}/admin/company/show" class="btn btn-default">@lang("lang.back")</a>
        </div>

    </div>
    {!! Form::close() !!}
    <br>


@endsection
@section('scripts')
    <script>
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd'
        });
    </script>

    <script>
        $('#addUserForm').validate({
            rules: {
                first_name: "required",
                last_name: "required",
                service_provider_name_ar: "required",
                service_provider_name_en: "required",
                company_name: "required",
                service_provider_telephone_number: {
                    required: true,
                    number: true
                },
                service_provider_mobile_number: {
                    required: true,
                    number: true
                },
                user_mobile_number: {
                    required: true,
                    number: true
                },
                user_email: {
                    required: true,
                    email: true
                },
                service_provider_email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },confirm: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                }
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() == 'en')
                first_name: "First name field is required",
                last_name: "Last name field is required",
                service_provider_name_ar: "Company (Arabic) field is required",
                service_provider_name_en: "Company (English) field is required",
                company_name: "Company name field is required",
                user_mobile_number: {
                    required: "Mobile number field is required",
                    number: "Mobile number field must contains number only"
                },
                service_provider_telephone_number: {
                    required: "Telephone number field is required",
                    number: "Telephone number field must contains number only"
                },
                service_provider_mobile_number: {
                    required: "Mobile number field is required",
                    number: "Mobile number field must contains number only"
                },
                user_email: {
                    required: "Email field is required",
                    email: "Email field must be a valid email address"
                },
                service_provider_email: {
                    required: "Email field is required",
                    email: "Email field must be a valid email address"
                },
                password: {
                    required: "Password field is required",
                    minlength: "Password field must at least contains 6 character"
                },
                confirm: {
                    required: "Confirm password field is required",
                    minlength: "Password field must at least contains 6 character",
                    equalTo: "Confirm password field must equal to password field "
                },
                @else
                first_name: "الاسم الشخصي حقل مطلوب",
                last_name: "اسم العائلة حقل مطلوب",
                service_provider_name_ar: "الشركة (عربي) حقل مطلوب",
                service_provider_name_en: "الشركة (إنجليزي) حقل مطلوب",
                company_name: "إسم الشركة حقل مطلوب",
                user_mobile_number: {
                    required: "رقم الجوال حقل مطلوب",
                    number: "رقم الجوال يجب ان يحتوي على ارقام فقط"
                },
                service_provider_telephone_number: {
                    required: "رقم الهاتف حقل مطلوب",
                    number: "رقم الهاتف يجب ان يحتوي على ارقام فقط"
                },
                service_provider_mobile_number: {
                    required: "رقم الجوال حقل مطلوب",
                    number: "رقم الجوال يجب ان يحتوي على ارقام فقط"
                },
                user_email: {
                    required: "الايميل حقل مطلوب",
                    email: "الايميل يجب ان يكون بريد الكتروني صحيح"
                },
                service_provider_email: {
                    required: "الايميل حقل مطلوب",
                    email: "الايميل يجب ان يكون بريد الكتروني صحيح"
                },
                password: {
                    required: "كلمة المرور حقل مطلوب",
                    minlength: "كلمة المرور يجب ان تحتوي على 6 احرف على الاقل"
                },confirm: {
                    required: "تأكيد كلمة المرور حقل مطلوب",
                    minlength: "تأكيد كلمة المرور يجب ان تحتوي على 6 احرف على الاقل",
                    equalTo: "تأكيد كلمة المرور يجب ان تساوي كلمة المرور"
                }
                @endif
            },submitHandler: function (form) {
                form.submit();
            }
        });
    </script>

@endsection