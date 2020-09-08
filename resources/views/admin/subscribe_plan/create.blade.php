@extends('_layout')
@section('title')
    {{trans('lang.subscribe_plan')}}
@endsection
@section('head_title')
    {{trans('lang.subscribe_plan')}}
@endsection
@section('msg')
    @if(session('msg'))
        <div class="alert alert-success alert-dismissible text-center" style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('msg') }}
        </div>
    @endif
    @if(session('error_msg'))
        <div class="alert alert-danger alert-dismissible text-center" style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('error_msg') }}
        </div>
    @endif
@endsection
@section('content')
{!! Form::open(['id'=>'SubscribePlanForm','method' =>'post','action' => 'AdminController@storeSubscribePlan']) !!}

<div class="row">

    <div class="form-group col-sm-6">
        {!! Form::label('subscription_package_en',trans('lang.subscription_package')) !!}
        {!! Form::text('subscription_package_en',null,['class' => 'form-control']) !!}
        @if($errors->has('subscription_package_en'))
            <strong class="font-red">{{ $errors->first('subscription_package_en') }}</strong>
        @endif
        <div class="font-red" id="subscription_package_en_validate"></div>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('subscription_package_ar',trans('lang.subscription_package_arabic')) !!}
        {!! Form::text('subscription_package_ar',null,['class' => 'form-control']) !!}
        @if($errors->has('subscription_package_ar'))
            <strong class="font-red">{{ $errors->first('subscription_package_ar') }}</strong>
        @endif
        <div class="font-red" id="subscription_package_ar_validate"></div>

    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('users_count',trans('lang.users_count')) !!}
        {!! Form::text('users_count',null,['class' => 'form-control']) !!}
        @if($errors->has('users_count'))
            <strong class="font-red">{{ $errors->first('users_count') }}</strong>
        @endif
        <div class="font-red" id="users_count_validate"></div>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('services_count',trans('lang.services_count')) !!}
        {!! Form::text('services_count',null,['class' => 'form-control']) !!}
        @if($errors->has('services_count'))
            <strong class="font-red">{{ $errors->first('services_count') }}</strong>
        @endif
        <div class="font-red" id="services_count_validate"></div>

    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('request_count',trans('lang.request_count')) !!}
        {!! Form::text('request_count',null,['class' => 'form-control']) !!}
        @if($errors->has('request_count'))
            <strong class="font-red">{{ $errors->first('request_count') }}</strong>
        @endif
        <div class="font-red" id="request_count_validate"></div>

    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('sms_notification',trans('lang.sms_notification')) !!}
        {!! Form::text('sms_notification',null,['class' => 'form-control']) !!}
        @if($errors->has('sms_notification'))
            <strong class="font-red">{{ $errors->first('sms_notification') }}</strong>
        @endif
        <div class="font-red" id="sms_notification_validate"></div>

    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('email_notification',trans('lang.email_notification')) !!}
        {!! Form::text('email_notification',null,['class' => 'form-control']) !!}
        @if($errors->has('email_notification'))
            <strong class="font-red">{{ $errors->first('email_notification') }}</strong>
        @endif
        <div class="font-red" id="email_notification_validate"></div>

    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('percentage',trans('lang.percentage')) !!}
        {!! Form::text('percentage',null,['class' => 'form-control']) !!}
        @if($errors->has('percentage'))
            <strong class="font-red">{{ $errors->first('percentage') }}</strong>
        @endif
        <div class="font-red" id="percentage_validate"></div>

    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('price',trans('lang.price')) !!}
        <div class="input-group">
            {!! Form::text('price',null,['class' => 'form-control']) !!}

            <span class="input-group-addon">@lang('lang.curr')</span>
        </div>
        @if($errors->has('price'))
            <strong class="font-red">{{ $errors->first('price') }}</strong>
        @endif
        <div class="font-red" id="price_validate"></div>

    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('duration',trans('lang.duration')) !!}
        <div class="input-group">
            {!! Form::text('duration',null,['class' => 'form-control']) !!}
            <span class="input-group-addon">@lang('lang.one_day')</span>
        </div>


        @if($errors->has('duration'))
            <strong class="font-red">{{ $errors->first('duration') }}</strong>
        @endif
        <div class="font-red" id="duration_validate"></div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('status',trans('lang.status')) !!}
        <?php
        $state;
        if (app()->getLocale() == 'en') {
            $state = ['' => 'choose option', '1' => 'enable', '0' => 'disable'];
        } else {
            $state = ['' => 'اختر من القائمة', '1' => 'فعال', '0' => 'غير فعال'];
        }
        ?>
        {!! Form::select('status',$state,null,['class' => 'form-control select','id' => 'status_m']) !!}
        @if($errors->has('status'))
            <strong class="font-red">{{ $errors->first('status') }}</strong>
        @endif
        <div class="font-red" id="status_validate"></div>


    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('listed',trans('lang.listed_on_homepage')) !!}
        <?php
        $state;
        if (app()->getLocale() == 'en') {
            $state = ['' => 'choose option', '1' => 'show', '0' => 'hide'];
        } else {
            $state = ['' => 'اختر من القائمة', '1' => 'عرض', '0' => 'إخفاء'];
        }
        ?>
        {!! Form::select('listed',$state,null,['class' => 'form-control select']) !!}
        @if($errors->has('listed'))
            <strong class="font-red">{{ $errors->first('listed') }}</strong>
        @endif
        <div class="font-red" id="listed_validate"></div>

    </div>


</div>

<div class="row">
    {!! Form::submit(trans('lang.add'),['class' => 'btn green','style'=>'margin-left:15px']) !!}
</div>

{!! Form::close() !!}
@endsection
@section('scripts')
    @include('scripts.scripts')
@endsection