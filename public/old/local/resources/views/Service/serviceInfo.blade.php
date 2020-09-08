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

        .serviceImage {
            height: auto !important;
            width: auto !important;
        }


    </style>
@endsection
@section('head_title')
    {{trans('lang.service_info')}}
@endsection
@section('title')
    {!!  trans('lang.service_info') !!}
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

    <div class="row" style="font-size:17px">
        <div class="col-lg-12">
            <div name="service" class="col-lg-12">

                <div class="portlet green-meadow box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>@lang('lang.serviceDetails')
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>

                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-lg-12 imageDiv">
                                <div class="col-lg-6">
                                    @lang('lang.service')
                                    : {{$serviceInfo['service']->s_service}}

                                    <div class="col-lg-12"
                                         style="padding-right: 0 !important;padding-left: 0 !important;">
                                        @lang('lang.serviceStatus') :
                                        @if($serviceInfo['service']->enabled == 1)
                                            <span class="">@lang('lang.active')</span>
                                        @else
                                            <span class=""><span>@lang('lang.inActive')</span></span>

                                        @endif
                                    </div>
                                    <div class="col-lg-12"
                                         style="padding-right: 0 !important;padding-left: 0 !important;">
                                        @lang('lang.serviceDescription') <br/>
                                        <div style="font-size:14px; display:inline-block; height: 100%; width:100%; padding-top: 10px"> {{$serviceInfo['service']->s_description}} </div>

                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <img src="{{asset($serviceInfo['servicePic'])}}"
                                         class="center" style="" width="170"
                                         height="170"/>
                                    <label class="col-lg-12" style="border: 1px #FFFFFF !important;">صورة الخدمة</label>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>
        <div class="col-lg-12">
            <div name="service" class="col-lg-12">

                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>@lang('lang.serviceCategory')
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>

                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-lg-12">
                                <table id="serviceCategory"
                                       class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">

                                    <thead>
                                    <tr>
                                        <th class="sorting">#</th>
                                        <th class="sorting">@lang('lang.categoryNameAr')</th>
                                        <th class="sorting">@lang('lang.categoryNameEn')</th>
                                        <th class="sorting">@lang('lang.serviceStatus')</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @for($counter = 0 ; $counter < sizeof($serviceInfo['serviceCategory']) ; $counter++)
                                        <tr>
                                            <td>{{$counter+1}}</td>
                                            <td>{{$serviceInfo['serviceCategory'][$counter]->s_category_name_ar}}</td>
                                            <td>{{$serviceInfo['serviceCategory'][$counter]->s_category_name_en}}</td>
                                            <td>@if($serviceInfo['serviceCategory'][$counter]->b_enabled == 1 ) @lang('lang.active')@else  @lang('lang.inActive')@endif</td>
                                            <td>{{$serviceInfo['serviceCategory'][$counter]->s_category_name}}</td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>


                </div>


            </div>

        </div>
        <div class="col-lg-12">
            <div name="service" class="col-lg-12">

                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>@lang('lang.serviceQuestion')
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>

                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-lg-12">
                                <table id="serviceQuestions"
                                       class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">

                                    <thead>
                                    <tr>
                                        <th class="sorting">#</th>
                                        <th class="sorting">@lang('lang.question_ar')</th>
                                        <th class="sorting">@lang('lang.question_en')</th>
                                        <th class="sorting">@lang('lang.serviceStatus')</th>
                                        <th class="sorting">@lang('lang.options')</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @for($counter = 0 ; $counter < sizeof($serviceInfo['serviceQuestion']) ; $counter++)
                                        <tr>
                                            <td>{{$counter+1}}</td>
                                            <td>{{$serviceInfo['serviceQuestion'][$counter]->s_question_ar}}</td>
                                            <td>{{$serviceInfo['serviceQuestion'][$counter]->s_question_en}}</td>
                                            <td>@if($serviceInfo['serviceQuestion'][$counter]->b_enabled == 1 )@lang('lang.active') @else@lang('lang.inActive')  @endif</td>
                                            <td>
                                                <div class='dropdown'>
                                                    <button class='btn btn-default dropdown-toggle' type='button'
                                                            id='dropdownMenu1' data-toggle='dropdown'
                                                            aria-haspopup='true'
                                                            aria-expanded='true'>@lang('lang.options')
                                                        <span class='caret'></span>
                                                    </button>
                                                    <ul class='dropdown-menu' aria-labelledby='dropdownMenu1'>
                                                        <input type='hidden' id='questionId'
                                                               value='{{$serviceInfo['serviceQuestion'][$counter]->pk_i_id}}'/>
                                                        <input type='hidden' id='optionName'
                                                               value='{{$serviceInfo['serviceQuestion'][$counter]->s_question_ar}},{{$serviceInfo['serviceQuestion'][$counter]->s_question_en}}'/>
                                                        <li><a id='showOptions' value='showOptions'
                                                               class='showOptions'>@lang('lang.showOptions')</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                </div>


            </div>

        </div>
        <div class="col-lg-12">
            <div name="service" class="col-lg-12 hide clone">

                <div class="portlet box red">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>
                            <div class="questionHeader"></div>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>

                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-lg-12">
                                <table id="questionOptions"
                                       class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">

                                    <thead>
                                    <tr>
                                        <th class="sorting">#</th>
                                        <th class="sorting">@lang('lang.optionLang')</th>
                                        <th class="sorting">@lang('lang.optionDescriptionLang')</th>
                                        <th class="sorting">@lang('lang.serviceStatus')</th>
                                    </tr>
                                    </thead>

                                </table>

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
        var questionOptionsDataTable;
        var language = "{{app()->getLocale()}}";
        $(document).ready(function () {
            if (language == 'ar')
                $('.questionHeader').css('float', 'right');
            else
                $('.questionHeader').css('float', 'left ');

            $('#serviceQuestions').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: '',
                        className: 'hidden'
                    }

                ],
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false
            });

            fetchOptions();
            $('.paging_bootstrap_number').css('float', 'left !important');
        });

        function fetchOptions() {
            $('body').on('click', '.showOptions', function () {
                var questionId = $(this).parents().siblings('#questionId').val();
                var questionName = $(this).parents().siblings('#optionName').val().split(',');
                $('.questionHeader').html(language == 'en' ? questionName[1] : questionName[0]);
                getOptionsAjax(questionId);
            });

        }

        function getOptionsAjax($id) {

            fillDataTable($id);
            $('.clone').removeClass('hide');
        }

        function fillDataTable($id) {
            console.log($.fn.DataTable.isDataTable('#questionOptions'));
            if ($.fn.DataTable.isDataTable('#questionOptions')) {
                questionOptionsDataTable.destroy();
            }
            questionOptionsDataTable = buildDatatTable($id);
        }

        function buildDatatTable($id) {

            var questionOption = $('#questionOptions').DataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: '',
                        className: 'hidden'
                    }

                ],
                "oLanguage": {
                    "sSearch": "",
                    "processing": "Processing...",
                    "sEmptyTable": "",
                    "sLengthMenu": "_MENU_ "

                },
                "ajax": '{{route('ajax/QuestionOptions')}}' + '?id=' + $id,
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;

                        }
                    },
                    {"data": "s_option"},
                    {"data": "s_description"},
                    {
                        "data": "b_enabled", render: function (data, type, full, meta) {

                        var calssName = "btn btn-circle green btn-outline";
                        var status = "@lang('lang.active')";
                        if (data != 1) {
                            calssName = "btn btn-circle red btn-outline";
                            status = "@lang('lang.inActive')";
                        }

                        return "<span class='" + calssName + "'>" + status + "</span>";
                    }
                    }


                ]


            });
            $('#questionOptions')
                    .on('error.dt', function (e, settings, techNote, message) {

                    })
                    .DataTable();

            return questionOption;
        }

    </script>

@endsection




