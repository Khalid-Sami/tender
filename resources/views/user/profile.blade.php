@extends('_layout')
@section('styles')
    <style>
        #map {
            width: 100%;
            height: 400px;
            overflow: visible;
        }
    </style>
@endsection

@section('title')
    <span>{{trans('lang.user_profile')}}</span>
@endsection
@section('head_title')
    {{trans('lang.user_profile')}}
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
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic" id="imageHtml">
                    <img src="{{ isset($user->s_pic)?url('/')."/images/users_images/".$user->s_pic:asset('/images/users_images/avatar.png') }}"
                         class="img-responsive" alt=""></div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ $user->s_first_name }}</div>
                </div>
                <!-- END SIDEBAR USER TITLE -->

            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">@lang('lang.profile_account')</span>
                            </div>
                            <ul class="nav nav-tabs">
                                @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state'))
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">@lang('lang.personal_info')</a>
                                    </li>
                                @else
                                    <li class="{{session('tab1_state')?session('tab1_state'):''}}">
                                        <a href="#tab_1_1" data-toggle="tab">@lang('lang.personal_info')</a>
                                    </li>
                                @endif

                                <li class="{{session('tab2_state')?session('tab2_state'):''}}">
                                    <a href="#tab_1_2" data-toggle="tab">@lang('lang.change_img')</a>
                                </li>
                                <li class="{{session('social')?'hidden':''}} {{session('tab3_state')?session('tab3_state'):''}}">
                                    <a href="#tab_1_3" data-toggle="tab">@lang('lang.change_pass')</a>
                                </li>
                                <li id="mapTab" class=" {{session('tab4_state')?session('tab4_state'):''}}">
                                    <a href="#tab_1_4" data-toggle="tab">@lang('lang.user_location')</a>
                                </li>

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


                                                {!! Form::model($user,['id'=>'userInfoForm','method' => 'patch', 'action' => ['ProfileController@updatePersonalInfo',$user->pk_i_id]]) !!}

                                                <div class="form-group">
                                                    {!! Form::label('s_first_name',trans('lang.first_name'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_first_name',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_first_name'))
                                                        <strong class="font-red">{{ $errors->first('s_first_name') }}</strong>
                                                    @endif
                                                    <strong id="s_first_name_validate" class="font-red"></strong>
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('s_last_name',trans('lang.last_name'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_last_name',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_last_name'))
                                                        <strong class="font-red">{{ $errors->first('s_last_name') }}</strong>
                                                    @endif
                                                    <strong id="s_last_name_validate" class="font-red"></strong>
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('dt_birth_date',trans('lang.birth_date'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('dt_birth_date',null,['class' => 'form-control date-picker']) !!}
                                                    @if($errors->has('dt_birth_date'))
                                                        <strong class="font-red">{{ $errors->first('dt_birth_date') }}</strong>
                                                    @endif
                                                    <strong id="dt_birth_date_validate" class="font-red"></strong>

                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('fk_i_gender_id',trans('lang.gender'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::select('fk_i_gender_id',isset($gender)?$gender:[],null,['class' => 'form-control select']) !!}
                                                    <strong id="fk_i_gender_id_validate" class="font-red"></strong>
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('s_mobile_number',trans('lang.mobile_number'),['class'=>'control-label']) !!}
                                                    <span class="required font-red">*</span>
                                                    {!! Form::text('s_mobile_number',null,['class' => 'form-control']) !!}
                                                    @if($errors->has('s_mobile_number'))
                                                        <strong class="font-red">{{ $errors->first('s_mobile_number') }}</strong>
                                                    @endif
                                                    <strong id="s_mobile_number_validate" class="font-red"></strong>
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('i_country_id',trans('lang.country'),['class'=>'control-label']) !!}
                                                    {!! Form::select('i_country_id',isset($country)?$country->prepend(trans('lang.choose_option'),''):[],null,['class' => 'form-control select','id'=>'country']) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('city',trans('lang.city'),['class'=>'control-label']) !!}
                                                    {!! Form::select('city',[],null,['class' => 'form-control select','id'=>'city']) !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('district',trans('lang.district'),['class'=>'control-label']) !!}
                                                    {!! Form::select('district',[],null,['class' => 'form-control select','id'=>'district']) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('s_address',trans('lang.address'),['class'=>'control-label']) !!}
                                                    {!! Form::text('s_address',null,['class' => 'form-control']) !!}
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

                                                {!! Form::open(['id'=>'changeImageForm','method'=>'patch','action' =>['ProfileController@changePicture',$user->pk_i_id],'files'=>true]) !!}
                                                <div class="form-group">
                                                    <span class="required" aria-required="true"> * </span>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail"
                                                             style="width: 200px; height: 150px;" id="tabImageHtml">
                                                            <img src="{{isset($user->s_pic)?asset("/images/users_images/".$user->s_pic):asset('/images/users_images/avatar.png')}}"
                                                                 alt=""></div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                                             style="max-width: 200px; max-height: 150px;"></div>
                                                        <div>
                                                                            <span class="btn default btn-file">
                                                                                <span class="fileinput-new">{{ trans('lang.select_image') }}</span>
                                                                                <span class="fileinput-exists"> {{ trans('lang.change_img') }} </span>
                                                                                <input type="file" name="file">  </span>
                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> {{trans('lang.remove')}} </a>

                                                            @if(isset($user->s_pic) && !empty($user->s_pic))
                                                                <a class="btn btn-danger" id="delete_image" data-id="{{$user->pk_i_id}}">{{ trans('lang.delete_img') }}</a>
                                                            @endif
                                                        </div>
                                                        @if($errors->has('file'))
                                                            <strong class="font-red">{{ $errors->first('file') }}</strong>
                                                        @endif
                                                        <strong id="file_validate" class="font-red"></strong>

                                                    </div>

                                                </div>
                                                <div class="margin-top-10">
                                                    {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}

                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                            <!-- END CHANGE AVATAR TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane {{session('social')?'hidden':''}} {{session('tab3_state')?session('tab3_state'):''}}"
                                                 id="tab_1_3">

                                                {!! Form::open(['id'=>'changePasswordForm','method' => 'patch', 'action' =>['ProfileController@changePassword',$user->pk_i_id]]) !!}

                                                <div class="form-group">
                                                    {!! Form::label('password',trans('lang.current_password'),['class'=>'control-label']) !!}
                                                    <span class="required" aria-required="true"> * </span>
                                                    {!! Form::input('password','password',old('password'),['class' => 'form-control']) !!}
                                                    @if($errors->has('password'))
                                                        <strong class="font-red">{{ $errors->first('password') }}</strong>
                                                    @endif
                                                    <strong id="password_validate" class="font-red"></strong>
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label('new_password',trans('lang.new_password'),['class'=>'control-label']) !!}
                                                    <span class="required" aria-required="true"> * </span>
                                                    {!! Form::input('password','new_password',old('new_password'),['class' => 'form-control']) !!}
                                                    @if($errors->has('new_password'))
                                                        <strong class="font-red">{{ $errors->first('new_password') }}</strong>
                                                    @endif
                                                    <strong id="new_password_validate" class="font-red"></strong>
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('confirm',trans('lang.confirm_password'),['class'=>'control-label']) !!}
                                                    <span class="required" aria-required="true"> * </span>
                                                    {!! Form::input('password','confirm',old('confirm'),['class' => 'form-control']) !!}
                                                    @if($errors->has('confirm'))
                                                        <strong class="font-red">{{ $errors->first('confirm') }}</strong>
                                                    @endif
                                                    <strong id="confirm_validate" class="font-red"></strong>
                                                </div>

                                                <div class="margin-top-10">
                                                    {!! Form::submit(trans('lang.change_pass'),['class' => 'btn green']) !!}
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->

                                            <!-- LOCATIONS  TAB -->
                                            <div class="tab-pane {{session('tab4_state')?session('tab4_state'):''}}"
                                                 id="tab_1_4">


                                                {!! Form::open(['id'=>'userLocationForm','method' => 'post', 'action' =>['ProfileController@addUserLocation',$user->pk_i_id]]) !!}

                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        {!! Form::label('latitude',trans('lang.latitude')) !!} <span
                                                                class="required font-red"
                                                                aria-required="true"> * </span>
                                                        {!! Form::text('lat',isset($user->d_latitude)?$user->d_latitude:null,['class'=>'form-control','id'=>'latbox','readonly']) !!}
                                                        @if($errors->has('lat'))
                                                            <strong class="font-red">{{ $errors->first('lat') }}</strong>
                                                        @endif
                                                        <strong id="lat_validate" class="font-red"></strong>

                                                    </div>
                                                    <div class="col-sm-5">
                                                        {!! Form::label('longitude',trans('lang.longitude')) !!} <span
                                                                class="required font-red"
                                                                aria-required="true"> * </span>
                                                        {!! Form::text('lng',isset($user->d_longitude)?$user->d_longitude:null,['class'=>'form-control','id'=>'lngbox','readonly']) !!}
                                                        @if($errors->has('lng'))
                                                            <strong class="font-red">{{ $errors->first('lng') }}</strong>
                                                        @endif
                                                        <strong id="lng_validate" class="font-red"></strong>
                                                    </div>
                                                </div>
                                                <div id="map"></div>

                                                <div class="margin-top-10">
                                                    {!! Form::submit(trans('lang.save'),['class' => 'btn green']) !!}

                                                </div>
                                                {!! Form::close() !!}

                                            </div>
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


@endsection
@section('scripts')
    <script>
        $('#userInfoForm').validate({
            rules: {
                s_first_name: "required",
                s_last_name: "required",
                dt_birth_date: "required",
                fk_i_gender_id: "required",
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
                s_first_name: "الاسم الاول حقل مطلوب",
                s_last_name: " اسم العائلة حقل مطلوب",
                dt_birth_date: " تاريخ الميلاد حقل مطلوب",
                fk_i_gender_id: " الجنس حقل مطلوب",
                s_mobile_number: {
                    required: " رقم الجوال حقل مطلوب",
                    digits: " رقم الجوال يجب ان يحتوي على ارقام فقط"
                },
                @else
                s_first_name: "first name is required field",
                s_last_name: "last name is required field",
                dt_birth_date: "birth date is required field",
                fk_i_gender_id: "gender is required field",
                s_mobile_number: {
                    required: "mobile number is required field",
                    digits: "mobile number must contains numbers only"
                }
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
    <script>
        $('#changeImageForm').validate({
            rules: {
                file: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                file: "الصورة حقل مطلوب",
                @else
                file: "image is required field",
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
    <script>
        $('#changePasswordForm').validate({
            rules: {
                password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength:6
                },
                confirm: {
                    required: true,
                    equalTo: "#new_password"
                }
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                password: {
                    required: "كلمة المرور الحالية حقل مطلوب"
                },
                new_password: {
                    required: "كلمة المرور الجديدة حقل مطلوب",
                    minlength: "كلمة المرور الجديدة يجب ان تحتوي 6 احرف على الاقل"
                },
                confirm: {
                    required: "تأكيد كلمة المرور الجديدة حقل مطلوب",
                    equalTo: 'يجب ان يكون نفس كلمة المرور الجديدة'

                },
                @else
                password: {
                    required: "password is required field"

                },
                new_password: {
                    required: "new password is required field",
                    minlength: "new password field must at least contains 6 characters"
                },
                confirm: {
                    required: "confirm password is required field",
                    equalTo: 'confirm password field must equal new password field'

                }
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
    <script>
        $('#userLocationForm').validate({
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
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd'
        });
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
        $("#mapTab").on("shown.bs.tab", function (e) {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });

    </script>

    <script>
        $(function () {
            var id = $('#country').val();
            if (id.length != 0) {
                $.ajax({
                    method: "POST",
                    url: "{{ action('ProfileController@updatePersonalInfo',$user->pk_i_id) }}",
                    dataType: "json",
                    data: {
                        'u_id': "{{$user->pk_i_id}}",
                        'id': id,
                        '_token': "{{ csrf_token() }}",
                        '_method': 'patch',
                        'method': 'getCity'
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('#city').html(data.view);
                        var id1 = $('#city').val();
                        $.ajax({
                            method: "POST",
                            url: "{{ action('ProfileController@updatePersonalInfo',$user->pk_i_id) }}",
                            dataType: "json",
                            data: {
                                'u_id': "{{$user->pk_i_id}}",
                                'id': id1,
                                '_token': "{{ csrf_token() }}",
                                '_method': 'patch',
                                'method': 'getDistrict'
                            },
                            success: function (data, textStatus, jqXHR) {
                                $('#district').html(data.view);

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
        });
        $('body').on('change', '#country', function () {
            var id = $(this).val();
            $.ajax({
                method: "POST",
                url: "{{ action('ProfileController@updatePersonalInfo',$user->pk_i_id) }}",
                dataType: "json",
                data: {
                    'u_id': "{{$user->pk_i_id}}",
                    'id': id,
                    '_token': "{{ csrf_token() }}",
                    '_method': 'patch',
                    'method': 'getCity'
                },
                success: function (data, textStatus, jqXHR) {
                    $('#city').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        });
        $('body').on('change', '#city', function () {
            var id = $(this).val();
            $.ajax({
                method: "POST",
                url: "{{ action('ProfileController@updatePersonalInfo',$user->pk_i_id) }}",
                dataType: "json",
                data: {
                    'u_id': "{{$user->pk_i_id}}",
                    'id': id,
                    '_token': "{{ csrf_token() }}",
                    '_method': 'patch',
                    'method': 'getDistrict'
                },
                success: function (data, textStatus, jqXHR) {
                    $('#district').html(data.view);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        });
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxmPnKKteOdi-Gj7prFgssVaHYqGL3YNw&callback=initMap">
    </script>



    <script>
        $('body').on('click', '#delete_image', function () {
            var id = $(this).data('id');
            $.ajax({
                method: "POST",
                url: "{{url('/')}}/user/accountSetting/"+id+"/change",
                dataType: "json",
                data: {'id': id, '_token': "{{ csrf_token() }}", '_method': 'patch'},
                success: function (data, textStatus, jqXHR) {
                    $('#imageHtml').html('<img src="{{asset('/images/users_images/avatar.png') }}" class="img-responsive" alt="">');
                    $('#tabImageHtml').html('<img src="{{asset('/images/users_images/avatar.png') }}" class="img-responsive" alt="">');
                    $('#delete_image').remove();
                    swal("{{trans('lang.deleted_success')}}!", "{{ trans('lang.deleted') }}", "success");


                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        });

    </script>
@endsection