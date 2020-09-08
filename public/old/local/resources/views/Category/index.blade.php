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

        /*.showSweetAlert {*/
        /*border-radius: 5px !important;*/
        /*}*/

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

        .dataTables_paginate {
            float: left !important
        }
    </style>
@endsection
@section('head_title')
    {{trans('lang.categories_management')}}
@endsection
@section('title')
    {!!  trans('lang.categories_management') !!}
@endsection

@section('msg')
    <div id="alert" class="alert alert-success text-center" role="alert"
         style=" display:none; position: absolute;width: 100%;z-index: 1;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{--<strong>Info!</strong>--}}
        <div id="alertContent"> Indicates a neutral informative change or action.</div>
    </div>


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


            <div class="row">

                <div class="col-lg-12">
                    <button id="addNewServiceButton" type="button" class="btn green"
                            data-toggle='modal' data-target='#basic'><i
                                class="glyphicon glyphicon-plus"></i>@lang('lang.newService')
                    </button>

                    <button id="addNewServiceButton" type="button" class="btn green"
                            data-toggle='modal' data-target='#addCategory'><i
                                class="glyphicon glyphicon-plus"></i>
                        @lang('lang.newCategory')
                    </button>

                </div>
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="panel-content">
                                <table id="categoriesTable"
                                       class="table table-striped table-bordered table-hover table-checkable dataTable no-footer">

                                    <thead>
                                    <tr>
                                        <th class="sorting">#</th>
                                        <th class="sorting">@lang('lang.categoryNameAr')</th>
                                        <th class="sorting">@lang('lang.categoryNameEn')</th>
                                        <th class="sorting">@lang('lang.serviceStatus')</th>
                                        <th class="sorting">@lang('lang.numberOfServices')</th>
                                        <th class="sorting">@lang('lang.properties')</th>
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
    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
        <form id="addNewService" action="" method="POST">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                style=" color:#FFF !important; font-size: 17px !important;"></button>
                        <h3 class="modal-title">@lang('lang.addNewService')</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-body">

                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <div class="col-lg-6 form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceNameAr')</label>
                                    <input id="serviceName_ar" name="serviceName_ar" class="form-control" type="text"
                                           placeholder="@lang('lang.serviceNameAr')"/>
                                </div>
                                <div class="col-lg-6  form-group">
                                    <label class="label-control"
                                           style="font-size: 16px !important;">@lang('lang.serviceNameEn')</label>
                                    <input id="serviceName_en" name="serviceName_en" class="form-control" type="text"
                                           placeholder="@lang('lang.serviceNameEn')"/>
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
                                      placeholder="@lang('lang.serviceDescriptionEn')"></textarea>
                                </div>


                                <div class="col-md-12 form-group">
                                    <label class="control-label "
                                           style="font-size: 16px !important;">@lang('lang.category')</label>
                                    <div class="">
                                        <select id="categories" name="categories[]" multiple="multiple"

                                                class="form-control select select2-multiple select2-hidden-accessible "></select>
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
                                           style="font-size: 16px !important;">@lang('lang.serviceStatus'): </label>
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
                                        <select class="select serviceIcon">
                                            <option selected="selected">fa fa-chevron-circle-down</option>
                                            <option>fa fa-chevron-circle-left</option>
                                            <option>fa fa-chevron-circle-right</option>
                                            <option>fa fa-hand-o-left</option>
                                            <option>fa fa-hand-o-right</option>
                                        </select>

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
                                                                        <span class="fileinput-new"> {{ trans('lang.select_image') }} </span>
                                                                        <span class="fileinput-exists"> {{ trans('lang.change_img') }} </span>
                                                                        <input type="file" name="serviceImage"
                                                                               id="serviceImage"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists"
                                                   data-dismiss="fileinput"> {{trans('lang.remove')}} </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="text-align: right !important;">
                        <button id="submit" type="button"
                                class=" btn btn-primary">@lang('lang.add')</button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('lang.cancel')</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="addCategory" tabindex="-1" role="basic" aria-hidden="true">
        <form id="addNewCategory" method="POST" name="saveCategory" id="saveCategory" class=""
              action="{{route('saveCategory')}}">
            {{--{{csrf_field()}}--}}
            <div class="modal-dialog">
                {{--<form>--}}
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                style=" color:#FFF !important; font-size: 17px !important;"></button>
                        <h3 class="modal-title">@lang('lang.addNewCategory')</h3>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                        <div class="row">
                            <div class="form-body">
                                <div class="col-md-6 form-group">
                                    <label class="" style="font-size: 16px">@lang('lang.categoryNameAr')</label>
                                    <input id="categoryName_ar" name="categoryName_ar"
                                           class="form-control" type="text"
                                           placeholder="@lang('lang.categoryNameAr')">

                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="" style="font-size: 16px">@lang('lang.categoryNameEn')</label>
                                    <input id="categoryName_en" name="categoryName_en"
                                           class="form-control" type="text"
                                           placeholder="@lang('lang.categoryNameEn')">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group"
                                         style="padding-right: 0 !important; padding-left: 0 !important;">
                                        <label class="control-label- col-md-4"
                                               style="font-size: 16px">@lang('lang.serviceStatus')</label>
                                        <select id="categoryStatus" name="categoryStatus" class="form-control">
                                            <option value="فعال">@lang('lang.active')</option>
                                            <option value="غير فعال">@lang('lang.inActive')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="text-align: right !important;">
                        <button id="submitButtonForCategory" type="button"
                                class=" btn btn-primary">@lang('lang.add')
                        </button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('lang.cancel')</button>
                    </div>
                </div>


                {{--</form>--}}
                        <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="addNewCategory" method="POST" name="saveCategory" id="saveCategory" class=""
              action="{{route('saveCategory')}}">
            {{csrf_field()}}
            <div class="modal-dialog">
                {{--<form>--}}
                <div class="modal-content ">
                    <div class="modal-header " style="">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                style=" color:#FFF !important; font-size: 17px !important;"></button>
                        <h3 class="modal-title">@lang('lang.removeCategory')</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h4> @lang('lang.removeCategoryMessage')</h4>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: right !important;">
                        <button id="doCategoryDeletion" type="button" class=" btn btn-danger">@lang('lang.remove')
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.cancel')</button>
                    </div>
                </div>


                {{--</form>--}}
                        <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="editCategoryDiv" tabindex="-1" role="basic" aria-hidden="true">
        <form id="editCategory" method="POST" name="saveCategory" id="saveCategory" class=""
              action="">

            <div class="modal-dialog">
                {{--<form>--}}
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                style=" color:#FFF !important; font-size: 17px !important;"></button>
                        <h3 class="modal-title">@lang('lang.editCategory')</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input namr="_token" type="hidden" value="{{csrf_token()}}"/>
                            <div class="form-body">
                                <div class="col-md-6 form-group">
                                    <label class="" style="font-size: 16px">@lang('lang.categoryNameAr')</label>
                                    <input id="editedCategoryName_ar" name="editedCategoryName_ar"
                                           class="form-control" type="text"
                                           placeholder="@lang('lang.categoryNameAr')">

                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="" style="font-size: 16px">@lang('lang.categoryNameEn')</label>
                                    <input id="editedCategoryName_en" name="editedCategoryName_en"
                                           class="form-control" type="text"
                                           placeholder="@lang('lang.categoryNameEn')">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label- col-md-4"
                                               style="font-size: 16px">@lang('lang.serviceStatus')</label>
                                        <select id="editedCategoryStatus" name="editedCategoryStatus"
                                                class="form-control select">
                                            <option value="فعال">@lang('lang.active')</option>
                                            <option value="غير فعال">@lang('lang.inActive')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="text-align: right !important;">
                        <button id="editedCategoryButton" type="button"
                                class=" btn btn-primary">@lang('lang.edit')
                        </button>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">@lang('lang.cancel')</button>
                    </div>
                </div>


                {{--</form>--}}
                        <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>


@endsection

@section('scripts')

    <script>
        var url = "{{route('ajaxCategory')}}";
        var token = "{{csrf_token()}}";
        var saveServiceURL = "{{route('ajax/saveService')}}";
        var saveCategoryInfoUrl = "{{route('ajax/getCategoryInfo')}}";
        var removeCategory = "{{route('ajax/removeCategory')}}";
        var addCategoryUrl = "{{route('ajax/addCategory')}}";
        var getSingleCategory = "{{route('ajax/getSingleCategory')}}";
        var editCategoryURL = "{{route('ajax/editCategory')}}";
        var categoryId = -1;
        var notification = "";
        var service = "{{route('services')}}";
        var search = "@lang('lang.search')";
        var numberOfRows = "@lang('lang.numberOfRows')";
        var urgent = "@lang('lang.urgent')";
        var nonUrgent = "@lang('lang.nonUrgent')";
        var active = "@lang('lang.active')";
        var inActive = "@lang('lang.inActive')";
        var noService = "@lang('lang.noService')";
        var options = "@lang('lang.options')";
        var removeCategoryLang = "@lang('lang.removeCategory')";
        var editCategoryLang = "@lang('lang.editCategory')";
        var showService = "@lang('lang.showServices')";
        var warning = "@lang('lang.warning')";
        var warningMessage = "@lang('lang.warningMessage')";
        var yes = "@lang('lang.yes')";
        var no = "@lang('lang.no')";
        var deletion = "@lang('lang.deletionMessageForCategory')";
        var deletionMessage = "@lang('lang.deletionMessageForCategory')";
        var updated = "@lang('lang.updated')";
        var lang = "{{app()->getLocale()}}";
        //        var showDatatableElements = "";

    </script>

    <script src="{{asset('/assets/scripts/categoryScripts.js')}}"></script>

@endsection




