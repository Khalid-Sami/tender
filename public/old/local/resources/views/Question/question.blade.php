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
    {{trans('lang.questionManagement')}}
@endsection
@section('title')
    {!!  trans('lang.questionManagement') !!}
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

                <div class="col-lg-12">
                    <a id="addNewQuestionButton" href="{{route('admin.add.question',$id)}}" class="btn green"><i
                                class="glyphicon glyphicon-plus"> </i>
                        سؤال جديد
                    </a>



                </div>
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="panel-content">
                                <table id="questions"
                                       class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">

                                    <thead>
                                    <tr>
                                        <th class="sorting">#</th>
                                        <th class="sorting">السؤال</th>
                                        <th class="sorting">السؤال (انجليزي)</th>
                                        <th class="sorting">نوع السؤال</th>
                                        <th class="sorting">نوع الاجابة</th>
                                        <th class="sorting">الحالة</th>
                                        <th class="sorting">خيارات</th>
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
        var fillQuestionsInDataTable = "{{route('ajax/fillQuestions')}}";
        var deleteQuestionUrl = "{{route('ajax/deleteQuestion')}}";
        var getQuestionUrl = "{{route('ajax/getQuestion')}}";
        var updateQuestion = "{{route('ajax/updateQuestion')}}";
        var addOption = "{{route('ajax/addOption')}}";
        var search = "@lang('lang.search')";
        var numberOfRows = "@lang('lang.numberOfRows')";
        var urgent = "@lang('lang.urgent')";
        var nonUrgent = "@lang('lang.nonUrgent')";
        var active = "@lang('lang.active')";
        var inActive = "@lang('lang.inActive')";
        var noService = "@lang('lang.noService')";
        var options = "@lang('lang.options')";
        var sure = "@lang('lang.sure')";
        var added = "@lang('lang.added')";
        var removeService = "@lang('lang.removeService')";
        var editService = "@lang('lang.editService')";
        var warning = "@lang('lang.warning')";
        var warningMessage = "@lang('lang.warningMessage')";
        var yes = "@lang('lang.yes')";
        var no = "@lang('lang.no')";
        var deletion = "@lang('lang.deletion')";
        var deletionMessage = "@lang('lang.deletionMessageForService')";
        var deletionMessageForService = "@lang('lang.warningMessageForService')";
        var lang = "{{app()->getLocale()}}";
    </script>
    <script src="{{asset('/assets/scripts/question.js')}}" type="text/javascript"></script>

@endsection




