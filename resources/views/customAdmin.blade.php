@extends('_layout')

@section('head_title')
    {{trans('lang.add_new_user')}}
@endsection
@section('title')
    {!!  trans('lang.add_new_user') !!}
@endsection
{{--@section('msg')--}}
{{--@if(session('msg'))--}}
{{--<div class="alert alert-success alert-dismissible text-center" style=" position: absolute;width: 100%;z-index: 1;">--}}
{{--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
{{--{{ session('msg') }}--}}
{{--</div>--}}
{{--@endif--}}
{{--@if(session('error_msg'))--}}
{{--<div class="alert alert-danger alert-dismissible text-center" style=" position: absolute;width: 100%;z-index: 1;">--}}
{{--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
{{--{{ session('error_msg') }}--}}
{{--</div>--}}
{{--@endif--}}

{{--@endsection--}}
@section('styles')
    <style>
        .margin-top-20 {
            margin-top: 20px !important;
        }
        .margin-top-10 {
            margin-top: 10px !important;
        }
    </style>
@endsection
@section('content')

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

    {!! Form::model($user,['id'=>'editCustomAdmin','method' => 'patch', 'action' =>['AdminController@updateCustomAdminInformation',$user->id],'files' => true]) !!}

    <div class="row">
        <div class="col-md-6 form-group">
            {!! Form::label('fname',trans('lang.first_name'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            {!! Form::text('fname',null,['class' => 'form-control']) !!}
            @if($errors->has('fname'))
                <strong class="font-red">{{ $errors->first('fname') }}</strong>
            @endif
            <strong id="fname_validate" class="font-red"></strong>
        </div>
        <div class="col-md-6 form-group">
            {!! Form::label('lname',trans('lang.last_name'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            {!! Form::text('lname',null,['class' => 'form-control']) !!}
            @if($errors->has('lname'))
                <strong class="font-red">{{ $errors->first('lname') }}</strong>
            @endif
            <strong id="lname_validate" class="font-red"></strong>
        </div>

        <div class="col-md-6 form-group">
            {!! Form::label('password',trans('lang.password'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            {!! Form::password('password',['class' => 'form-control']) !!}
            @if($errors->has('password'))
                <strong class="font-red">{{ $errors->first('password') }}</strong>
            @endif
            <strong id="password_validate" class="font-red"></strong>
        </div>
        <div class="col-md-6 form-group">
            {!! Form::label('confirm',trans('lang.confirm_pass'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            {!! Form::password('confirm',['class' => 'form-control']) !!}
            @if($errors->has('confirm'))
                <strong class="font-red">{{ $errors->first('confirm') }}</strong>
            @endif
            <strong id="confirm_validate" class="font-red"></strong>
        </div>

        <div class="col-md-6 form-group">
            {!! Form::label('bdate',trans('lang.birth_date'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            {!! Form::text('bdate',null,['class' => 'form-control date date-picker']) !!}
            @if($errors->has('bdate'))
                <strong class="font-red">{{ $errors->first('bdate') }}</strong>
            @endif
            <strong id="bdate_validate" class="font-red"></strong>

        </div>

        <div class="col-md-6 form-group">
            {!! Form::label('gender',trans('lang.gender'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            <?php
            $gend = array();
            if(count($gender))
                $gend[''] = trans('lang.choose_option');
            foreach ($gender as $gen){
                $gend[$gen->id] = $gen->name;
            }
            ?>
            {!! Form::select('gender',isset($gend)?$gend:[],null,['class' => 'form-control select']) !!}
            <strong id="gender_validate" class="font-red"></strong>
        </div>

        <div class="col-md-6 form-group">
            {!! Form::label('email',trans('lang.E-mail'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            {!! Form::text('email',null,['class' => 'form-control']) !!}
            @if($errors->has('email'))
                <strong class="font-red">{{ $errors->first('email') }}</strong>
            @endif
            <strong id="email_validate" class="font-red"></strong>
        </div>

        <div class="col-md-6 form-group">
            {!! Form::label('mobile',trans('lang.mobile_number'),['class'=>'control-label']) !!}
            <span class="required font-red">*</span>
            {!! Form::text('mobile',null,['class' => 'form-control']) !!}
            @if($errors->has('mobile'))
                <strong class="font-red">{{ $errors->first('mobile') }}</strong>
            @endif
            <strong id="mobile_validate" class="font-red"></strong>
        </div>

        <div class="col-md-6 form-group">
            {!! Form::label('country',trans('lang.country'),['class'=>'control-label']) !!}
            <?php
            $country = array();
            if(count($countries))
                $country[''] = trans('lang.choose_option');
            foreach ($countries as $count){
                $country[$count->id] = $count->name;
            }
            ?>
            {!! Form::select('country',isset($country)?$country:[],null,['class' => 'form-control select','id'=>'country']) !!}
        </div>

        <div class="col-md-6 form-group">
            {!! Form::label('city',trans('lang.city'),['class'=>'control-label']) !!}
            {!! Form::select('city',[],null,['class' => 'form-control select','id'=>'city']) !!}
        </div>

        <div class="col-md-12 form-group">
            {!! Form::label('address',trans('lang.address'),['class'=>'control-label']) !!}
            {!! Form::text('address',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <hr class="col-sm-11 permissionsDiv">
    <div id="permissionsDiv" class="row">
        <div class="form-group">
            <label class="control-label col-md-3">@lang('lang.userPermissions')</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select0" name="my_multi_select0[]">
                    @forelse($permissions as $permission)
                        @if(app()->getLocale() == 'ar')
                            <option value="{{$permission->id}}" data-val="{{ $permission->pid }}" @if(in_array($permission->id,$userPermissions)) selected @endif>{{ $permission->atitle }}</option>
                        @else
                            <option value="{{$permission->id}}" data-val="{{ $permission->pid }}" @if(in_array($permission->id,$userPermissions)) selected @endif>{{ $permission->etitle }}</option>
                        @endif
                    @empty
                        <p  disabled>no permissions</p>
                    @endforelse
                </select>
                <strong id="my_multi_select0_validate" class="font-red"></strong>
            </div>
        </div>
    </div>
    <hr class="col-sm-11 permissionsDiv">
    <div class="row">
        <button type="submit" id="addUserBTN" class="btn btn-primary col-sm-offset-5">@lang('lang.save')</button>
    </div>
    {!! Form::close() !!}



@endsection
@section('scripts')

    <script>
        $('.date').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('.alert-dismissible').delay(3000).fadeOut('slow');

        $('#my_multi_select0').multiSelect();
        $('.ms-selection').each(function (i) {
            $(this).prepend('<label><input id="allSelected' + i + '" type="checkbox">{{trans('lang.all')}}</label>');
        });

        $('.ms-container').each(function (i) {
            $(this).css('width', '650px');
        });

        $('.ms-selectable .ms-list').css('margin-top','28px');

    </script>

    <script>
        $('body').on('click', '#allSelected0', function () {
            if ($(this).is(':checked')) {
                $('#my_multi_select0').multiSelect('select_all');

            } else {
                $('#my_multi_select0').multiSelect('deselect_all');
            }
        });
    </script>

    <script>

        $("#editCustomAdmin").submit(function(e) {
            e.preventDefault();
        }).validate({
            rules: {
                fname: "required",
                lname: "required",
                bdate: "required",
                gender: "required",
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    number: true
                },
                password: {
                    minlength: 6
                },
                confirm: {
                    equalTo: "#password"
                }
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() =='ar')
                fname: "الاسم الاول حقل مطلوب",
                lname: "الاسم الثاني حقل مطلوب",
                bdate: "تاريخ الميلاد حقل مطلوب",
                gender: "الجنس حقل مطلوب",
                email :{
                    required : "البريد الالكتروني حقل مطلوب",
                    email: "يرجى ادخال البريد الالكتروني بشكل صحيح"
                },
                mobile: {
                    required: "رقم الجوال حقل مطلوب",
                    number: "يجب ادخال رقم الجوال بشكل صحيح"
                },
                password: {
                    minlength: "يجب ادخال 6 احرف على الاقل"
                },
                confirm: {
                    equalTo: "كلمة المرور يجب ان تكون مطابقة"
                },
                @else
                fname: "First-Name field is required",
                lname: "Last-Name field is required",
                bdate: "Birthday field is required",
                gender: "Gender field is required",
                email :{
                    required : "E-mail field is required",
                    email: "You must enter your email correctly"
                },
                mobile: {
                    required: "Mobile-Number field is required",
                    number: "You must enter your mobile number correctly"
                },
                password: {
                    minlength: "You must enter 6 letters at least"
                },
                confirm:{
                    equalTo: "Confirm field must be equal to password field"
                }
                @endif
            },
            submitHandler: function(form) {
                if($('#my_multi_select0').val() != null){
                    form.submit();
                }
                else{
                    swal(
                        '@lang('lang.sorry')',
                        '{{trans('lang.mustSelectPermission')}}',
                        'error'
                    )
                }
            }
        })
    </script>

    <script>

        $('#country').change(function(){
            $('#city').find('option').remove();
            $.ajax({
                method: "GET",
                url: '{{url('/')}}/newUser/'+$(this).val()+'/getCities',
                dataType: "json",
                data: $("#sendMessageDataForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    if(data.status && data.found){
                        $('#city').append($("<option></option>").attr("value",'').text('@lang('lang.choose_option')'));
                        $.each(data.cities, function (i, item) {
                            $('#city').append($("<option></option>").attr("value",item.id).text(item.name));
                        });
                    }
                }
            })
        })

    </script>
@endsection