@extends('_layout')

@section('head_title')
    {{trans('lang.notifications')}}
@endsection
@section('title')
    {!!  trans('lang.notifications') !!}
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

    {!! Form::open(['id' => 'sendMessageDataForm',"method"=> "POST", "action" => "AdminController@storeNotifications"]) !!}

    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label col-sm-3">@lang('lang.service_type')</label>
            <div class="col-sm-9">
                <div class="col-sm-12">
                    <label>
                        <input type="radio" value="email" name="radio[]" id="emailRadio" class="rad">
                        {{ trans('lang.emails') }}
                    </label>
                </div>
                <div class="col-sm-12">
                    <label>
                        <input type="radio" value="sms" name="radio[]" id="smsRadio" class="rad">
                        {{ trans('lang.sms') }}
                    </label>
                </div>
                <div class="col-sm-12">
                    <label>
                        <input type="radio" value="website" name="radio[]" id="websiteRadio" class="rad">
                        {{ trans('lang.inside_website') }}
                    </label>
                </div>
                <div class="col-sm-12">
                    <label>
                        <input type="radio" value="push" name="radio[]" id="pushRadio" class="rad">
                        {{ trans('lang.push') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group col-sm-6">
            <label class="control-label col-sm-3">@lang('lang.send_to')</label>
            <div class="col-sm-9">
                <div class="col-sm-12 ">
                    <label>
                        <input type="checkbox" value="clinicsManagers" name="check[]" id="clinicsManagersCheckbox" class="check">
                        {{ trans('lang.clinic_manager') }}
                    </label>
                </div>
                <div class="col-sm-12">
                    <label>
                        <input type="checkbox" value="doctors" name="check[]" id="doctorsCheckbox" class="check">
                        {{ trans('lang.doctors') }}
                    </label>
                </div>
                <div class="col-sm-12 ">
                    <label>
                        <input type="checkbox" value="secretary" name="check[]" id="secretaryCheckbox" class="check">
                        {{ trans('lang.secretary') }}
                    </label>
                </div>
                <div class="col-sm-12 ">
                    <label>
                        <input type="checkbox" value="patients" name="check[]" id="patientsCheckbox" class="check">
                        {{ trans('lang.patients') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <br><br>


    <br><br>
    <div id="clinicsManagersDiv" class="row hidden">
        <div class="form-group">
            <label class="control-label col-md-3">@lang('lang.clinics_manager')</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select0" name="my_multi_select[]">
                    @forelse($clinics_User as $cu)
                        @if($cu->userRule->s_name_en == 'ClinicAdmin')
                            <option value="{{$cu->pk_i_id}}">{{ $cu->s_first_name.' '.$cu->s_last_name }}</option>
                        @endif
                    @empty
                        <option value="">no user</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <hr class="col-sm-11 hidden clinicsManagersDiv">
    <div id="doctorsDiv" class="row hidden">
        <div class="form-group">
            <label class="control-label col-md-3">@lang('lang.doctors')</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select[]">
                    @forelse($clinics_User as $cu)
                        @if($cu->userRule->s_name_en == 'doctor')
                            <option value="{{$cu->pk_i_id}}">{{ $cu->s_first_name.' '.$cu->s_last_name }}</option>
                        @endif
                    @empty
                        <option value="">no user</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <hr class="col-sm-11 hidden doctorsDiv">
    <div id="secretaryDiv" class="row hidden">
        <div class="form-group">
            <label class="control-label col-md-3">@lang('lang.secretary')</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select2" name="my_multi_select[]">
                    @forelse($clinics_User as $cu)
                        @if($cu->userRule->s_name_en == 'secretary')
                            <option value="{{$cu->pk_i_id}}">{{ $cu->s_first_name.' '.$cu->s_last_name }}</option>
                        @endif
                    @empty
                        <option value="">no user</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <hr class="col-sm-11 hidden secretaryDiv">

    <div id="patientsDiv" class="row hidden">
        <div class="form-group">
            <label class="control-label col-md-3">@lang('lang.patients')</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select3" name="my_multi_select[]">
                    @forelse($clinics_User as $cu)
                        @if($cu->userRule->s_name_en == 'Patient')
                            <option value="{{$cu->pk_i_id}}">{{ $cu->s_first_name.' '.$cu->s_last_name }}</option>
                        @endif
                    @empty
                        <option value="">no user</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-12 margin-top-20">
        <label class="control-label col-sm-3">@lang('lang.message')</label>

        <div class="form-group col-sm-4">
            <label for="message">@lang('lang.arabic')</label>
            <textarea  style="width: 292px;" name="messageArabic" id="" cols="24" rows="10" class="form-control"></textarea>
        </div>

        <div class="form-group col-sm-4">
            <label for="message">@lang('lang.english')</label>

            <textarea  style="width: 292px;" name="messageEnglish" id="" cols="24" rows="10" class="form-control"></textarea>
        </div>
    </div>
    <br>
    <div class="row">
        <button type="button" id="sendMessages" class="btn btn-primary col-sm-offset-1">@lang('lang.send')</button>
    </div>
    {!! Form::close() !!}



@endsection
@section('scripts')
    <script>
        $('body').on('click', '#specific_clinic', function () {
            $('#specificClinicModal').modal('show');
        });
    </script>
    <script>
        $('body').on('click', '#all_clinics', function () {
            $('#allClinicsModal').modal('show');
        });
    </script>
    <script>
        $('#specificClinicForm').validate({
            rules: {
                clinic: "required",
                spec_message: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                clinic: " {{app()->getLocale()=='ar'?'العيادة حقل مطلوب':'clinic field is required'}}",
                spec_message: " {{ app()->getLocale()=='ar'?'الرسالة حقل مطلوب':'message field is required' }}"
            }, submitHandler: function (form) {
                form.submit();
            }
        });
        $('#allClinicsForm').validate({
            rules: {
                message: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                message: " {{ app()->getLocale()=='ar'?'الرسالة حقل مطلوب':'message field is required' }}"
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>


    <script>
        $('#my_multi_select0').multiSelect();
        $('#my_multi_select1').multiSelect();
        $('#my_multi_select2').multiSelect();
        $('#my_multi_select3').multiSelect();

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
        $('body').on('click', '#allSelected1', function () {
            if ($(this).is(':checked')) {
                $('#my_multi_select1').multiSelect('select_all');

            } else {
                $('#my_multi_select1').multiSelect('deselect_all');
            }
        });
        $('body').on('click', '#allSelected2', function () {
            if ($(this).is(':checked')) {
                $('#my_multi_select2').multiSelect('select_all');

            } else {
                $('#my_multi_select2').multiSelect('deselect_all');
            }
        });

        $('body').on('click', '#allSelected3', function () {
            if ($(this).is(':checked')) {
                $('#my_multi_select3').multiSelect('select_all');

            } else {
                $('#my_multi_select3').multiSelect('deselect_all');
            }
        });
    </script>

    <script>
        $('body').on('click', '.check', function () {
            $('.check').each(function (i) {
                var this1 = $(this);
                if (this1.is(':checked')) {
                    switch (this1.attr('id')) {
                        case 'clinicsManagersCheckbox':
                            $('#clinicsManagersDiv').removeClass('hidden');
                            $('.clinicsManagersDiv').removeClass('hidden');
                            break;
                        case 'doctorsCheckbox':
                            $('#doctorsDiv').removeClass('hidden');
                            $('.doctorsDiv').removeClass('hidden');
                            break;

                        case 'secretaryCheckbox':
                            $('#secretaryDiv').removeClass('hidden');
                            $('.secretaryDiv').removeClass('hidden');
                            break;
                        case 'patientsCheckbox':
                            $('#patientsDiv').removeClass('hidden');
                            $('.patientsDiv').removeClass('hidden');
                            break;
                    }
                } else {
                    switch (this1.attr('id')) {
                        case 'clinicsManagersCheckbox':
                            $('#clinicsManagersDiv').addClass('hidden');
                            $('.clinicsManagersDiv').addClass('hidden');
                            break;
                        case 'doctorsCheckbox':
                            $('#doctorsDiv').addClass('hidden');
                            $('.doctorsDiv').addClass('hidden');
                            break;

                        case 'secretaryCheckbox':
                            $('#secretaryDiv').addClass('hidden');
                            $('.secretaryDiv').addClass('hidden');
                            break;
                        case 'patientsCheckbox':
                            $('#patientsDiv').addClass('hidden');
                            $('.patientsDiv').addClass('hidden');
                            break;
                    }
                }
            });
        });
    </script>


    <script>
        $('body').on('click', '#sendMessages', function (e) {
            e.preventDefault();
            var flag1 = 1;
            var flag2 = 1;
            $('.rad').each(function () {
                var this1 = $(this);
                if (this1.is(':checked')) {
                    flag1 = 0;
                }
            });
            $('.check').each(function () {
                var this2 = $(this);
                if (this2.is(':checked')) {
                    flag2 = 0;
                }
            });

            if (!flag1 && !flag2) {
                $.ajax({
                    method: "POST",
                    url: "{{ action("AdminController@storeNotifications") }}",
                    dataType: "json",
                    data: $("#sendMessageDataForm").serialize(),
                    success: function (data, textStatus, jqXHR) {

                        if(data.status){
                            swal({
                                title: "{{ trans('lang.success_send_notification') }} ",
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                cancelButtonText: "{{ trans('lang.cancel') }}",
                                closeOnConfirm: false
                            });
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            } else {
                swal({
                    title: "{{ trans('lang.chooseOption') }} ",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false
                });
            }
        });

    </script>
@endsection