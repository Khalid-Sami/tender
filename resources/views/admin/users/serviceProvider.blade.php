@extends('_layout')
@section('styles')
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
@endsection

@section('title')
    {{trans('lang.service_provider_profile')}}
@endsection
@section('head_title')
    {{trans('lang.service_provider_profile')}}
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


    <div class="col-md-12">
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">@lang('lang.service_provider_profile_account')</span>
                            </div>
                            <ul class="nav nav-tabs">
                                @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state') && !session('tab5_state') && !session('tab6_state') && !session('tab7_state'))
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">@lang('lang.service_provider_info')</a>
                                    </li>
                                @else
                                    <li class="{{session('tab1_state')?session('tab1_state'):''}}">
                                        <a href="#tab_1_1" data-toggle="tab">@lang('lang.service_provider_info')</a>
                                    </li>
                                @endif

                                {{--<li class="{{session('tab2_state')?session('tab2_state'):''}}">--}}
                                {{--<a href="#tab_1_2" data-toggle="tab">@lang('lang.cities')</a>--}}
                                {{--</li>--}}
                                    <li class="{{session('tab6_state')?session('tab6_state'):''}}">
                                        <a href="#tab_1_6" id="bankAccountTab"
                                           data-toggle="tab">@lang('lang.bankAccount')</a>
                                    </li>
                                    <li class="{{session('tab7_state')?session('tab7_state'):''}}">
                                        <a href="#tab_1_7" id="categoriesTab"
                                           data-toggle="tab">@lang('lang.company_category')</a>
                                    </li>
                                    {{--<li class="">--}}
                                        {{--<a href="#tab_1_7" id="salesRepresentativeTab"--}}
                                           {{--data-toggle="tab">@lang('lang.salesRepresentative')</a>--}}
                                    {{--</li>--}}
                                <li class="{{session('tab3_state')?session('tab3_state'):''}}">
                                    <a href="#tab_1_3" id="locationTab"
                                       data-toggle="tab">@lang('lang.provider_locations')</a>
                                </li>
                                <li class="{{session('tab4_state')?session('tab4_state'):''}}">
                                    <a href="#tab_1_4" data-toggle="tab">@lang('lang.times_of_work')</a>
                                </li>
                                <li id="mapTab" class="{{session('tab5_state')?session('tab5_state'):''}}">
                                    <a href="#tab_1_5" data-toggle="tab">@lang('lang.additional_info')</a>
                                </li>

                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- CLINIC INFO TAB -->
                                @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state') && !session('tab5_state') && !session('tab6_state') && !session('tab7_state'))
                                    <div class="tab-pane active" id="tab_1_1">
                                        @else
                                            <div class="tab-pane {{session('tab1_state')?session('tab1_state'):''}}"
                                                 id="tab_1_1">
                                                @endif


                                                {!! Form::model($service_provider,['id'=>'ServiceProviderInfoForm','method' => 'patch', 'action' =>['ServiceProviderController@updateSPInformation',$service_provider->pk_i_id],'files' => true]) !!}
                                                <div class="form-group col-md-6">
                                                    <input class="hidden companyStatus" data-val="{{ $service_provider->i_status }}" >
                                                    <input class="hidden userStatus" data-val="{{ $userStatus->s_name_en }}">
                                                    {!! Form::label('s_name_ar',trans('lang.service_provider_ar'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_name_ar',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_name_ar'))
                                                        <strong class="font-red">{{ $errors->first('s_name_ar') }}</strong>
                                                    @endif
                                                    <div id="s_name_ar_validate" class="font-red"></div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('s_name_en',trans('lang.service_provider_en'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_name_en',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_name_en'))
                                                        <strong class="font-red">{{ $errors->first('s_name_en') }}</strong>
                                                    @endif
                                                    <div id="s_name_en_validate" class="font-red"></div>

                                                </div>
                                                {{--<div class="form-group">--}}
                                                    {{--{!! Form::label('s_company_name',trans('lang.company'),['class'=>'control-label']) !!}--}}
                                                    {{--<span class="required font-red">*</span>--}}
                                                    {{--{!! Form::text('s_company_name',null,['class' => 'form-control']) !!}--}}
                                                    {{--@if($errors->has('s_company_name'))--}}
                                                        {{--<strong class="font-red">{{ $errors->first('s_company_name') }}</strong>--}}
                                                    {{--@endif--}}
                                                    {{--<div id="s_company_name_validate" class="font-red"></div>--}}
                                                {{--</div>--}}
                                                <div class="form-group col-md-12">
                                                    {!! Form::label('s_trade_license_no',trans('lang.trade_licence_number'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_trade_license_no',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_trade_license_no'))
                                                        <strong class="font-red">{{ $errors->first('s_trade_license_no') }}</strong>
                                                    @endif
                                                    <div id="s_trade_license_no_validate" class="font-red"></div>

                                                </div>
                                                <div class="form-group col-md-4">
                                                    {!! Form::label('s_telephone_number',trans('lang.telephone_number'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_telephone_number',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_telephone_number'))
                                                        <strong class="font-red">{{ $errors->first('s_telephone_number') }}</strong>
                                                    @endif
                                                    <div id="s_telephone_number_validate" class="font-red"></div>

                                                </div>
                                                <div class="form-group col-md-4">
                                                    {!! Form::label('s_mobile_number',trans('lang.mobile_number'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_mobile_number',null,['class' => 'form-control']) !!}

                                                    @if($errors->has('s_mobile_number'))
                                                        <strong class="font-red">{{ $errors->first('s_mobile_number') }}</strong>
                                                    @endif
                                                    <div id="s_mobile_number_validate" class="font-red"></div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    {!! Form::label('s_fax',trans('lang.faxNumber'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_fax',null,['class' => 'form-control']) !!}

                                                    @if($errors->has('s_fax'))
                                                        <strong class="font-red">{{ $errors->first('s_fax') }}</strong>
                                                    @endif
                                                    <div id="s_fax_validate" class="font-red"></div>
                                                </div>
                                                {{--New Inputs--}}
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('s_country',trans('lang.countryName'),['class'=>'control-label','id' => 'countryLabel','data-val' => $service_provider->pk_i_id]) !!}
                                                    {!! Form::select('s_country',[null=>trans('lang.selectCountry')]+$country,null,['class'=>'form-control select','id' => 'country']) !!}
                                                    {{-- {!! Form::select('s_country',isset($status)?$status:[],null,['class'=>'form-control select','id' => 'status']) !!}--}}
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('s_city',trans('lang.cityName'),['class'=>'control-label']) !!}
                                                    {!! Form::select('s_city',[null=>trans('lang.selectCity')],null,['class'=>'form-control select','id' => 'city']) !!}
                                                </div>
                                                <div class="form-group col-md-12">
                                                    {!! Form::label('s_email',trans('lang.email'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_email',null,['class' => 'form-control']) !!}

                                                    @if($errors->has('s_email'))
                                                        <strong class="font-red">{{ $errors->first('s_email') }}</strong>
                                                    @endif
                                                    <div id="s_email_validate" class="font-red"></div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    {!! Form::label('s_zip_code',trans('lang.zip_code'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_zip_code',null,['class' => 'form-control']) !!}
                                                </div>
                                                <div class="form-group col-md-12">
                                                    {!! Form::label('s_website',trans('lang.websiteLink'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_website',null,['class' => 'form-control']) !!}
                                                </div>
                                                {{--End Inputs--}}
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('s_address_ar',trans('lang.address_ar'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_address_ar',null,['class' => 'form-control']) !!}
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('s_address_en',trans('lang.address_en'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_address_en',null,['class' => 'form-control']) !!}
                                                </div>

                                                {{--new inputs--}}
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('s_sales_representative_name',trans('lang.salesRepresentativeName'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_sales_representative_name',null,['class' => 'form-control']) !!}
                                                    <div id="s_sales_representative_name_validate" class="font-red"></div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('s_sales_representative_mobile',trans('lang.salesRepresentativeMobile'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_sales_representative_mobile',null,['class' => 'form-control', 'id' => 's_sales_representative_mobile']) !!}
                                                </div>
                                                {{--end inputs--}}

                                                <div class="form-group col-md-3">
                                                    {!! Form::label('service_provider_image',trans('lang.service_provider_image')) !!}
                                                    <br>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail"
                                                             style="width: 200px; height: 150px;">
                                                            <img src="{{ isset($service_provider->s_image)?asset('/images/service_provider_images/'.$service_provider->s_image):asset('/images/service_provider_images/avatar.JPG') }}"
                                                                 alt=""></div>
                                                        @if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")
                                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                                 style="max-width: 200px; max-height: 150px;"></div>
                                                            <div>
                                                                            <span class="btn default btn-file">
                                                                                <span class="fileinput-new"> {{trans('lang.select_image')}} </span>
                                                                                <span class="fileinput-exists"> {{ trans('lang.change_img') }} </span>
                                                                                <input type="file"
                                                                                       name="service_provider_image"> </span>
                                                                <a href="javascript:;"
                                                                   class="btn default fileinput-exists"

                                                                   data-dismiss="fileinput">{{trans('lang.remove')}} </a>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                @if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")
                                                    <div class="form-group col-md-12" style="margin-top: 10px;">
                                                        {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}
                                                    </div>
                                                @endif


                                                {!! Form::close() !!}
                                            </div>
                                            <!-- END CLINIC INFO TAB -->

                                            <!-- CHANGE SERVICE PROVIDERS CITIES TAB -->
                                        {{--<div class="tab-pane {{session('tab2_state')?session('tab2_state'):''}}"--}}
                                        {{--id="tab_1_2">--}}

                                        {{--{!! Form::open(['method'=>'patch','action' =>['ServiceProviderController@updateSPCities',$service_provider->pk_i_id]]) !!}--}}

                                        {{--<div class="form-group">--}}

                                        {{--<div class="row">--}}
                                        {{--@foreach($cities as $city)--}}
                                        {{--<div class="col-sm-4">--}}
                                        {{--<input name="cities[]"--}}
                                        {{--{{ \App\helper\helpers::getCheckedCity($city->pk_i_id,$service_provider->pk_i_id) }} type="checkbox"--}}
                                        {{--value="{{$city->pk_i_id}}">--}}

                                        {{--{!! Form::label('cities',$city->s_name) !!}--}}
                                        {{--</div>--}}
                                        {{--@endforeach--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="margin-top-10">--}}
                                        {{--{!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}--}}

                                        {{--</div>--}}
                                        {{--{!! Form::close() !!}--}}
                                        {{--</div>--}}
                                        <!-- END CHANGE SERVICE PROVIDERS CITIES TAB -->


                                            <!-- LOCATIONS  TAB -->
                                            <div class="tab-pane {{session('tab3_state')?session('tab3_state'):''}}"
                                                 id="tab_1_3">


                                                {!! Form::open(['id'=>'serviceProviderLocationForm','method' => 'patch', 'action' =>['ServiceProviderController@updateSPLocation',$service_provider->pk_i_id]]) !!}

                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        {!! Form::label('latitude',trans('lang.latitude')) !!} <span
                                                                class="required font-red"
                                                                aria-required="true"> * </span>
                                                        {!! Form::text('lat',isset($service_provider->d_latitude)?$service_provider->d_latitude:null,['class'=>'form-control','id'=>'latbox','readonly']) !!}
                                                        @if($errors->has('lat'))
                                                            <strong class="font-red">{{ $errors->first('lat') }}</strong>
                                                        @endif
                                                        <strong class="font-red" id="lat_validate"></strong>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        {!! Form::label('longitude',trans('lang.longitude')) !!} <span
                                                                class="required font-red"
                                                                aria-required="true"> * </span>
                                                        {!! Form::text('lng',isset($service_provider->d_longitude)?$service_provider->d_longitude:null,['class'=>'form-control','id'=>'lngbox','readonly']) !!}
                                                        @if($errors->has('lng'))
                                                            <strong class="font-red">{{ $errors->first('lng') }}</strong>
                                                        @endif
                                                        <strong class="font-red" id="lng_validate"></strong>
                                                    </div>
                                                </div>
                                                <div id="map"></div>
                                                @if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")
                                                    <div class="margin-top-10">
                                                        {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}
                                                    </div>
                                                @endif

                                                {!! Form::close() !!}

                                            </div>
                                            <!-- END LOCATIONS TAB -->


                                            <!-- TIMES OF WORK  TAB -->
                                            <div class="tab-pane {{session('tab4_state')?session('tab4_state'):''}}"
                                                 id="tab_1_4">


                                                {!! Form::open(['id' => 'TimeOfWorkForm','method' => 'post', 'action' =>['ServiceProviderController@storeTimeOfWork',$service_provider->pk_i_id]]) !!}

                                                <div class="row">
                                                    <div class="pull-right">
                                                        <label for="check">{{ trans('lang.same_time') }}
                                                            <input type="checkbox" id="check">
                                                        </label>
                                                    </div>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="col-sm-2">@lang('lang.day')</th>
                                                            <th class="col-sm-3">@lang('lang.from')</th>
                                                            <th class="col-sm-3">@lang('lang.to')</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>@lang('lang.sat')</td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input id="from" name="from1" type="text"
                                                                           class="form-control timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[0]->t_from:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input id="to" name="to1" type="text"
                                                                           class="form-control timepicker1"
                                                                           value="">
                                                                    {{--{{  !$working->isEmpty()?$working[0]->t_to:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>@lang('lang.sun')</td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="from2" type="text"
                                                                           class="form-control from timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[1]->t_from:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>

                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to2" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[1]->t_to:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('lang.mon')</td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="from3" type="text"
                                                                           class="form-control from timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[2]->t_from:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to3" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[2]->t_to:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('lang.tue')</td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="from4" type="text"
                                                                           class="form-control from timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[3]->t_from:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to4" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[3]->t_to:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('lang.wed')</td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="from5" type="text"
                                                                           class="form-control from timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[4]->t_from:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to5" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="">
                                                                    {{--{{  !$working->isEmpty()?$working[4]->t_to:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('lang.thu')</td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="from6" type="text"
                                                                           class="form-control from timepicker1"
                                                                           value="">
                                                                    {{--{{  !$working->isEmpty()?$working[5]->t_from:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to6" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="">
                                                                    {{--{{  !$working->isEmpty()?$working[5]->t_to:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>@lang('lang.fri')</td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="from7" type="text"
                                                                           class="form-control from timepicker1"
                                                                           value="">
                                                                    {{--{{  !$working->isEmpty()?$working[6]->t_from:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to7" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="">
                                                                    {{--{{ !$working->isEmpty()?$working[6]->t_to:''}}--}}
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")
                                                    <div class="margin-top-10">
                                                        {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}
                                                    </div>
                                                @endif

                                                {!! Form::close() !!}

                                            </div>
                                            <!-- END TIMES OF WORK TAB -->

                                            <!-- ADDITIONAL INFO  TAB -->
                                            <div class="tab-pane {{session('tab5_state')?session('tab5_state'):''}}"
                                                 id="tab_1_5">


                                                {!! Form::open(['id' => 'SPAdditionalInfoForm','method' => 'patch', 'action' =>['ServiceProviderController@updateSPAdditionalInfo',$service_provider->pk_i_id]]) !!}

                                                <div class="form-group">
                                                    {!! Form::label('about_service_provider',trans('lang.about_service_provider'),['class'=>'control-label']) !!}
                                                    {!! Form::text('about_service_provider',!$profileMeta->isEmpty()?$profileMeta->get('AboutServiceProvider')->s_value:'',['class' => 'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('foundation_year',trans('lang.foundation_year'),['class'=>'control-label']) !!}
                                                    {!! Form::text('foundation_year',!$profileMeta->isEmpty()?$profileMeta->get('FoundationYear')->s_value:'',['class' => 'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('qualifications',trans('lang.qualifications'),['class'=>'control-label']) !!}
                                                    {!! Form::text('qualifications',!$profileMeta->isEmpty()?$profileMeta->get('Qualifications')->s_value:'',['class' => 'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('certifications',trans('lang.certifications'),['class'=>'control-label']) !!}
                                                    {!! Form::text('certifications',!$profileMeta->isEmpty()?$profileMeta->get('Certifications')->s_value:'',['class' => 'form-control']) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('accredited_by',trans('lang.accredited_by'),['class'=>'control-label']) !!}
                                                    {!! Form::text('accredited_by',!$profileMeta->isEmpty()?$profileMeta->get('AccreditedBy')->s_value:'',['class' => 'form-control']) !!}
                                                </div>
                                                @if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")
                                                    <div class="margin-top-10">
                                                        {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}
                                                    </div>
                                                @endif
                                                {!! Form::close() !!}

                                            </div>
                                        <!-- Bank Account Information Tab -->
                                            <div class="tab-pane {{session('tab6_state')?session('tab6_state'):''}}" id="tab_1_6">

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        @if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")
                                                        <button class="btn green" id="addNewBankAccount" style="margin-bottom: 2%"><span class="fa fa-plus"></span> @lang('lang.newBankAccount')</button>
                                                        @endif
                                                            <table class="table table-striped table-bordered table-hover" id="bankAccountsTable" style="width: 100%;">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>@lang('lang.BankAccountName')</th>
                                                                <th>@lang('lang.BankAccountNumber')</th>
                                                                <th>@lang('lang.BankAccountCurrency')</th>
{{--                                                                <th>@lang('lang.Notes')</th>--}}
                                                                <th>@lang('lang.status')</th>
                                                                <th>@lang('lang.options')</th>
                                                            </tr>
                                                            </thead>

                                                        </table>

                                                    </div>
                                                </div>

                                                <div id="addBankAccount" class="modal fade" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        {!! Form::open(['id'=>'addBankAccountForm','method'=>'POST','action'=>'ServiceProviderController@storeNewBankAccount', 'files' => true]) !!}
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">@lang('lang.newBankAccount')</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    {!! Form::hidden('fk_i_company_id',$service_provider->pk_i_id) !!}
                                                                    <div class="form-group col-sm-6">
                                                                        {!! Form::label('s_bank_name',trans('lang.BankAccountName')) !!}
                                                                        {!! Form::text('s_bank_name',null,['class'=>'form-control']) !!}
                                                                        <div id="s_bank_name_validate1" class="font-red"></div>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        {!! Form::label('s_account_number',trans('lang.BankAccountNumber')) !!}
                                                                        {!! Form::text('s_account_number',null,['class'=>'form-control']) !!}
                                                                        <div id="s_account_number_validate1" class="font-red"></div>

                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        {!! Form::label('s_bank_address',trans('lang.bankAddress')) !!}
                                                                        {!! Form::text('s_bank_address',null,['class'=>'form-control']) !!}
                                                                        <div id="s_bank_address_validate1" class="font-red"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-sm-6">
                                                                        {!! Form::label('s_iban','IBAN') !!}
                                                                        {!! Form::text('s_iban',null,['class'=>'form-control']) !!}
                                                                        <div id="s_iban_validate1" class="font-red"></div>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        {!! Form::label('s_swift','SWIFT') !!}
                                                                        {!! Form::text('s_swift',null,['class'=>'form-control']) !!}
                                                                        <div id="s_swift_validate1" class="font-red"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        {!! Form::label('s_currency',trans('lang.BankAccountCurrency')) !!}
                                                                        {!! Form::select('s_currency',[null=>trans('lang.selectCurrency')]+$currencies,null,['class'=>'form-control select','id' => 'currency']) !!}
                                                                        <div id="s_currency_validate1" class="font-red"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-sm-6">
                                                                        {!! Form::label('BankAccountCurrency',trans('lang.bankCertificate')) !!}
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="input-group input-large">
                                                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                                    <span class="fileinput-filename"> </span>
                                                                                </div>
                                                                                <span class="input-group-addon btn default btn-file">
                                                                                <span class="fileinput-new"> {{ trans('lang.selectFile') }} </span>
                                                                                <span class="fileinput-exists"> {{ trans('lang.change_file') }} </span>
                                                                                <input type="file" name="s_bankCertificate"> </span>
                                                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> {{ trans('lang.remove') }} </a>
                                                                            </div>
                                                                        </div>
                                                                        <div id="s_bankCertificate_validate" class="font-red"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        {!! Form::label('s_note',trans('lang.Notes')) !!}
                                                                        {!! Form::textarea('s_note',null,['class'=>'form-control', 'rows' => 2]) !!}
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">@lang('lang.close')</button>
                                                                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                        {!! Form::close() !!}
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                <div id="showBankAccount" class="modal fade" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        {!! Form::open(['id'=>'editBankAccount','method'=>'PATCH','action'=>'ServiceProviderController@updateBankAccount','files' => true]) !!}
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">@lang('lang.editBankAccount')</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    {!! Form::hidden('pk_i_id',null,['id'=>'bankAccountID']) !!}
                                                                    {!! Form::hidden('companyID',null,['id'=>'companyID']) !!}
                                                                    <div class="form-group col-md-6">
                                                                        {!! Form::label('bankAccountName',trans('lang.BankAccountName')) !!}
                                                                        {!! Form::text('bankAccountName',null,['class'=>'form-control','id'=>'providerBankAccountName']) !!}
                                                                        <div id="bankAccountName_validate1" class="font-red"></div>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        {!! Form::label('bankAccountNumber',trans('lang.BankAccountNumber')) !!}
                                                                        {!! Form::text('bankAccountNumber',null,['class'=>'form-control','id'=>'providerBankAccountNumber']) !!}
                                                                        <div id="bankAccountNumber_validate1" class="font-red"></div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-12">
                                                                        {!! Form::label('BankAddress',trans('lang.bankAddress')) !!}
                                                                        {!! Form::text('BankAddress',null,['class'=>'form-control', 'id' => 'BankAddress'] ) !!}
                                                                        <div id="BankAddress_validate1" class="font-red"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        {!! Form::label('IBANBank','IBAN') !!}
                                                                        {!! Form::text('IBANBank',null,['class'=>'form-control', 'id' => 'IBANBank']) !!}
                                                                        <div id="IBANBank_validate1" class="font-red"></div>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        {!! Form::label('SWIFTBank','SWIFT') !!}
                                                                        {!! Form::text('SWIFTBank',null,['class'=>'form-control', 'id' => 'SWIFTBank']) !!}
                                                                        <div id="SWIFTBank_validate1" class="font-red"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-sm-12">
                                                                        {!! Form::label('BankAccountCurrency',trans('lang.BankAccountCurrency')) !!}
                                                                        {!! Form::select('BankAccountCurrency',[null=>trans('lang.selectCurrency')]+$currencies,null,['class'=>'form-control select','id'=>'BankAccountCurrency']) !!}
                                                                        <div id="BankAccountCurrency_validate1" class="font-red"></div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        {!! Form::label('BankAccountCurrency',trans('lang.bankCertificate')) !!}
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="input-group input-large">
                                                                                <div class="form-control uneditable-input input-fixed input-medium">
                                                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                                    <span class="fileinput-filename"> </span>
                                                                                </div>
                                                                                <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new">{{ trans('lang.selectFile') }}</span>
                                                                <span class="fileinput-exists">{{ trans('lang.change_file') }}</span>
                                                                <input type="file" name="bankCertificate" id="bankCertificate"> </span>
                                                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">{{ trans('lang.remove') }}</a>
                                                                            </div>
                                                                        </div>
                                                                        <div id="bankCertificate_validate" class="font-red"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group col-md-12 bankFileFounded">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-12">
                                                                        {!! Form::label('BankAccountNotes',trans('lang.Notes')) !!}
                                                                        {!! Form::textarea('BankAccountNotes',null,['class'=>'form-control', 'id' => 'BankAccountNotes', 'rows' => 2]) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">@lang('lang.close')</button>
                                                                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                        {!! Form::close() !!}
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                {{--{!! Form::model($BankAccountInfo,['id'=>'SPBankAccountInfoForm','method' => 'patch', 'action' =>['ServiceProviderController@updateSPBankAccountInfo',$service_provider->pk_i_id],'files' => true]) !!}--}}
                                                {{--<div class="form-group">--}}
                                                    {{--{!! Form::label('s_bank_name',trans('lang.BankAccountName'),['class'=>'control-label']) !!}--}}
                                                    {{--{!! Form::text('s_bank_name',null,['class' => 'form-control']) !!}--}}
                                                {{--</div>--}}

                                                {{--<div class="form-group">--}}
                                                    {{--{!! Form::label('s_account_number',trans('lang.BankAccountNumber'),['class'=>'control-label']) !!}--}}
                                                    {{--{!! Form::text('s_account_number',null,['class' => 'form-control']) !!}--}}
                                                {{--</div>--}}
                                                {{--New Inputs--}}
                                                {{--<div class="form-group">--}}
                                                    {{--{!! Form::label('s_currency',trans('lang.BankAccountCurrency'),['class'=>'control-label','id' => 'countryLabel','data-val' => $service_provider->pk_i_id]) !!}--}}
                                                    {{--{!! Form::select('s_currency',[null=>trans('lang.selectCurrency')]+$currencies,null,['class'=>'form-control select','id' => 'currency']) !!}--}}
                                                    {{-- {!! Form::select('s_country',isset($status)?$status:[],null,['class'=>'form-control select','id' => 'status']) !!}--}}
                                                {{--</div>--}}

                                                {{--<div class="form-group">--}}
                                                    {{--{!! Form::label('s_note',trans('lang.Notes'),['class'=>'control-label']) !!}--}}
                                                    {{--{!! Form::textarea('s_note',null,['class' => 'form-control','id' => 's_note']) !!}--}}
                                                {{--</div>--}}

                                                {{--@if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")--}}
                                                    {{--<div class="form-group col-md-12" style="margin-top: 10px;">--}}
                                                        {{--{!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}--}}
                                                    {{--</div>--}}
                                                {{--@endif--}}

                                                {{--{!! Form::close() !!}--}}

                                            </div>
                                            <div class="tab-pane {{session('tab7_state')?session('tab7_state'):''}}" id="tab_1_7">
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-3 alert alert-danger alert-dismissible text-center" id="alreadyExistCategory" style="display: none;">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                    {{ trans('lang.alreadyExistCategory') }}
                                                    </div>
                                                    <div class="col-sm-6 col-sm-offset-3 alert alert-success alert-dismissible text-center" id="alreadyExistTender" style="display: none;">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        {{--<label class="alreadyExistTender"></label>--}}
                                                    </div>
                                                </div>
                                                    {{--<form id="SPAccountCategoriesInfoForm" method="POST" action="{{url('/serviceProvider/'.$service_provider->pk_i_id.'/insertOrUpdateCategory')}}">--}}
                                                        <form id="SPAccountCategoriesInfoForm">
                                                        {{--<label>{{ trans('lang.categories') }}</label>--}}
                                                {{--<label id="companyCategoryID" data-val="{{ $service_provider->pk_i_id }}" name="fk_i_categories_id" class="control-label">{{trans('lang.categories')}}</label>--}}
                                                    {{--<div class="col-md-12">--}}
                                                    {{--<div class="checkbox-list" id="checkBoxCategory">--}}
                                                    {{--@foreach($categories as $category)--}}
                                                            {{--<div class="col-md-4">--}}
                                                                {{--<label>--}}
                                                                    {{--@if($category->b_enabled == 1)--}}
                                                                        {{--<input id="category-{{$category->pk_i_id}}" type="checkbox" name="category[]" value="{{$category->pk_i_id}}">--}}
                                                                        {{--{{ $category->s_name }}--}}
                                                                    {{--@endif--}}
                                                                {{--</label>--}}
                                                            {{--</div>--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                        <div class="row" id="">
                                                            <div class="" id="parentCategory" class="parentCategory">
                                                                <div class="form-group col-sm-3 selectSubCategory" id="subCategory-1">
{{--                                                                    {!! Form::label('category',trans('lang.category')) !!}--}}
                                                                    <label name="category">{{trans('lang.category')}}</label>
                                                                    <select class="selectCategory" id="category-1" name="category-1">
                                                                        <option value="">{{trans('lang.selectCategory')}}</option>
                                                                    @foreach($categories as $category)
                                                                            <option value="{{$category->pk_i_id}}">{{$category->s_name}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                    <div id="category1_validate1" class="font-red"></div>
{{--                                                                    {!! Form::select('category',isset($parentCategory)?$parentCategory:[],null,['class'=>'form-control select','id' => 'category']) !!}--}}
                                                                </div>
                                                            </div>
                                                            @if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")
                                                                <div class="col-sm-3">
                                                                    <div class="margin-top-9">
                                                                        <br>
                                                                        <input type="submit" value="{{trans('lang.save')}}" class="btn green submitCategory">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                        <input type="hidden" class="catID">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="row">
                                                            {{--@if($service_provider->i_status != "20" || $userStatus->s_name_en == "SuperAdmin")--}}
                                                                {{--<div class="col-sm-2 col-sm-offset-6">--}}
                                                                    {{--<div class="margin-top-10">--}}
                                                                        {{--<input type="submit" value="{{trans('lang.save')}}" class="btn green">--}}
                                                                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--@endif--}}
                                                        </div>

                                                        <div class="row" style="margin-top: 2%">
                                                            <label>{{ trans('lang.selectedCategories') }}</label>
                                                            <div class="col-sm-12 daynmicaSubCategories">
                                                                @foreach($companyCategory as $cc)
                                                                    <div class="col-sm-3 subCategoryDiv">
                                                                        <label><a class="removeCategory" id="{{$cc->category->pk_i_id}}"><span class="glyphicon glyphicon-remove-sign"></span></a>&nbsp;{{$cc->category->s_name}}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </form>

                                            </div>
                                        <!-- Sales Represenative Information Tab -->

                                            <!-- ADDITIONAL INFO  TAB -->

                                    </div>
                                @if($service_provider->i_status != "20" && $userStatus->s_name_en !== "SuperAdmin")
                                        {{--<a href="{{ url('/approvedAccount/'.$service_provider->pk_i_id.'') }}" class="btn btn-info col-sm-offset-5" style="">{{ trans('lang.approveCompanyAccount') }}</a>--}}
                                        <button id="approvedPSAccount" class="btn btn-danger col-md-3 col-sm-offset-5" style="">{{ trans('lang.approveCompanyAccount') }}</button>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>


@endsection
@section('scripts')

    <script>
        var table;
        $('body').on('click', '#addNewBankAccount', function () {
            $('#addBankAccount').modal('show');
            $('#addBankAccountForm').validate({
                rules: {
                    s_bank_name: "required",
                    s_account_number: "required",
                    s_currency: "required",
                    s_bank_address: "required",
                    s_iban: "required",
                    s_swift: "required"
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    error.appendTo($("#" + name + "_validate1"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    s_bank_name: "اسم البنك حقل مطلوب",
                    s_account_number: "رقم الحساب البنكي حقل مطلوب",
                    s_currency: " العملة حقل مطلوب",
                    s_bank_address: "عنوان البنك حقل مطلوب",
                    s_iban : "IBAN حقل مطلوب",
                    s_swift : "SWIFT حقل مطلوب",
                    @else
                    s_bank_name: "Bank name field is required",
                    s_account_number: "Bank account number field is required",
                    s_currency: "Currency field is required",
                    s_bank_address: "Bank Address field is required",
                    s_iban: "IBAN field id required",
                    s_iban: "SWIFT field id required"
                    @endif
                }, submitHandler: function (form) {
                    form.submit();
                }
            });
        });


            $('body').on('change', '#check', function () {
            var from = $('#from').val();
            var to = $('#to').val();

            $('.from').each(function (i) {
                $(this).val(from);
            });
            $('.to').each(function (i) {
                $(this).val(to);
            });
        });


    </script>

    <script type="text/javascript">
        $(function () {
            $('.timepicker1').timepicker({
                format: 'LT',
                showMeridian: false
            });
            $('.date-picker').datetimepicker({
                format: 'yyyy-mm-dd hh:ii'
            });

        });
    </script>

    <script>
        Dropzone.options.clinicImagesForm = {
            paramName: 'clinic_image',
            maxFilesize: 4,
            acceptedFiles: '.jpg, .jpeg, .png, .bmp'
        };

    </script>

    <script>

        var map;
        function initMap() {
//            var uluru = {lat: 25.202310491859688, lng: 55.27056536102293};
            var uluru = {lat: 31.80859126144234, lng: 35.22875627899168};
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                draggable: true,
                map: map
            });

            google.maps.event.addListener(marker, 'dragend', function (event) {
                document.getElementById("latbox").value = this.getPosition().lat();
                document.getElementById("lngbox").value = this.getPosition().lng();
            });

        }
        $("#locationTab").on("shown.bs.tab", function (e) {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });

    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxmPnKKteOdi-Gj7prFgssVaHYqGL3YNw&callback=initMap">
    </script>

    <script>
        $('#my_multi_select2').multiSelect();
    </script>


    <script>
//        $('#country').change(function () {
//            alert($('#country').val())
//        })

                    var lang = {
                        sLengthMenu: "عرض _MENU_ من العناصر",
                        sSearch: "ابحث هنا",
                        sEmptyTable: "لا يوجد عناصر مضافة حاليا",
                        sInfo: "عرض _START_ الى _END_ من _TOTAL_ العناصر",
                        sInfoEmpty: "لا يوجد عناصر",
                        sInfoFiltered: "(من العدد الكلي)",
                        sInfoPostFix: " ",
                        sLoadingRecords: "يتم تحميل المعلومات ....",
                        sProcessing: "تتم المعاملة",
                        sZeroRecords: "لا يوجد عناصر مطابقة للبحث",
                        sPaginate: {
                            "first": "الأول",
                            "previous": "السابق",
                            "next": "التالي",
                            "last": "الأخير"
                        },
                        aria: {
                            "sortAscending": ": اضغط للترتيب تصاعديا",
                            "sortDescending": ": اضغط للترتيب تنازليا"
                        },
                        decimal: "",
                        thousands: ","

                    };

                table = $('#bankAccountsTable').DataTable({
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": '{{url('/admin/'.$service_provider->pk_i_id.'/getBankAccounts')}}'
                    },
                    "columns": [
                        {
                            mRender: function (data, type, row, full) {
                                return full['row'] + 1;
                            }
                        },
                        {data: 's_bank_name', name: 's_bank_name',defaultContent:""},
                        {data: 's_account_number', name: 's_account_number',defaultContent:""},
                        {data: 'status.s_name', name: 'status.s_name',defaultContent:""},
//                        {data: 's_note', name: 's_note',defaultContent:""},
                        {
                            mRender: function (data, type, row, full) {
                                @if(app()->getLocale() == 'en')
                                if (row['b_enabled'] == 1) {
                                    return "enable";
                                } else {
                                    return "disable";
                                }
                                @else
                                if (row['b_enabled'] == 0) {
                                    return "غير فعال";
                                } else {
                                    return "فعال";
                                }
                                @endif
                            }
                        },
                        {
                            mRender: function (data, type, row, full) {
                                var aTag;
                                if(row['b_enabled'] == 1){
                                    aTag = '<a target="_blank" id="deleteBankAccount" data-id="'+row['pk_i_id']+'" data-val="0">@lang('lang.delete')</a>';
                                }
                                else{
                                    aTag = '<a target="_blank" id="retrieveBankAccount" data-id="'+row['pk_i_id']+'" data-val="1">@lang('lang.enable')</a>';
                                }
                                if($('.companyStatus').data('val') == "20") {
                                    if ($('.userStatus').data('val') != 'SuperAdmin') {
                                        return '';
                                    }
                                }
                                var attachURL = "";
                                var attachName = "";
                                if(row['attachment'] != null){
                                    attachURL = row['attachment'].s_url
                                    attachName = row['attachment'].s_name

                                }
                                return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a class="editBankAccount">@lang('lang.editBankAccount')</a>' +
                                    '<input type="hidden" id="s_bank_name" value="' + row['s_bank_name'] + '">' +
                                    '<input type="hidden" id="s_account_number" value="' + row['s_account_number'] + '">' +
                                    '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                    '<input type="hidden" id="s_currency" value="' + row['s_currency'] + '">' +
                                    '<input type="hidden" id="s_note" value="' + row['s_note'] + '">' +
                                    '<input type="hidden" id="s_bank_address" value="' + row['s_bank_address'] + '">' +
                                    '<input type="hidden" id="s_iban" value="' + row['s_iban'] + '">' +
                                    '<input type="hidden" id="s_swift" value="' + row['s_swift'] + '">' +
                                    '<input type="hidden" id="s_bank_file" value="' + attachURL + '" data-name="'+attachName+'">' +
                                    '</li>' +
                                    '<li>' +
                                        aTag +
                                    '</li>' +
                                    '</ul>' +
                                    '</div>';

                            }
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            text: '',
                            className: 'hidden'
                        }

                    ],
                    "bLengthChange": true,
                    "bFilter": true,
                    "pageLength": 10,
                    @if(app()->getLocale() == 'ar')
                    language: lang
                    @endif
                });
                @if(app()->getLocale() == 'ar')
                $('.prev').children().children().removeClass('fa fa-angle-left');
                $('.prev').children().children().addClass('fa fa-angle-right');
                $('.next').children().children().removeClass('fa fa-angle-right');
                $('.next').children().children().addClass('fa fa-angle-left');
                @endif
                    $('input[type="search"]').removeClass('input-small');
//                   $('input[type="search"]').css(
//                    {'width':'100%'}
//                );

                $('.alert-dismissible').delay(3000).fadeOut('slow');

            $('#document').ready(function () {
                $('#category-1').select2();
//                var currencyID = $('#currency').data('val');
//                $('#currency').find('option').not(':first').remove();
//                $("#currency option[value='"+currencyID+"']").attr("selected", true);
                if($('.companyStatus').data('val') == "20"){
                        if($('.userStatus').data('val') != 'SuperAdmin'){
                            $("#ServiceProviderInfoForm :input").prop("disabled", true);
                            $("#serviceProviderLocationForm :input").prop("disabled", true);
                            $('#SPBankAccountInfoForm :input').prop('disabled', true);
                            $('#SPAccountCategoriesInfoForm :input').prop('disabled', true);
                            $("#TimeOfWorkForm :input").prop("disabled", true);
                            $("#SPAdditionalInfoForm :input").prop("disabled", true);
                        }
                    }
                if($('#country').val() !== null){
//                    alert($('#countryLabel').data('val'));
                    var countryID = $('#country').val();
                    if(countryID != ''){
                        $('#city').find('option').not(':first').remove();
                        $.ajax({
                            method:'GET',
                            dataType: 'json',
                            url: '{{url('/')}}/' + countryID + '/getCities',
                            data:{
                                "_token": "{{csrf_token()}}",
                                'companyID': $('#countryLabel').data('val')
                            },
                            success: function (data, textStatus, jqXHR) {
                                $.each(data.city, function (i, item) {
                                    $('#city').append($('<option>', {
                                        value: item.pk_i_id,
                                        text : function () {
                                            return item.s_name
                                        }
                                    }));
                                });
                                if(data.companyCity.s_city != null){
                                    $("#city option[value='"+data.companyCity.s_city+"']").attr("selected", true);
                                }
                            }
                        })
                    }
                }
                {{--var categoryID = $('#companyCategoryID').data('val');--}}
                {{--$.ajax({--}}
                    {{--method:'GET',--}}
                    {{--dataType: 'json',--}}
                    {{--url: '{{url('/')}}/' + categoryID + '/getCategories',--}}
                    {{--data:{--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                    {{--},--}}
                    {{--success: function (data, textStatus, jqXHR) {--}}
                        {{--$.each(data.companyCategory, function (i, item) {--}}
                            {{--$('input:checkbox[name="category[]"]').each(function()--}}
                            {{--{--}}
                                {{--if($(this).val() == item.fk_i_categories_id){--}}
                                    {{--$(this).attr('checked', true);--}}
                                {{--}--}}
                            {{--});--}}
                        {{--});--}}
                    {{--}--}}
                {{--})--}}
                
//                $('input:checkbox[name="category[]"]').click(function () {
//                    if($(this).is(':checked')){
//                        $(this).attr('checked', true);
//                    }
//                    else{
//                        $(this).attr('checked', false);
//                    }
//                })

//                $("#category-2").click(function() {
//                    // this function will get executed every time the #home element is clicked (or tab-spacebar changed)
//                    if($(this).is(":checked")) // "this" refers to the element that fired the event
//                    {
//                        alert('home is checked');
//                    }
//                });
                {{--$.ajax({--}}
                    {{--method:'GET',--}}
                    {{--dataType: 'json',--}}
                    {{--url:'{{url('/')}}/getCountries',--}}
                    {{--data:{--}}
                        {{--"_token": "{{csrf_token()}}"--}}
                    {{--},--}}
                    {{--success: function (data, textStatus, jqXHR) {--}}
                        {{--$.each(data.country, function (i, item) {--}}
                            {{--$('#country').append($('<option>', {--}}
                                {{--value: item.pk_i_id,--}}
                                {{--text : function () {--}}
                                    {{--@if(app()->getLocale() == 'ar')--}}
                                        {{--return item.s_name_ar--}}
                                    {{--@else--}}
                                        {{--return item.s_name_en--}}
                                    {{--@endif--}}
                                {{--}--}}
                            {{--}));--}}
                        {{--});--}}
                    {{--}--}}
                {{--})--}}



//                $('#approvedPSAccount').click(function () {
//
//                });
            });



function ezBSAlert (options) {
    var deferredObject = $.Deferred();
    var defaults = {
        type: "alert", //alert, prompt,confirm
        modalSize: 'modal-sm', //modal-sm, modal-lg
        okButtonText: 'Ok',
        cancelButtonText: 'Cancel',
        yesButtonText: '{{ trans('lang.okBtn') }}',
        noButtonText: '{{ trans('lang.noBtn') }}',
        headerText: '{{ trans('lang.approvedTitle') }}',
        messageText: 'Message',
        alertType: 'default', //default, primary, success, info, warning, danger
        inputFieldType: 'text', //could ask for number,email,etc
    }
    $.extend(defaults, options);

    var _show = function(){
        var headClass = "navbar-default";
        switch (defaults.alertType) {
            case "primary":
                headClass = "alert-primary";
                break;
            case "success":
                headClass = "alert-success";
                break;
            case "info":
                headClass = "alert-info";
                break;
            case "warning":
                headClass = "alert-warning";
                break;
            case "danger":
                headClass = "alert-danger";
                break;
        }
        $('BODY').append(
            '<div id="ezAlerts" class="modal fade">' +
            '<div class="modal-dialog" class="' + defaults.modalSize + '">' +
            '<div class="modal-content">' +
            '<div id="ezAlerts-header" class="modal-header ' + headClass + '">' +
            '<button id="close-button" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
            '<h4 id="ezAlerts-title" class="modal-title">Modal title</h4>' +
            '</div>' +
            '<div id="ezAlerts-body" class="modal-body">' +
            '<div id="ezAlerts-message" ></div>' +
            '</div>' +
            '<div id="ezAlerts-footer" class="modal-footer">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );

        $('.modal-header').css({
            'padding': '15px 15px',
            '-webkit-border-top-left-radius': '5px',
            '-webkit-border-top-right-radius': '5px',
            '-moz-border-radius-topleft': '5px',
            '-moz-border-radius-topright': '5px',
            'border-top-left-radius': '5px',
            'border-top-right-radius': '5px'
        });

        $('#ezAlerts-title').text(defaults.headerText);
        $('#ezAlerts-message').html(defaults.messageText);

        var keyb = "false", backd = "static";
        var calbackParam = "";
        switch (defaults.type) {
            case 'alert':
                keyb = "true";
                backd = "true";
                $('#ezAlerts-footer').html('<button class="btn btn-' + defaults.alertType + '">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
                    calbackParam = true;
                    $('#ezAlerts').modal('hide');
                });
                break;
            case 'confirm':
                var btnhtml = '<a href="{{ url('/approvedAccount/'.$service_provider->pk_i_id.'') }}" id="ezok-btn" class="btn btn-primary">' + defaults.yesButtonText + '</a>';
                if (defaults.noButtonText && defaults.noButtonText.length > 0) {
                    btnhtml += '<button id="ezclose-btn" class="btn btn-default">' + defaults.noButtonText + '</button>';
                }
                $('#ezAlerts-footer').html(btnhtml).on('click', 'button', function (e) {
                    if (e.target.id === 'ezok-btn') {
                        calbackParam = true;
                        $('#ezAlerts').modal('hide');
                    } else if (e.target.id === 'ezclose-btn') {
                        calbackParam = false;
                        $('#ezAlerts').modal('hide');
                    }
                });
                break;
            case 'prompt':
                $('#ezAlerts-message').html(defaults.messageText + '<br /><br /><div class="form-group"><input type="' + defaults.inputFieldType + '" class="form-control" id="prompt" /></div>');
                $('#ezAlerts-footer').html('<button class="btn btn-primary">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
                    calbackParam = $('#prompt').val();
                    $('#ezAlerts').modal('hide');
                });
                break;
        }

        $('#ezAlerts').modal({
            show: false,
            backdrop: backd,
            keyboard: keyb
        }).on('hidden.bs.modal', function (e) {
            $('#ezAlerts').remove();
            deferredObject.resolve(calbackParam);
        }).on('shown.bs.modal', function (e) {
            if ($('#prompt').length > 0) {
                $('#prompt').focus();
            }
        }).modal('show');
    }

    _show();
    return deferredObject.promise();
}

$(document).ready(function(){
    $("#btnAlert").on("click", function(){
        var prom = ezBSAlert({
            messageText: "hello world",
            alertType: "danger"
        }).done(function (e) {
            $("body").append('<div>Callback from alert</div>');
        });
    });

    $("#approvedPSAccount").on("click", function(){
//        $('#ServiceProviderInfoForm').validate();
//        if($('#ServiceProviderInfoForm').valid()){
            ezBSAlert({
                type: "confirm",
                messageText: "{{ trans('lang.approvedBody') }}",
                alertType: "info"
            }).done(function (e) {

            });
//        }
    });

    $("#btnPrompt").on("click", function(){
        ezBSAlert({
            type: "prompt",
            messageText: "Enter Something",
            alertType: "primary"
        }).done(function (e) {
            ezBSAlert({
                messageText: "You entered: " + e,
                alertType: "success"
            });
        });
    });

});

            $('#country').change(function () {
               var countryID = $('#country').val();
                $('#city').find('option').not(':first').remove();
                $.ajax({
                   method:'GET',
                   dataType: 'json',
                   url: '{{url('/')}}/' + countryID + '/getCities',
                   data:{
                       "_token": "{{csrf_token()}}"
                   },
                   success: function (data, textStatus, jqXHR) {
                       $.each(data.city, function (i, item) {
                           $('#city').append($('<option>', {
                               value: item.pk_i_id,
                               text : function () {
                                       return item.s_name
                               }
                           }));
                       });
                   }
               })
            });

        $('#ServiceProviderInfoForm').validate({
            rules: {
                s_name_ar: "required",
                s_name_en: "required",
//                s_company_name: "required",
                s_trade_license_no: {
                    required: true,
                    digits: true
                },
                s_fax: {
                  required: true
                },
                s_email: {
                  required: true,
                  email: true
                },
                s_telephone_number: {
                    required: true,
                    digits: true
                },
                s_mobile_number: {
                    required: true,
                    digits: true
                },
                s_sales_representative_name:{
                    required: function () {
                        if($('#s_sales_representative_mobile').val() != "")
                            return true;
                        else
                            return false;
                    }
                }
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                s_name_ar: "مزود الخدمة حقل مطلوب",
                s_name_en: "مزود الخدمة (English) حقل مطلوب",
//                s_company_name: "الشركة حقل مطلوب",
                s_trade_license_no: {
                    required: "عدد الرخص التجارية حقل مطلوب",
                    digits: "عدد الرخص التجارية يجب ان يحتوي على ارقام فقط"
                },
                s_fax: {
                  required: "رقم الفاكس حقل مطلوب"
                },
                s_sales_representative_name:{
                    required: "الرجاء ادخال اسم مندوب المبيعات"
                },
                s_telephone_number: {
                    required: "رقم التلفون حقل مطلوب",
                    digits: "رقم التلفون يجب ان يحتوي على ارقام فقط"
                },
                s_mobile_number: {
                    required: "رقم الجوال حقل مطلوب",
                    digits: "رقم الجوال يجب ان يحتوي على ارقام فقط"
                },
                s_email:{
                    required: "إيميل الشركة حقل مطلوب",
                    email: "الرجاء ادخال الايميل بالشكل الصحيح"
                },
                @else
                s_name_ar: "service provider (Arabic) field is required",
                s_name_en: "service provider field is required",
//                s_company_name: "company field is required",
                s_trade_license_no: {
                    required: "trade license number field is required",
                    digits: "trade license number must contains digits only"
                },
                s_fax: {
                  required: "Fax Number field is required"
                },
                s_sales_representative_name:{
                    required:"Please enter sales representative name"
                },
                s_telephone_number: {
                    required: "telephone number field is required",
                    digits: "telephone number field must contains digits only"
                },
                s_mobile_number: {
                    required: "mobile number field is required",
                    digits: "mobile number field must contains digits only"
                },
                s_email:{
                    required: "E-mail field is required",
                    email: "Please enter a valid email"
                },
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>

    <script>
        $('#serviceProviderLocationForm').validate({
            rules: {
                lat: "required",
                lng: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                lat: "خط العرض حقل مطلوب",
                lng: "خط الطول حقل مطلوب",
                @else
                lat: "latitude is required field",
                lng: "longitude is required field",
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
    <script>
        $('body').on('click', '.editBankAccount', function () {
            $('.bankFileFounded').find('a').remove();
            var pk_i_id = $(this).siblings('#pk_i_id').val();
            var s_bank_name = $(this).siblings('#s_bank_name').val();
            var s_account_number = $(this).siblings('#s_account_number').val();
            var s_currency = $(this).siblings('#s_currency').val();
            var s_note = $(this).siblings('#s_note').val();
            var s_bank_address = $(this).siblings('#s_bank_address').val();
            var s_iban = $(this).siblings('#s_iban').val();
            var s_swift = $(this).siblings('#s_swift').val();
            var s_file_url = $(this).siblings('#s_bank_file').val();
            var s_file_name = $(this).siblings('#s_bank_file').data('name');

            if(s_file_url != ""){
                $('.bankFileFounded').append($("<a></a>").attr("href",'{{ asset('/files/bank/') }}/'+s_file_url).text(s_file_name));
            }

            $('#providerBankAccountName').val(s_bank_name);
            $('#providerBankAccountNumber').val(s_account_number);
            $('#bankAccountID').val(pk_i_id);
            $('#companyID').val(parseInt('{{$service_provider->pk_i_id}}'));
            $('#BankAccountNotes').val(s_note);
            $('#BankAddress').val(s_bank_address);
            $('#IBANBank').val(s_iban);
            $('#SWIFTBank').val(s_swift);

            $('#BankAccountCurrency').val(s_currency);
            $('#BankAccountCurrency').select2();
            $('#showBankAccount').modal('show');
        });
    </script>
    <script>
        $('body').on('click', '#deleteBankAccount', function () {
            var BankAccountID = $(this).data("id");
            var BankAccountStatus = $(this).data("val");
            swal({
                    title: "{{ trans('lang.sure') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('lang.yes_delete') }}",
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: '{{url('/')}}/provider/changeBankAccountStatus',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "BankAccountID": BankAccountID,
                            "BankAccountStatus": BankAccountStatus
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.status) {
                                swal("{{trans('lang.success')}}", "{{trans('lang.deleted')}}", "success");
                                table.ajax.reload();
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });

                });
        });
    </script>
    <script>
        $('body').on('click', '#retrieveBankAccount', function () {
            var BankAccountID = $(this).data("id");
            var BankAccountStatus = $(this).data("val");
            swal({
                    title: "{{ trans('lang.sure') }}",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "{{ trans('lang.yes_enable') }}",
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: '{{url('/')}}/provider/changeBankAccountStatus',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "BankAccountID": BankAccountID,
                            "BankAccountStatus": BankAccountStatus
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.status) {
                                swal("{{trans('lang.success')}}", "{{trans('lang.activationBankAccount')}}", "success");
                                table.ajax.reload();
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });

                });
        });
    </script>
    <script>
        $('#editBankAccount').validate({
            rules: {
                bankAccountName: "required",
                bankAccountNumber: "required",
                BankAccountCurrency: "required",
                BankAddress: "required",
                IBANBank: "required",
                SWIFTBank: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate1"));
            },
            messages: {
                @if(app()->getLocale() =='ar')
                bankAccountName: "اسم البنك حقل مطلوب",
                bankAccountNumber: "رقم الحساب البنكي حقل مطلوب",
                BankAccountCurrency: " العملة حقل مطلوب",
                BankAddress: "عنوان البنك حقل مطلوب",
                IBANBank : "IBAN حقل مطلوب",
                SWIFTBank : "SWIFT حقل مطلوب",
                @else
                bankAccountName: "Bank name field is required",
                bankAccountNumber: "Bank account number field is required",
                BankAccountCurrency: "Currency field is required",
                BankAddress: "Bank Address field is required",
                IBANBank: "IBAN field id required",
                SWIFTBank: "SWIFT field id required"
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });

    </script>
    <script>
        var finalCategoryID = '';
        $('body').on('change', '.selectCategory', function() {
            var currentCategoryID = $(this).attr('id').split('-');
            var CID = parseInt(currentCategoryID[1]);
            if($(this).val() == ''){
                finalCategoryID = $(this).closest('.selectSubCategory').prev().find('.selectCategory').val()
            }
            else{
                finalCategoryID = $(this).val()
            }

//            $('.catID').attr('value', $(this).val());
//            $(".selectSubCategory:not(:has(#subCategory-1))").remove();
//            finalCategoryID = $(this).val()
            $('.selectCategory').each(function () {
                var currentID = $(this).attr('id').split('-');
                var id = parseInt(currentID[1]);
                if(id > CID)
                    $(this).parent('.selectSubCategory').remove();
            })

            var categoryID = $(this).val();
            var categoryName = $(this).find("option:selected").text()
            if($(this).val()){
                $('.submitCategory').prop('disabled', true);
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/' + categoryID + '/getSubCategories',
                    {{--url: '{{url('/')}}/category/' + CID + '/getSubCategories',--}}
                    data:{
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.status){
                            var cid = CID+1;
                            var labelTag = $("<label name='"+categoryName+"'>{{ trans('lang.subCategories') }} / "+categoryName+" </label>");
                            var selectTag = $('<select class="selectCategory" id="category-'+cid+'" name="category-'+cid+'"></select>');
                            selectTag.append('<option value="">{{ trans('lang.selectCategory') }}</option>');
                            var divTag = $('<div class="form-group col-sm-3 selectSubCategory" id="subCategory-'+cid+'"></div>');
                            divTag.append(labelTag);
                            $.each(data.subCategories, function (i, item) {
                                selectTag.append('<option value="'+item.pk_i_id+'">'+item.s_name+'</option>');
                            });
                            divTag.append(selectTag);
                            $('#parentCategory').append(divTag);
                            $('.selectCategory').select2();
                        }
                        $('.submitCategory').prop('disabled', false);
                    }
                })
            }

        })
    </script>
    <script>
        $('#SPAccountCategoriesInfoForm').validate({
            {{--rules: {--}}
                {{--"category[]": {--}}
                    {{--required: true--}}
                {{--}--}}
            {{--},--}}
//            errorPlacement: function (error, element) {
//                var name = $(element).attr("id");
//                error.appendTo($("#" + name + "_validate1"));
//            },
            {{--messages: {--}}
                {{--@if(app()->getLocale() =='ar')--}}
                {{--"category[]": {--}}
                    {{--required : "الرجاء اختيار تصنيف"--}}
                {{--},--}}
                {{--@else--}}
                {{--"category[]": {--}}
                    {{--required: "Please select category"--}}
                {{--}--}}
                {{--@endif--}}
            {{--}--}}
        });

        $('#SPAccountCategoriesInfoForm').on('submit', function (e) {
            $('.selectSubCategory').each(function (i) {
                var selectID = $(this).find('select').attr('id')
                $('#'+selectID).rules( "add", {
                    required: true,
                    messages: {
                        @if(app()->getLocale() =='ar')
                        required : "الرجاء اختيار تصنيف",
                        @else
                        required: "Please select category"
                        @endif
                    }
                });
            })
            e.preventDefault();
//            $('#SPAccountCategoriesInfoForm').validate().form();
            if($('#SPAccountCategoriesInfoForm').valid()){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/' + finalCategoryID + '/insertCompanySubCategories',
                    data:{
                        "_token": "{{csrf_token()}}",
                        "companyID" : "{{$service_provider->pk_i_id}}"
                    },
                    success: function (data, textStatus, jqXHR) {
                        if(data.status){
                            var cc = data.companyCategory;
                            var labelTag = $('<label><a class="removeCategory" id="'+cc.pk_i_id+'"><span class="glyphicon glyphicon-remove-sign"></span></a>&nbsp;'+cc.s_name+'</label>');
                            var divTag = $('<div class="col-sm-3 subCategoryDiv"></div>');
                            divTag.append(labelTag);
                            $('.daynmicaSubCategories').append(divTag);
                            if(data.categoryAlreadyExist == 1){
                                $.each(data.tenders, function (i, item) {
                                    var title = item.userRole == 'ServiceProviderAdmin' ? "<a href=\"{{url('/')}}/ServiceProvider/"+item.id+"/bidding\">"+item.title+"</a>" : item.title;
                                    @if(app()->getLocale() == 'en')
//                                    $('.alreadyExistTender').text(data.englishMSG)
                                    $("#alreadyExistTender").append("<label>There is a tender titled ("+title+") containing this category ending on "+item.date+"</label>")
                                    @else
                                    $("#alreadyExistTender").append("<label>توجد مناقصة بعنوان ("+title+") تحتوي على نفس التصنيف تنتهي في تاريخ "+item.date+"</label>")
//                                        $('.alreadyExistTender').text(data.arabicMSG)
                                    @endif
                                });

                                $('#alreadyExistTender').show();
//                                $('.alert-dismissible').delay(3000).fadeOut('slow');
                            }
                        }
                        else{
                            $('#alreadyExistCategory').show();
                            $('.alert-dismissible').delay(3000).fadeOut('slow');
                        }
                    }
                })
            }

        })
    </script>
    <script>
        $('body').on('click', '.removeCategory', function() {
//    $('.removeCategory').on('click', function (e) {
//        e.preventDefault();
        var categoryID = $(this).attr('id');
        var closestDiv = $(this).closest('.subCategoryDiv');
        swal({
                title: "{{ trans('lang.sure') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "{{ trans('lang.yes_delete') }}",
                cancelButtonText: "{{ trans('lang.cancel') }}",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {

                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/' + categoryID + '/removeCompanySubCategories',
                    data:{
                        "_token": "{{csrf_token()}}",
                        "companyID" : "{{$service_provider->pk_i_id}}"
                    },
                    success: function (data, textStatus, jqXHR) {
                        if(data.status){
                            swal("{{trans('lang.success')}}", "{{trans('lang.deleted')}}", "success");
                            closestDiv.remove();
                        }
                    }
                })

            });

    })
    </script>
@endsection

