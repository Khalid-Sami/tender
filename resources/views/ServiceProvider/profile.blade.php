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
                                <span class="caption-subject font-blue-madison bold uppercase">@lang('lang.profile_account')</span>
                            </div>
                            <ul class="nav nav-tabs">
                                @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state') && !session('tab5_state'))
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">@lang('lang.service_provider_info')</a>
                                    </li>
                                @else
                                    <li class="{{session('tab1_state')?session('tab1_state'):''}}">
                                        <a href="#tab_1_1" data-toggle="tab">@lang('lang.service_provider_info')</a>
                                    </li>
                                @endif

                                <li class="{{session('tab2_state')?session('tab2_state'):''}}">
                                    <a href="#tab_1_2" data-toggle="tab">@lang('lang.cities')</a>
                                </li>
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
                                @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state') && !session('tab5_state'))
                                    <div class="tab-pane active" id="tab_1_1">
                                        @else
                                            <div class="tab-pane {{session('tab1_state')?session('tab1_state'):''}}"
                                                 id="tab_1_1">
                                                @endif


                                                {!! Form::model($service_provider,['id'=>'ServiceProviderInfoForm','method' => 'patch', 'action' =>['ServiceProviderController@updateSPInformation',$service_provider->pk_i_id],'files' => true]) !!}
                                                <div class="form-group">
                                                    {!! Form::label('s_name_ar',trans('lang.service_provider_ar'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_name_ar',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_name_ar'))
                                                        <strong class="font-red">{{ $errors->first('s_name_ar') }}</strong>
                                                    @endif
                                                    <div id="s_name_ar_validate" class="font-red"></div>
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_name_en',trans('lang.service_provider_en'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_name_en',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_name_en'))
                                                        <strong class="font-red">{{ $errors->first('s_name_en') }}</strong>
                                                    @endif
                                                    <div id="s_name_en_validate" class="font-red"></div>

                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_company_name',trans('lang.company'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_company_name',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_company_name'))
                                                        <strong class="font-red">{{ $errors->first('s_company_name') }}</strong>
                                                    @endif
                                                    <div id="s_company_name_validate" class="font-red"></div>

                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_trade_license_no',trans('lang.trade_licence_number'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_trade_license_no',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_trade_license_no'))
                                                        <strong class="font-red">{{ $errors->first('s_trade_license_no') }}</strong>
                                                    @endif
                                                    <div id="s_trade_license_no_validate" class="font-red"></div>

                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_telephone_number',trans('lang.telephone_number'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_telephone_number',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_telephone_number'))
                                                        <strong class="font-red">{{ $errors->first('s_telephone_number') }}</strong>
                                                    @endif
                                                    <div id="s_telephone_number_validate" class="font-red"></div>

                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_mobile_number',trans('lang.mobile_number'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_mobile_number',null,['class' => 'form-control']) !!}

                                                    @if($errors->has('s_mobile_number'))
                                                        <strong class="font-red">{{ $errors->first('s_mobile_number') }}</strong>
                                                    @endif
                                                    <div id="s_mobile_number_validate" class="font-red"></div>
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_address_ar',trans('lang.address_ar'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_address_ar',null,['class' => 'form-control']) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_address_en',trans('lang.address_en'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_address_en',null,['class' => 'form-control']) !!}
                                                </div>


                                                <div class="form-group">
                                                    {!! Form::label('service_provider_image',trans('lang.service_provider_image')) !!}
                                                    <br>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail"
                                                             style="width: 200px; height: 150px;">
                                                            <img src="{{ isset($service_provider->s_image)?asset('/images/service_provider_images/'.$service_provider->s_image):asset('/images/service_provider_images/avatar.JPG') }}"
                                                                 alt=""></div>
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

                                                    </div>

                                                </div>

                                                <div class="form-group" style="margin-top: 10px;">
                                                    {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}
                                                </div>

                                                {!! Form::close() !!}
                                            </div>
                                            <!-- END CLINIC INFO TAB -->

                                            <!-- CHANGE SERVICE PROVIDERS CITIES TAB -->
                                            <div class="tab-pane {{session('tab2_state')?session('tab2_state'):''}}"
                                                 id="tab_1_2">

                                                {!! Form::open(['method'=>'patch','action' =>['ServiceProviderController@updateSPCities',$service_provider->pk_i_id]]) !!}

                                                <div class="form-group">

                                                    <div class="row">
                                                        @foreach($cities as $city)
                                                            <div class="col-sm-4">
                                                                <input name="cities[]"
                                                                       {{ \App\helper\helpers::getCheckedCity($city->pk_i_id,$service_provider->pk_i_id) }} type="checkbox"
                                                                       value="{{$city->pk_i_id}}">

                                                                {!! Form::label('cities',$city->s_name) !!}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="margin-top-10">
                                                    {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}

                                                </div>
                                                {!! Form::close() !!}
                                            </div>
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

                                                <div class="margin-top-10">
                                                    {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}

                                                </div>
                                                {!! Form::close() !!}

                                            </div>
                                            <!-- END LOCATIONS TAB -->


                                            <!-- TIMES OF WORK  TAB -->
                                            <div class="tab-pane {{session('tab4_state')?session('tab4_state'):''}}"
                                                 id="tab_1_4">


                                                {!! Form::open(['method' => 'post', 'action' =>['ServiceProviderController@storeTimeOfWork',$service_provider->pk_i_id]]) !!}

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
                                                                           value="{{ !$working->isEmpty()?$working[0]->t_from:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input id="to" name="to1" type="text"
                                                                           class="form-control timepicker1"
                                                                           value="{{  !$working->isEmpty()?$working[0]->t_to:''}}">
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
                                                                           value="{{ !$working->isEmpty()?$working[1]->t_from:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>

                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to2" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="{{ !$working->isEmpty()?$working[1]->t_to:''}}">
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
                                                                           value="{{ !$working->isEmpty()?$working[2]->t_from:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to3" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="{{ !$working->isEmpty()?$working[2]->t_to:''}}">
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
                                                                           value="{{ !$working->isEmpty()?$working[3]->t_from:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to4" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="{{ !$working->isEmpty()?$working[3]->t_to:''}}">
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
                                                                           value="{{ !$working->isEmpty()?$working[4]->t_from:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to5" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="{{  !$working->isEmpty()?$working[4]->t_to:''}}">
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
                                                                           value="{{  !$working->isEmpty()?$working[5]->t_from:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to6" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="{{  !$working->isEmpty()?$working[5]->t_to:''}}">
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
                                                                           value="{{  !$working->isEmpty()?$working[6]->t_from:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <div class='input-group bootstrap-timepicker timepicker'>
                                                                    <input name="to7" type="text"
                                                                           class="form-control to timepicker1"
                                                                           value="{{ !$working->isEmpty()?$working[6]->t_to:''}}">
                                                                    <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-time"></span>
                                                                  </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <div class="margin-top-10">
                                                    {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}

                                                </div>
                                                {!! Form::close() !!}

                                            </div>
                                            <!-- END TIMES OF WORK TAB -->

                                            <!-- ADDITIONAL INFO  TAB -->
                                            <div class="tab-pane {{session('tab5_state')?session('tab5_state'):''}}"
                                                 id="tab_1_5">


                                                {!! Form::open(['method' => 'patch', 'action' =>['ServiceProviderController@updateSPAdditionalInfo',$service_provider->pk_i_id]]) !!}

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
                                                <div class="margin-top-10">
                                                    {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}

                                                </div>
                                                {!! Form::close() !!}

                                            </div>
                                            <!-- ADDITIONAL INFO  TAB -->

                                    </div>
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
            var uluru = {lat: 25.202310491859688, lng: 55.27056536102293};
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
        $('#ServiceProviderInfoForm').validate({
            rules: {
                s_name_ar: "required",
                s_name_en: "required",
                s_company_name: "required",
                s_trade_license_no: {
                    required: true,
                    digits: true
                },
                s_telephone_number: {
                    required: true,
                    digits: true
                },
                s_mobile_number: {
                    required: true,
                    digits: true
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
                s_company_name: "الشركة حقل مطلوب",
                s_trade_license_no: {
                    required: "عدد الرخص التجارية حقل مطلوب",
                    digits: "عدد الرخص التجارية يجب ان يحتوي على ارقام فقط"
                },
                s_telephone_number: {
                    required: "رقم التلفون حقل مطلوب",
                    digits: "رقم التلفون يجب ان يحتوي على ارقام فقط"
                },
                s_mobile_number: {
                    required: "رقم الجوال حقل مطلوب",
                    digits: "رقم الجوال يجب ان يحتوي على ارقام فقط"
                },
                @else
                s_name_ar: "service provider (Arabic) field is required",
                s_name_en: "service provider field is required",
                s_company_name: "company field is required",
                s_trade_license_no: {
                    required: "trade license number field is required",
                    digits: "trade license number must contains digits only"
                },
                s_telephone_number: {
                    required: "telephone number field is required",
                    digits: "telephone number field must contains digits only"
                },
                s_mobile_number: {
                    required: "mobile number field is required",
                    digits: "mobile number field must contains digits only"
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
@endsection

