@extends('_layout')

@section('styles')
    <style>

        .error {
            color: red;
        }
    </style>
@endsection
@section('head_title')
    {{trans('lang.add_user')}}
@endsection
@section('title')
    {{trans('lang.add_user')}}
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

    {!! Form::open(['id'=>'addUserForm','method' =>'post','action'=>['AdminController@storeAccount']]) !!}

    <div class="row">
        <div class="form-group col-sm-5">
            {!! Form::label('first_name',trans('lang.first_name')) !!}
            {!! Form::text('first_name',null,['class' =>'form-control']) !!}
            @if($errors->has('first_name'))
                <strong class="font-red">{{$errors->first('first_name')}}</strong>
            @endif
            <div id="first_name_validate" class="font-red"></div>
        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('last_name',trans('lang.last_name')) !!}
            {!! Form::text('last_name',null,['class' =>'form-control']) !!}
            @if($errors->has('last_name'))
                <strong class="font-red">{{$errors->first('last_name')}}</strong>
            @endif
            <div id="last_name_validate" class="font-red"></div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-5">
            {!! Form::label('gender',trans('lang.gender')) !!}
            {!! Form::select('gender',$genders,null,['class' =>'form-control select']) !!}
            @if($errors->has('gender'))
                <strong class="font-red">{{$errors->first('gender')}}</strong>
            @endif
            <div id="gender_validate" class="font-red"></div>

        </div>
        <div class="form-group col-sm-5">
            {!! Form::label('birth_date',trans('lang.birth_date')) !!}
            {!! Form::text('birth_date',null,['class' =>'form-control date-picker']) !!}
            @if($errors->has('birth_date'))
                <strong class="font-red">{{$errors->first('birth_date')}}</strong>
            @endif
            <div id="birth_date_validate" class="font-red"></div>

        </div>
    </div>


    <div class="row">

        <div class="form-group col-sm-5">
            {!! Form::label('mobile_number',trans('lang.mobile_number')) !!}
            {!! Form::text('mobile_number',null,['class' =>'form-control']) !!}
            @if($errors->has('mobile_number'))
                <strong class="font-red">{{$errors->first('mobile_number')}}</strong>
            @endif
            <div id="mobile_number_validate" class="font-red"></div>
        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('email',trans('lang.email')) !!}
            {!! Form::text('email',null,['class' =>'form-control']) !!}
            @if($errors->has('email'))
                <strong class="font-red">{{$errors->first('email')}}</strong>
            @endif
            <div id="email_validate" class="font-red"></div>

        </div>
    </div>
    <div class="row">

        <div class="form-group col-sm-5">
            {!! Form::label('password',trans('lang.password')) !!}
            {!! Form::input('password','password',null,['class' =>'form-control','id'=>'password']) !!}
            @if($errors->has('password'))
                <strong class="font-red">{{$errors->first('password')}}</strong>
            @endif
            <div id="password_validate" class="font-red"></div>

        </div>

        <div class="form-group col-sm-5">
            {!! Form::label('confirm',trans('lang.confirm_password')) !!}
            {!! Form::input('password','confirm',null,['class' =>'form-control']) !!}
            @if($errors->has('confirm'))
                <strong class="font-red">{{$errors->first('confirm')}}</strong>
            @endif
            <div id="confirm_validate" class="font-red"></div>

        </div>
    </div>
    <div class="row">

        <div class="form-group " style="margin-top: 24px;">
            {!! Form::submit(trans('lang.create'),['class'=> 'btn green']) !!}
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
                gender: "required",
                birth_date: "required",
                mobile_number: {
                    required: true,
                    number: true
                },
                email: {
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
                first_name: "first name field is required",
                last_name: "last name field is required",
                gender: "gender field is required",
                birth_date: "birth date field is required",
                mobile_number: {
                    required: "mobile number field is required",
                    number: "mobile number field must contains number only"
                },
                email: {
                    required: "email field is required",
                    email: "email field must be valid email address"
                },
                password: {
                    required: "password field is required",
                    minlength: "password field must at least contains 6 character"
                },
                confirm: {
                    required: "confirm password field is required",
                    minlength: "password field must at least contains 6 character",
                    equalTo: "confirm password field must equal to password field "
                },
                @else
                first_name: "الاسم الاول حقل مطلوب",
                last_name: "اسم العائلة حقل مطلوب",
                gender: "الجنس حقل مطلوب",
                birth_date: "تاريخ الميلاد حقل مطلوب",
                mobile_number: {
                    required: "رقم الجوال حقل مطلوب",
                    number: "رقم الجوال يجب ان يحتوي على ارقام فقط"
                },
                email: {
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