@extends('_layout')

@section('style')
    <style>

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
    {{trans('lang.services_management')}}
@endsection
@section('title')
    <a href="{{route('showCategories')}}">{!!trans('lang.categories') !!}</a>{{" / "}}{{$category or ''}}

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

        <div class="col-lg-12">
            <button id="addNewServiceButton" type="button" class="btn green"
                    data-toggle='modal' data-target='#basic'><i
                        class="glyphicon glyphicon-plus"> </i>
                @lang('lang.newService')
                {{--@lang('lang.newService')--}}
            </button>


        </div>
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="panel-content">
                        <table id="services"
                               class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">

                            <thead>
                            <tr>
                                <th class="sorting">#</th>
                                <th class="sorting">@lang('lang.serviceNameAr') </th>
                                <th class="sorting">@lang('lang.serviceNameEn') </th>
                                <th class="sorting">@lang('lang.serviceStatus') </th>
                                <th class="sorting">@lang('lang.serviceEmergency') </th>
                                <th class="sorting">@lang('lang.properties') </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
        <form id="addNewService" action="" method="POST">
            {{--{{csrf_field()}}--}}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                style=" color:#FFF !important; font-size: 17px !important;"></button>
                        <h3 class="modal-title">@lang('lang.addNewService') </h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-body">

                                <input name="_token" value="{{csrf_token()}}" type="hidden"/>
                                <div class="col-lg-6 form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceNameAr')</label>
                                    <input id="serviceName_ar" name="serviceName_ar" class="form-control" type="text"
                                           placeholder="@lang('lang.serviceNameAr')"/>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceNameEnglish')</label>
                                    <input id="serviceName_en" name="serviceName_en" class="form-control" type="text"
                                           placeholder="@lang('lang.serviceNameEnglish')"/>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceDescriptionAr')</label>
                            <textarea id="description_ar" name="description_ar" class="form-control" rows="3"
                                      placeholder="@lang('lang.serviceDescriptionAr')"></textarea>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceDescriptionEn')</label>
                            <textarea id="description_en" name="description_en" class="form-control" rows="3"
                                      placeholder="@lang('lang.serviceDescriptionAr')"></textarea>
                                </div>


                                <div class="col-md-12 form-group">
                                    <label class="control-label "
                                           style="font-size: 16px !important;">@lang('lang.category')</label>
                                    <div class="">
                                        <select id="categories" name="categories[]" multiple="multiple"

                                                class="form-control select2-multiple select2-hidden-accessible"></select>
                                    </div>

                                </div>
                                <div class="col-md-6 form-group">

                                    <label class="control-label"
                                           style="font-size: 16px !important;">@lang('lang.serviceEmergency'): </label>
                                    <div class="col-lg-12" style="padding-right: 0 !important;">
                                        <select class="select emergency">
                                            <option value="1" selected>@lang('lang.yes')</option>
                                            <option value="0">@lang('lang.no')</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label"
                                           style="font-size: 16px !important;">@lang('lang.serviceStatusRadio')
                                        : </label>
                                    <div class="col-lg-12" style="padding-right: 0 !important;">
                                        <select class="select status">
                                            <option value="1" selected>@lang('lang.active')</option>
                                            <option value="0">@lang('lang.inActive')</option>
                                        </select>

                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-9 form-group" style="padding-right: 0 !important">
                                        <label class="control-label"
                                               style="font-size: 16px !important;">@lang('lang.serviceStatus'): </label>
                                        {{--<div class="col-lg-12">--}}
                                        <select class="select serviceIcon">
                                            <option selected="selected">fa fa-chevron-circle-down</option>
                                            <option>fa fa-chevron-circle-left</option>
                                            <option>fa fa-chevron-circle-right</option>
                                            <option>fa fa-hand-o-left</option>
                                            <option>fa fa-hand-o-right</option>
                                        </select>


                                        {{--</div>--}}

                                    </div>
                                    <div class="col-md-3 form-group showServiceIcon h2">
                                        <i class="" style="padding-top: 15px !important;"></i>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group ">
                                    <label class="control-label">صورة الخدمة</label>
                                    <div class="">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                     alt=""/></div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px;"></div>
                                            <div>
                                                                    <span class="btn default btn-file">
                                                                        <span class="fileinput-new"> Select image </span>
                                                                        <span class="fileinput-exists"> Change </span>
                                                                        <input type="file" name="serviceImage"
                                                                               id="serviceImage"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists"
                                                   data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                        {{--<div class="clearfix margin-top-10">--}}
                                        {{--<span class="label label-danger">NOTE!</span> Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead. </div>--}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="text-align: right !important;">
                        <button id="submit" type="button"
                                class=" btn btn-primary"> @lang('lang.add')</button>
                        <button type="button" class="btn btn-defualt"
                                data-dismiss="modal">@lang('lang.cancel')</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editService" name="modal" tabindex="-1" role="basic" aria-hidden="true">
        <form id="editService" action="" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                style=" color:#FFF !important; font-size: 17px !important;"></button>
                        <h3 class="modal-title">@lang('lang.editService')</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-body">

                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <div class="col-lg-6 form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceNameAr')</label>
                                    <input id="editedServiceName_ar" name="editedServiceName_ar" class="form-control"
                                           type="text"
                                           placeholder="@lang('lang.serviceNameAr')"/>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceNameEn')</label>
                                    <input id="editedServiceName_en" name="editedServiceName_en" class="form-control"
                                           type="text"
                                           placeholder="@lang('lang.serviceNameEn')"/>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceDescriptionAr')</label>
                            <textarea id="editedDescription_ar" name="editedDescription_ar" class="form-control"
                                      rows="3"
                                      placeholder="@lang('lang.serviceDescriptionAr')"></textarea>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceDescriptionEn')</label>
                            <textarea id="editedDescription_en" name="editedDescription_en" class="form-control"
                                      rows="3"
                                      placeholder="@lang('lang.serviceDescriptionEn')"></textarea>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label class="control-label "
                                           style="font-size: 16px !important;">@lang('lang.category')</label>
                                    <div class="">
                                        <select id="editedCategories" name="editedCategories[]" multiple="multiple"

                                                class="form-control select2-multiple select2-hidden-accessible"></select>
                                    </div>

                                </div>
                                <div class="col-md-6 form-group">

                                    <label class="control-label"
                                           style="font-size: 16px !important;">@lang('lang.serviceEmergency'):</label>
                                    <div class="">
                                        <select class="select editedEmergency">
                                            <option value="1">@lang('lang.yes')</option>
                                            <option value="0">@lang('lang.no')</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="control-label"
                                           style="font-size: 16px !important;">@lang('lang.serviceStatus'): </label>
                                    <div class="">
                                        <select class="select editedStatus">
                                            <option value="1">@lang('lang.active')</option>
                                            <option value="0">@lang('lang.inActive')</option>
                                        </select>

                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-9 form-group" style="padding-right: 0 !important">
                                        <label class="control-label"
                                               style="font-size: 16px !important;">@lang('lang.serviceStatus'): </label>
                                        {{--<div class="col-lg-12">--}}
                                        <select class="select editedServiceIcon">
                                            <option>fa fa-chevron-circle-down</option>
                                            <option>fa fa-chevron-circle-left</option>
                                            <option>fa fa-bath</option>
                                            <option>fa fa-hand-o-left</option>
                                            <option>fa fa-hand-o-right</option>
                                        </select>
                                        {{--</div>--}}

                                    </div>
                                    <div class="col-md-3 form-group showServiceIcon h2">
                                        <i class="fa fa-bath" style="padding-top: 15px !important;"></i>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group ">
                                    <label class="control-label">صورة الخدمة</label>
                                    <div class="">
                                        <div class="fileinput fileinput-new toBeRemoved" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail " style="width: 200px; height: 150px;">
                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                     alt="" class=""/></div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px;">
                                                <img src=""
                                                     alt="" class="editedServiceImage" style="max-height: 140px;"/>
                                            </div>
                                            <div>
                                                                    <span class="btn default btn-file">
                                                                        <span class="fileinput-new"> {{ trans('lang.select_image') }} </span>
                                                                        <span class="fileinput-exists"> {{ trans('lang.change_img') }} </span>
                                                                        <input type="file" name="editedServiceImage"
                                                                               id="editedServiceImageInput"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists"
                                                   data-dismiss="fileinput"> {{ trans('lang.delete_img') }} </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="text-align: right !important;">
                        <button id="editedSubmit" type="button"
                                class=" btn  btn-primary">  @lang('lang.edit')</button>
                        <button type="button" class="btn bt-default closeButton"
                                data-dismiss="modal"> @lang('lang.cancel')</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
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
//        var categoryId = -1;
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
        var sure = "@lang('lang.sure')";
        var added = "@lang('lang.added')";
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
        var categoryId = "{{$categoryId}}";
        var lang = "{{app()->getLocale()}}";
    </script>
    <script src="{{asset('/assets/scripts/serviceScripts.js')}}"></script>



@endsection




