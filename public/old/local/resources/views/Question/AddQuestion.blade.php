@extends('_layout')

@section('style')
    <style>

        .error {
            color: #FF0000; /* red */
        }

        .valid {
            color: #32c5d2; /* sky blue */
        }

        .select2-dropdown--below {
            z-index: 100000 !important;
        }

        input.select2-search__field {
            width: 50px !important;
        }

        ul.select2-selection__rendered {
            /*padding-right: 8px!important;*/
        }

        li.select2-search--inline {
            float: right !important;
        }

        .showSweetAlert {
            border-radius: 5px !important;
        }

        .sa-warning {
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50% !important

        }

        .sa-placeholder {
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50% !important
        }

        .sa-fix {
            border-radius: 50% !important
        }

        .animate {
            border-radius: 50% !important
        }

    </style>
@endsection
@section('head_title')
    {{trans('lang.addQuestion')}}
@endsection
@section('title')
    {!!  trans('lang.addQuestion') !!}
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

    <div class="row">
        <div class="portlet light bordered">
            <div id="alert" class="alert alert-success " role="alert" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Info!</strong>
                <div id="alertContent"> Indicates a neutral informative change or action.</div>
            </div>

            <div class="row">

                @if (count($errors) > 0)
                    <div class="alert alert-danger col-lg-12">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{!!  $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-lg-12">
                    <div class="col-lg-10"
                         style="font-size:17px; padding-right:30px !important; padding-bottom: 10px !important;">
                        الخدمة /
                        @if(app()->getLocale() == 'ar')
                            {!!$service->s_service_name_ar!!}
                        @else
                            {{$service->s_service_name_en}}
                        @endif

                    </div>
                    {{--<div class="col-lg-2">--}}
                    {{--<button id="addNewQuestionButton" type="button" class="btn green"><i--}}
                    {{--class="glyphicon glyphicon-plus"> </i>--}}
                    {{--سؤال جديد--}}
                    {{--@lang('lang.newService')--}}
                    {{--</button>--}}
                    {{--</div>--}}
                </div>


                <div class="col-lg-12 ">
                    <form id="addQuestionFormPage" action="{{route('ajax/saveQuestion')}}"
                          method="POST">
                        <div class="col-lg-12 questionPanel">
                            <div class="form-body">

                                <input name="serviceId" value="{{app('request')->input('id')}}"
                                       type="hidden"/>
                                <input name="_token" value="{{csrf_token()}}" type="hidden"/>
                                <div class="col-lg-6 form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.question_ar')</label>
                                    <input id="question_ar" name="question_ar"
                                           class="form-control" type="text"
                                           placeholder="@lang('lang.question_ar')"/>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.question_en')</label>
                                    <input name="question_en"
                                           class="form-control" type="text"
                                           placeholder="@lang('lang.question_en')"/>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px">@lang('lang.questionType')</label>
                                    <select id="questionType" name="questionType"
                                            class="form-control">
                                        <option value="0">@lang('lang.unknown')</option>
                                        <option value="1">@lang('lang.general')</option>
                                        <option value="2">@lang('lang.filter')</option>
                                        <option value="3">@lang('lang.information')</option>
                                    </select>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px">@lang('lang.answerType')</label>
                                    <select id="answerType" name="answerType"
                                            class="form-control">
                                        <option value="1">@lang('lang.checkBox')</option>
                                        <option value="2">@lang('lang.radio')</option>
                                        <option value="3">@lang('lang.list')</option>
                                        <option value="4">@lang('lang.text')</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-control"
                                           style="font-size: 16px">@lang('lang.questionStatus')</label>
                                    <select id="questionStatus" name="questionStatus"
                                            class="form-control">
                                        <option value="1">@lang('lang.active')</option>
                                        <option value="0">@lang('lang.inActive')</option>

                                    </select>


                                </div>
                                <div class="col-lg-6 vcenter"
                                     style="text-align: left;vertical-align: bottom !important;">


                                    <div class="" style="margin-top: 27px !important;">
                                        <a id="addNewOptions"
                                           class="btn btn-primary addNewOptions">@lang('lang.newOption')
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12 optionPanel ">
                            <div class="portlet blue box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cogs"></i>@lang('lang.newOption')
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class=" collapse"> </a>
                                        {{--<a href="#portlet-config" data-toggle="modal"--}}
                                        {{--class="config"> </a>--}}
                                        {{--<a href="javascript:;" class="fa fa-plus addNewOptions"--}}

                                        {{--style="color:#fff"> </a>--}}
                                        <a href="javascript:;" class="reload"> </a>
                                        {{--<a href="javascript:;" class="remove"> </a>--}}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="" class="">
                                        <div class="row">
                                            <div class="form-body">

                                                <input type="hidden" name="_token"
                                                       value="{{csrf_token()}}"/>
                                                <div class="col-lg-6 form-group">
                                                    <label class="label-control"
                                                           style="font-size: 16px !important;">@lang('lang.option_ar')</label>
                                                    <input id="option_ar" name="option_ar[]"
                                                           class="form-control option_ar"
                                                           type="text"
                                                           placeholder="@lang('lang.option_ar')"/>
                                                </div>
                                                <div class="col-lg-6  form-group">
                                                    <label class="label-control"
                                                           style="font-size: 16px !important;">@lang('lang.option_en')</label>
                                                    <input name="option_en[]"
                                                           class="form-control"
                                                           type="text"
                                                           placeholder="@lang('lang.option_en')"/>
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="label-control"
                                                           style="font-size: 16px !important;">@lang('lang.optionDescription_ar')</label>
                            <textarea name="answerDescription_ar[]" class="form-control"
                                      rows="3"
                                      placeholder="@lang('lang.optionDescription_ar')"></textarea>
                                                </div>
                                                <div class="col-lg-6  form-group">
                                                    <label class="label-control"
                                                           style="font-size: 16px !important;">@lang('lang.optionDescription_en')</label>
                            <textarea name="answerDescription_en[]" class="form-control"
                                      rows="3"
                                      placeholder="@lang('lang.optionDescription_en')"></textarea>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label class="label-control"
                                                           style="font-size: 16px">@lang('lang.optionStatus')</label>
                                                    <select id="editedAnswerType"
                                                            name="answerStatus[]"
                                                            class="form-control">
                                                        <option value="1">@lang('lang.active')</option>
                                                        <option value="0">@lang('lang.inActive')</option>
                                                    </select>

                                                </div>


                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 buttons">
                            <button id="submitQuestionForm" type="button"
                                    class="btn btn-primary"> @lang('lang.add')</button>
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">@lang('lang.cancel')</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>


    </div>


    <div id="clone" class="col-lg-12 optionPanel hide">
        <div class="portlet blue box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>@lang('lang.newOption')
                </div>
                <div class="tools">
                    <a href="javascript:;" class=" collapse"> </a>

                    <a href="javascript:;" class="reload"> </a>
                    <a href="javascript:;" class="remove"> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div id="" class="">
                    <div class="row">
                        <div class="form-body">

                            <input type="hidden" name="_token"
                                   value="{{csrf_token()}}"/>
                            <div class="col-lg-6 form-group">
                                <label class="label-control"
                                       style="font-size: 16px !important;">@lang('lang.option_ar')</label>
                                <input id="option_ar" name="option_ar[]"
                                       class="form-control option_ar"
                                       type="text"
                                       placeholder="@lang('lang.option_ar')"/>
                            </div>
                            <div class="col-lg-6  form-group">
                                <label class="label-control"
                                       style="font-size: 16px !important;">@lang('lang.option_en')</label>
                                <input name="option_en[]"
                                       class="form-control"
                                       type="text"
                                       placeholder="@lang('lang.option_en')"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="label-control"
                                       style="font-size: 16px !important;">@lang('lang.optionDescription_ar')</label>
                            <textarea name="answerDescription_ar[]" class="form-control"
                                      rows="3"
                                      placeholder="@lang('lang.optionDescription_ar')"></textarea>
                            </div>
                            <div class="col-lg-6  form-group">
                                <label class="label-control"
                                       style="font-size: 16px !important;">@lang('lang.optionDescription_en')</label>
                            <textarea name="answerDescription_en[]" class="form-control"
                                      rows="3"
                                      placeholder="@lang('lang.optionDescription_en')"></textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="label-control"
                                       style="font-size: 16px">@lang('lang.optionStatus')</label>
                                <select id="editedAnswerType"
                                        name="answerStatus[]"
                                        class="form-control">
                                    <option value="1">@lang('lang.active')</option>
                                    <option value="0">@lang('lang.inActive')</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection

@section('scripts')

    <script>
        var answerPanelId = -1;
        var reqiuredFields = "يجب تعبئة هذا الحقل ";
        $(document).ready(function () {
            addOptionPanel(); // generate new option
            collapseAction(); // hide form's details
            handelAnswerOptions(); // handel text and multi-options of answer
            handelReloadAction(); //reload the chosen option
            formValidation(); // add rules for form
        });

        function validateOptions() {
            var children = $("#addQuestionFormPage").find('.form-control');
            children.each(function () {

                $(this).rules('add', {
                    required: true,

                    messages: {
                        required: reqiuredFields

                    }
                });
                $(this).valid();
            });

        }
        function addOptionPanel(panel, answerPanelId) {
            $('body').on('click', '.addNewOptions', function () {
                var parent = $(this).parents('.questionPanel').siblings('.optionPanel').last();
                cloningNewAnswerPanel(parent); //create new Answer Panel
            });
        }

        function collapseAction() {
            $('body').on('click', '.collapseHid', function (event) {
                event.preventDefault();
                $(this).collapse('hide');
            });
        }
        function cloningNewAnswerPanel(parent) {
            var newAnswerPanel = $('#clone').clone();
            newAnswerPanel.removeAttr('id');
            newAnswerPanel.removeClass('hide');
            var form = newAnswerPanel.find('.form-control');
            answerPanelId = answerPanelId + 1;
            form.each(function (key, value) {
                $(this).attr('id', $(this).attr('name').split('[]')[0] + "" + answerPanelId);
            });
            parent.after(newAnswerPanel);
            newAnswerPanel.ready(function () {
                determiningRemovePanelAction();

            })

        }
        function determiningRemovePanelAction() {
            $('.remove').click(function () {
                $(this).parents('div.optionPanel').remove();
            });

        }

        function handelAnswerOptions() {
            $('body').on('change', 'select#answerType', function () {
                if ($(this).val() == 4) {
                    //  alert('dddd');
                    $('div.optionPanel').each(function (key, value) {
                        $(this).hide();
                    })
                } else {
                    $('div.optionPanel').show();
                }
            })
        }

        function handelReloadAction() {
            $('body').on('click', '.reload', function () {
                var parent = $(this).parents('.optionPanel');
                parent.find('input.form-control').val(null);
                parent.find('textarea.form-control').val(null);
            })
        }

        function formValidation() {
            $("#addQuestionFormPage").validate({
                rules: {
                    question_ar: {
                        required: true
                    },
                    question_en: {
                        required: true
                    },
                    questionType: {
                        required: true
                    },
                    answerType: {
                        required: true
                    },
                    questionStatus: {
                        required: true

                    },
                    '.form-control': {
                        required: true
                    }
                },
                messages: {
                    question_ar: {
                        required: "يجب ادخال نص السؤال"

                    },
                    question_en: {
                        required: "يجب ادخال نص السؤال (انجليزي)"

                    },
                    questionType: {
                        required: "يجب ادخال نوع السؤال"
                    },
                    answerType: {
                        required: "يجب ادخال نوع الاجابة"
                    },
                    questionStatus: {
                        required: "يجب ادخال حالة السؤال"
                    }

                },
                submitHandler: function (form) {
                    form.submit();
                    $('#submitQuestionForm').attr('disable', 'disable');
                }, errorPlacement: function (error, element) {

                    error.html('.kjlkh;lkh;lh;');
                    console.log(error);
                    error.insertAfter(element);
                }
            });


            $('#submitQuestionForm').click(function () {
                validateOptions();
                var children = $("#addQuestionFormPage").find('.form-control');
                children.each(function (key, value) {
                    if ($(this).valid() == false) {
                        $('label.error').each(function () {
                            $(this).removeAttr('style');
                            $(this).html(reqiuredFields)

                        })
                    }
                    $(this).valid()
                });
                if ($("#addQuestionFormPage").valid() == true && children.valid() == true) {
                    $("#addQuestionFormPage").submit()
                } else if (children.valid() != true) {

                }

            });
        }

    </script>

    <script>
        var url = "{{route('ajax/getCategoryService')}}";
        var token = "{{csrf_token()}}";
        var saveServiceURL = "{{route('ajax/saveService')}}";
        var getCategoryInfo = "{{route('ajax/getCategoryInfo')}}";
        var removeCategory = "{{route('ajax/removeCategory')}}";
        var addCategoryUrl = "{{route('ajax/addCategory')}}";
        var getSingleService = "{{route('ajax/getSingleService')}}";
        var editCategoryURL = "{{route('ajax/editCategory')}}";
        var categoryId = -1;
        var notification = "";
        var service = "{{route('services')}}";
        var getCategory = "{{route('ajaxCategory')}}";
        var getCategoryOfService = "{{route('ajax/getCategoryOfService')}}";
        var updateService = "{{route('ajax/updateService')}}";
        var deleteService = "{{route('ajax/deleteService')}}";
        var saveQuestionUrl = "{{route('ajax/saveQuestion')}}";
        var serviceInfo = "{{route('serviceInfo')}}";
        var questions = "{{route('questions')}}";
        var search = "@lang('lang.search')";
        var numberOfRows = "@lang('lang.numberOfRows')";
        var urgent = "@lang('lang.urgent')";
        var nonUrgent = "@lang('lang.nonUrgent')";
        var active = "@lang('lang.active')";
        var inActive = "@lang('lang.inActive')";
        var noService = "@lang('lang.noService')";
        var options = "@lang('lang.options')";
        var removeService = "@lang('lang.removeService')";
        var editService = "@lang('lang.editService')";
        var warning = "@lang('lang.warning')";
        var warningMessage = "@lang('lang.warningMessage')";
        var yes = "@lang('lang.yes')";
        var no = "@lang('lang.no')";
        var deletion = "@lang('lang.deletion')";
        var deletionMessage = "@lang('lang.deletionMessageForService')";
        var deletionMessageForService = "@lang('lang.warningMessageForService')";
        var addQuestion_lang = "@lang('lang.addQuestion')";
        var showQuestion_lang = "@lang('lang.showQuestion')";
        var showServiceInfo_lang = "@lang('lang.showServiceInfo')";
    </script>

@endsection




