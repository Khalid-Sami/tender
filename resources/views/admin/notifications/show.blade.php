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
                {{--<div class="col-sm-12">--}}
                    {{--<label>--}}
                        {{--<input type="radio" value="push" name="radio[]" id="pushRadio" class="rad">--}}
                        {{--{{ trans('lang.push') }}--}}
                    {{--</label>--}}
                {{--</div>--}}
            </div>
        </div>

        <div class="form-group col-sm-6">
            <label class="control-label col-sm-3">@lang('lang.send_to')</label>
            <div class="col-sm-9">
                <!--<div class="col-sm-12 ">
                    <label>
                        <input type="checkbox" value="serviceProviders" name="check[]" id="serviceProvidersCheckbox" class="check">
{{--                        {{ trans('lang.provider') }}--}}
                    </label>
                </div>-->
                    <?php
                    $status;
                    if (app()->getLocale() == 'ar') {
                        $status = array('' => 'اختار من القائمة', '1' => 'مورد', '0' => 'حسب التصنيف');
                    } else {
                        $status = array('' => 'Choose Option', '1' => 'Service Provider', '0' => 'By Category');
                    }

                    ?>

                    <div class="form-group col-sm-12">
{{--                    {!! Form::label('category',trans('lang.byCategory')) !!}--}}
                    {!! Form::select('category',isset($status)?$status:[],null,['class'=>'form-control select','id' => 'category']) !!}
                </div>
                {{--<div class="col-sm-12">--}}
                    {{--<label>--}}
                        {{--<input type="checkbox" value="serviceProviderUsers" name="check[]" id="serviceProviderUsersCheckbox" class="check">--}}
                        {{--{{ trans('lang.byCategory') }}--}}
                    {{--</label>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    <br><br>


    <br><br>
    <div id="serviceProvidersDiv" class="row hidden">
        <div class="form-group">
            <label class="control-label col-md-3">@lang('lang.company_admin')</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select0" name="my_multi_select0[]">
                    @forelse($userCompany as $user)
                        @if($user->user->userRule->s_name_en == 'ServiceProviderAdmin')
                            <option value="{{$user->user->pk_i_id}}">{{ $user->user->s_first_name.' '.$user->user->s_last_name }}</option>
                        @endif
                    @empty
                        <p  disabled>no user</p>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <hr class="col-sm-11 hidden serviceProvidersDiv">
    <div id="serviceProviderUsersDiv" class="row hidden">
        <div class="form-group">
            <label class="control-label col-md-3">@lang('lang.category')</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]">
                    @forelse($categories as $category)
                            <option value="{{$category->pk_i_id}}">{{ $category->s_name }}</option>
                    @empty
                        <p >no category</p>
                    @endforelse
                </select>
            </div>
        </div>
    </div>



    <div class="col-sm-12 margin-top-20">
        <label class="control-label col-sm-3">@lang('lang.message')</label>

        <div class="form-group col-sm-4">
            <label for="message">@lang('lang.arabic')</label>
            <textarea  style="width: 292px;" name="messageArabic" id="msgAr" cols="24" rows="10" class="form-control"></textarea>
            <div id="messageArabic_validate1" class="font-red"></div>
        </div>

        <div class="form-group col-sm-4">
            <label for="message">@lang('lang.english')</label>

            <textarea  style="width: 292px;" name="messageEnglish" id="msgEn" cols="24" rows="10" class="form-control"></textarea>
            <div id="messageEnglish_validate1" class="font-red"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <button type="button" id="sendMessages" class="btn btn-primary col-sm-offset-1">@lang('lang.send')</button>
    </div>
    {!! Form::close() !!}



@endsection
@section('scripts')
    {{--<script>--}}
        {{--$('body').on('click', '#specific_clinic', function () {--}}
            {{--$('#specificClinicModal').modal('show');--}}
        {{--});--}}
    {{--</script>--}}
    {{--<script>--}}
        {{--$('body').on('click', '#all_clinics', function () {--}}
            {{--$('#allClinicsModal').modal('show');--}}
        {{--});--}}
    {{--</script>--}}
    {{--<script>--}}
        {{--$('#specificClinicForm').validate({--}}
            {{--rules: {--}}
                {{--clinic: "required",--}}
                {{--spec_message: "required"--}}
            {{--},--}}
            {{--errorPlacement: function (error, element) {--}}
                {{--var name = $(element).attr("name");--}}
                {{--error.appendTo($("#" + name + "_validate"));--}}
            {{--},--}}
            {{--messages: {--}}
                {{--clinic: " {{app()->getLocale()=='ar'?'العيادة حقل مطلوب':'clinic field is required'}}",--}}
                {{--spec_message: " {{ app()->getLocale()=='ar'?'الرسالة حقل مطلوب':'message field is required' }}"--}}
            {{--}, submitHandler: function (form) {--}}
                {{--form.submit();--}}
            {{--}--}}
        {{--});--}}
        {{--$('#allClinicsForm').validate({--}}
            {{--rules: {--}}
                {{--message: "required"--}}
            {{--},--}}
            {{--errorPlacement: function (error, element) {--}}
                {{--var name = $(element).attr("name");--}}
                {{--error.appendTo($("#" + name + "_validate"));--}}
            {{--},--}}
            {{--messages: {--}}
                {{--message: " {{ app()->getLocale()=='ar'?'الرسالة حقل مطلوب':'message field is required' }}"--}}
            {{--}, submitHandler: function (form) {--}}
                {{--form.submit();--}}
            {{--}--}}
        {{--});--}}
    {{--</script>--}}


    <script>
        $('#my_multi_select0').multiSelect();
        $('#my_multi_select1').multiSelect();
//        $('#my_multi_select2').multiSelect();
//        $('#my_multi_select3').multiSelect();

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
    </script>

    <script>
//        $('body').on('click', '.check', function () {
//            $('.check').each(function (i) {
//                var this1 = $(this);
//                if (this1.is(':checked')) {
//                    switch (this1.attr('id')) {
//                        case 'serviceProvidersCheckbox':
//                            $('#serviceProvidersDiv').removeClass('hidden');
//                            $('.serviceProvidersDiv').removeClass('hidden');
//                            break;
//                        case 'serviceProviderUsersCheckbox':
//                            $('#serviceProviderUsersDiv').removeClass('hidden');
//                            $('.serviceProviderUsersDiv').removeClass('hidden');
//                            break;
//
//                    }
//                } else {
//                    switch (this1.attr('id')) {
//                        case 'serviceProvidersCheckbox':
//                            $('#serviceProvidersDiv').addClass('hidden');
//                            $('.serviceProvidersDiv').addClass('hidden');
//                            break;
//                        case 'serviceProviderUsersCheckbox':
//                            $('#serviceProviderUsersDiv').addClass('hidden');
//                            $('.serviceProviderUsersDiv').addClass('hidden');
//                            break;
//                    }
//                }
//            });
//        });
    </script>

    <script>
        $('body').on('change', '#category', function () {
            var value = $(this).val();
                    switch (value) {
                        case '1':
                            $('#serviceProviderUsersDiv').addClass('hidden');
                            $('.serviceProviderUsersDiv').addClass('hidden');
                            $('#serviceProvidersDiv').removeClass('hidden');
                            $('.serviceProvidersDiv').removeClass('hidden');
                            break;
                        case '0':
                            $('#serviceProvidersDiv').addClass('hidden');
                            $('.serviceProvidersDiv').addClass('hidden');
                            $('#serviceProviderUsersDiv').removeClass('hidden');
                            $('.serviceProviderUsersDiv').removeClass('hidden');
                            break;
                        case '':
                            $('#serviceProvidersDiv').addClass('hidden');
                            $('.serviceProvidersDiv').addClass('hidden');
                            $('#serviceProviderUsersDiv').addClass('hidden');
                            $('.serviceProviderUsersDiv').addClass('hidden');
                            break;
                    }
        });
    </script>

    <script>
        $('#sendMessageDataForm').validate({
            rules: {
                messageArabic: "required",
                messageEnglish: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate1"));
            },
            messages: {
                @if(app()->getLocale() =='ar')
                messageArabic: "الرسالة بالعربية حقل مطلوب",
                messageEnglish: "الرسالة بالانجليزية (English)",
                @else
                messageArabic: "Message (Arabic) field is required",
                messageEnglish: "Message (English) field is required",
                @endif
            }
        });
    </script>

    <script>
        $('body').on('click', '#sendMessages', function (e) {
            e.preventDefault();
            var flag1 = 1;
            var flag2 = 1;
            var flag3 = 1;
            var flag4 = 1;
            $('.rad').each(function () {
//                var this1 = $(this);
                if ($(this).is(':checked')) {
                    flag1 = 0;
                }
            });
//            $('.check').each(function () {
//                var this2 = $(this);
//                if (this2.is(':checked')) {
//                    flag2 = 0;
//                }
//            });
            if($('#category').val()){
                flag2 = 0;
            }

            if($('#msgAr').val()){
                flag3 = 0;
            }
            if($('#msgEn').val()){
                flag4 = 0;
            }
//            if($("select[multiple]").length){
//                alert("worked");
//            }
//            $('select[name="my_multi_select0[]"]').each(function()
//            {
//                console.log($(this).val())
//            });

//            alert($('select[name="my_multi_select0[]"]').val())

            var flag5 =1;
            if(!$('select[name="my_multi_select0[]"').is(':hidden')){
                if($('select[name="my_multi_select0[]"').val() != null){
                    flag5 = 0;
                }
            }
            else if(!$('select[name="my_multi_select1[]"').is(':hidden')){
                if($('select[name="my_multi_select1[]"').val() != null){
                    flag5 = 0;
                }
            }

            if (!flag1 && !flag2 && !flag5) {
                $('#sendMessageDataForm').validate();
                if($('#sendMessageDataForm').valid()){
                    $.ajax({
                        method: "POST",
                        url: "{{ action("AdminController@storeNotifications") }}",
                        dataType: "json",
                        data: $("#sendMessageDataForm").serialize(),
                        success: function (data, textStatus, jqXHR) {

                            if(data.status){
                                $('#msgAr').val('');
                                $('#msgEn').val('');
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
                }

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