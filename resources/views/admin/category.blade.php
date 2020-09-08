@extends('_layout')
@section('style')
<style>
    .mainCategory{
        background-color:green;
    }

</style>
@endsection
@section('head_title')
    {{trans('lang.managementCategories')}}
@endsection
@section('title')
    {{trans('lang.managementCategories')}}
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
        <div class="col-sm-12">
            <button class="btn green col-sm-2 col-sm-offset-10" id="addCategory"><span class="fa fa-plus"></span> @lang('lang.newCategory')</button>
        </div>
    </div>

        <div class="row allSelectCategories">
            {!! Form::hidden('method','get') !!}
                <div class="form-group col-sm-3 selectCategoriesAdding">
                    <label name="categoryTypeAdding1">{{ trans('lang.categoryType') }}</label>
                    <select name="categoryTypeAdding1" id="categoryTypeAdding1" class="select2 categories">
                        @if(app()->getLocale() == 'en')
                            <option value="-1" selected>All</option>
                            <option value="0">Major</option>
                        @else
                            <option value="-1" selected>الكل</option>
                            <option value="0">رئيسي</option>
                        @endif
                        @foreach($categories as $category)
                            <option value="{{ $category->pk_i_id }}">{{ $category->s_name }}</option>
                        @endforeach
                    </select>
                    <div id="categoryTypeAdding_validate1" class="font-red"></div>
                </div>
                <div class="form-group col-sm-3 selectCategoriesAdding">
                    <label name="selectSubCategories1">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                    <select name="subCategoryTypeAdding1" id="subCategoryTypeAdding1" class="select2 categories subCategories">
                        <option value="">{{ trans('lang.selectCategory') }}</option>
                    </select>

                </div>
                <div class="form-group col-sm-3 selectCategoriesAdding">
                    <label name="selectSubCategories2">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                    <select name="subCategoryTypeAdding2" id="subCategoryTypeAdding2" class="select2 categories subCategories">
                        <option value="">{{ trans('lang.selectCategory') }}</option>
                    </select>

                </div>
                <div class="form-group col-sm-3">
                    {!! Form::input('button',null,trans('lang.search'), ['class' => 'btn green','style'=>'margin-top:24px;','id' => 'search']) !!}
                </div>
            </div>


    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.category')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.categoryType')</th>
                    <th>@lang('lang.basicCategory')</th>
                    <th>@lang('lang.options')</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
    <!-- /.modal -->
    <div id="showCategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog editCategories" role="document">
            {!! Form::open(['id'=>'editCategory','method'=>'PATCH','action'=>'AdminController@updateCategory']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.editCategory')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('pk_i_id',null,['id'=>'c_pk_i_id']) !!}
                        {!! Form::hidden('parentID',null,['id'=>'parentID']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_ar',trans('lang.categoryNameAr')) !!}
                            {!! Form::text('name_ar',null,['class'=>'form-control','id'=>'categoryNameAr']) !!}
                            <div id="name_ar_validate" class="font-red"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_en',trans('lang.categoryNameEn')) !!}
                            {!! Form::text('name_en',null,['class'=>'form-control','id'=>'categoryNameEn']) !!}
                            <div id="name_en_validate" class="font-red"></div>

                        </div>
                    </div>
                    <div class="row allSelectCategories editCategoriesSelect">
                        <div class="form-group col-sm-6 selectCategoriesAdding">
                            <label name="categoryTypeAdding1">{{ trans('lang.categoryType') }}</label>
                            <select name="categoryTypeAdding1" id="categoryTypeAdding2" class="form-control select categories">
                                @if(app()->getLocale() == 'en')
                                    <option value="0">Major</option>
                                @else
                                    <option value="0">رئيسي</option>
                                @endif
                                @foreach($categories as $category)
                                    <option value="{{ $category->pk_i_id }}">{{ $category->s_name }}</option>
                                @endforeach
                            </select>
                            <div id="categoryTypeAdding_validate1" class="font-red"></div>
                        </div>
                        <div class="form-group col-sm-6 selectCategoriesAdding">
                            <label name="selectSubCategories1">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                            <select name="subCategoryTypeAdding1" id="subCategoryTypeAdding3" class="select2 categories subCategories">
                                <option value="">{{ trans('lang.selectCategory') }}</option>
                            </select>

                        </div>
                        <div class="form-group col-sm-6 selectCategoriesAdding">
                            <label name="selectSubCategories2">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                            <select name="subCategoryTypeAdding2" id="subCategoryTypeAdding4" class="select2 categories subCategories">
                                <option value="">{{ trans('lang.selectCategory') }}</option>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            {!! Form::label('c_status',trans('lang.status')) !!}
                            <?php
                            $status;
                            if (app()->getLocale() == 'en') {
                                $status = array('' => 'Choose Option', '1' => 'enable', '0' => 'disable');
                            } else {
                                $status = array('' => 'اختار من القائمة', '1' => 'فعال', '0' => 'غير فعال');
                            }

                            ?>

                            {!! Form::select('c_status',isset($status)?$status:[],null,['class'=>'form-control select','id'=>'category_status']) !!}
                            <div id="c_status_validate" class="font-red"></div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">@lang('lang.close')</button>
                    <button type="submit" class="btn btn-primary submitEditCategory submitCategory">@lang('lang.save')</button>
                </div>
            </div><!-- /.modal-content -->
            <input name="categoriesSeries[]" type="hidden">
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="addCategoryModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id'=>'addCategoryForm','method'=>'POST','action'=>'AdminController@insertCategory']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.addNewCategory')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('fk_i_parent_id',8) !!}
                        {!! Form::hidden('key','COUNTRIES') !!}
                        <div class="form-group col-sm-12">
                            {!! Form::label('name_ar',trans('lang.categoryNameAr')) !!}
                            {!! Form::text('name_ar',null,['class'=>'form-control']) !!}
                            <div id="name_ar_validate1" class="font-red"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            {!! Form::label('name_en',trans('lang.categoryNameEn')) !!}
                            {!! Form::text('name_en',null,['class'=>'form-control']) !!}
                            <div id="name_en_validate1" class="font-red"></div>

                        </div>
                    </div>
                    <div class="row allSelectCategories">
                            <div class="form-group col-sm-6 selectCategoriesAdding">
                                <label name="categoryTypeAdding1">{{ trans('lang.categoryType') }}</label>
                                <select name="categoryTypeAdding1" id="categoryTypeAdding3" class="select2 categories">
                                    @if(app()->getLocale() == 'en')
                                        <option value="0" selected>Major</option>
                                    @else
                                        <option value="0" selected>رئيسي</option>
                                    @endif

                                    @foreach($categories as $category)
                                        <option value="{{ $category->pk_i_id }}">{{ $category->s_name }}</option>
                                    @endforeach
                                </select>
                                <div id="categoryTypeAdding_validate1" class="font-red"></div>

                            </div>
                            <div class="form-group col-sm-6 selectCategoriesAdding">
                                <label name="selectSubCategories1">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                                <select name="subCategoryTypeAdding1" id="subCategoryTypeAdding5" class="select2 categories subCategories">
                                    <option value="">{{ trans('lang.selectCategory') }}</option>
                                </select>

                            </div>
                            <div class="form-group col-sm-6 selectCategoriesAdding">
                                <label name="selectSubCategories2">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                                <select name="subCategoryTypeAdding2" id="subCategoryTypeAdding6" class="select2 categories subCategories">
                                    <option value="">{{ trans('lang.selectCategory') }}</option>
                                </select>

                            </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            {!! Form::label('c_status',trans('lang.status')) !!}
                            <?php
                            $status;
                            if (app()->getLocale() == 'en') {
                                $status = array('' => 'Choose Option', '1' => 'enable', '0' => 'disable');
                            } else {
                                $status = array('' => 'اختار من القائمة', '1' => 'فعال', '0' => 'غير فعال');
                            }

                            ?>

                            {!! Form::select('c_status',isset($status)?$status:[],null,['class'=>'form-control select', 'id' => 'categoryStatus']) !!}
                            <div id="c_status_validate1" class="font-red"></div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">@lang('lang.close')</button>
                    <button type="submit" class="btn btn-primary submitAddCategory submitCategory">@lang('lang.save')</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script>
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $(document).ready(function () {

            $('#categoryStatus').val(1);

            $('.categories').select2({
                allowClear:true,
                {{--                placeholder: '{{ trans('lang.category') }}'--}}
            });
            $('.subCategories').select2({
                allowClear: true
            });

            var series = [];

            $('body').on('click', '.edit_category', function () {
                var rowCategory = $(this).siblings('#rowCategory').val()

                var pk_i_id = $(this).siblings('#pk_i_id').val();
                var s_name_ar = $(this).siblings('#s_name_ar').val();
                var s_name_en = $(this).siblings('#s_name_en').val();
                var status = $(this).siblings('#dt_status').val();
                var parentId = $(this).siblings('#s_parent_id').val();
                $('#categoryNameAr').val(s_name_ar);
                $('#categoryNameEn').val(s_name_en);
                $('#c_pk_i_id').val(pk_i_id);
                $('.submitEditCategory').prop('disabled', true);
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/admin/categoryIDSSeries/' + pk_i_id +'',
                    data:{
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (data, textStatus, jqXHR) {

                        data.series.reverse();
                        series = data.series;
                        $('#categoryTypeAdding2').val(data.series[0]).trigger('change');
                            series = series.filter(function(elem){
                                return elem != data.series[0];
                        });
//                        $('.submitEditCategory').prop('disabled', false);
                    }
                });

//            $("#categoryTypeAdding3").select2("val", parentId);
//            $('#categoryTypeAdding3').val(parentId);
                $('#category_status').val(status);
                $('#category_status').select2();
                $('#showCategory').modal('show');

            });

            var finalCategoryID = '';
            $('body').on('change', '.categories', function() {
                var saveBTN = $(this).closest('.modal-content').find('.submitCategory')
                var status = false;
                var categoryID = $(this).val();
                $(this).closest('.selectCategoriesAdding').nextAll('.selectCategoriesAdding').each(function () {
                    $(this).find('.superCategory').empty();
                    $(this).find('select option').not(':first').remove();
                });
                if($(this).attr('name') == 'subCategoryTypeAdding2'){
                    status = true;
                }

                var thisSelect = $(this).closest('.selectCategoriesAdding').next('.selectCategoriesAdding').find('select').attr('id');
                var text = $(this).find("option:selected").text();
                if($(this).val() != 0 && $(this).val() != -1 && !status){
                    saveBTN.prop('disabled',true);
                    $.ajax({
                        method:'GET',
                        dataType: 'json',
                        url: '{{url('/')}}/' + categoryID + '/getSubCategories',
                        data:{
                            "_token": "{{csrf_token()}}"
                        },
                        success: function (data, textStatus, jqXHR) {
                            $('#'+thisSelect).closest('.selectCategoriesAdding').find('.superCategory').html(text);
                            if (data.status){
                                $.each(data.subCategories, function (i, item) {
//                                    $('#'+thisSelect).append('<option value="'+item.pk_i_id+'">'+item.s_name+'</option>');
                                    $('#'+thisSelect).append($("<option></option>").attr("value",item.pk_i_id).text(item.s_name));
                                });
                            }
                            if(thisSelect == 'subCategoryTypeAdding3'){
                                if (series.length > 1){
                                    $('#subCategoryTypeAdding3').val(series[0]).trigger('change')
                                        series = series.filter(function(elem){
                                            return elem != series[0];
                                    });
                                }
                            }

                            if(thisSelect == 'subCategoryTypeAdding4'){
                                if (series.length > 1){
                                    $('#subCategoryTypeAdding4').val(series[0]).trigger('change')
                                    series = series.filter(function(elem){
                                        return elem != series[0];
                                    });
                                }
                            }
                            saveBTN.prop('disabled',false);
                        }
                    })
                }

            })

            $('.alert-dismissible').delay(3000).fadeOut('slow');
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
            $('body').on('click', '#search', function () {
                var selectedID = "";
                if($('#subCategoryTypeAdding2').val() != ""){
                    selectedID = $('#subCategoryTypeAdding2').val();
                }
                else if($('#subCategoryTypeAdding1').val() != ""){
                    selectedID = $('#subCategoryTypeAdding1').val();
                }
                else {
                    selectedID = $('#categoryTypeAdding1').val();
                }
                $('#myTable').DataTable({
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": '{{url('/')}}/admin/' + selectedID + '/getAllCategories'
                    },
                    "columns": [
                        {
                            mRender: function (data, type, row, full) {
                                return full['row'] + 1;
                            }
                        },
                        {data: 's_name', name: 's_name',defaultContent:""},
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
                                if(row.s_parent_id != 0){
                                    return '{{ trans('lang.Sub') }}'
                                }
                                else{
                                    return '{{ trans('lang.basic') }}'
                                }
                            }

                        },
                        {
                            mRender: function (data, type, row, full) {
                                if(row.s_parent_id != 0){
                                    @foreach($subCategoriesLevel2 as $sub)
                                    if (row.s_parent_id == '{{ $sub->pk_i_id }}'){
                                        if('{{ $sub->s_parent_id }}' == '0')
                                            return '{{ $sub->s_name }}'
                                        else {
                                            @foreach($subCategoriesLevel2 as $anotherSub)
                                                @if($anotherSub->pk_i_id == $sub->s_parent_id)
                                                    return '{{ $anotherSub->s_name }} / {{ $sub->s_name }}'
                                                @endif
                                            @endforeach
                                        }
                                    }
                                    @endforeach
                                }
                                else {
                                    return '------'
                                }
                            }
                        },
                        {
                            mRender: function (data, type, row, full) {
                                return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a class="edit_category">@lang('lang.editCategory')</a>' +
                                    '<input type="hidden" id="s_name_ar" value="' + row['s_name_ar'] + '">' +
                                    '<input type="hidden" id="s_name_en" value="' + row['s_name_en'] + '">' +
                                    '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                    '<input type="hidden" id="s_parent_id" value="' + row['s_parent_id'] + '">' +
                                    '<input type="hidden" id="dt_status" value="' + row['b_enabled'] + '">' +
                                    '</li>' +
                                    {{--'<li>' +--}}
                                    {{--'<a href="{{url('/')}}/admin/' + row['pk_i_id'] + '/subCategory">@lang('lang.subCategories')</a>' +--}}
                                    {{--'</li>' +--}}
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
            });
            $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{!! route('category.get','CATEGORY') !!}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 's_name', name: 's_name',defaultContent:""},
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
                            if(row.s_parent_id != 0){
                                    return '{{ trans('lang.Sub') }}'
                            }
                            else{
                                return '{{ trans('lang.basic') }}'
                            }
                        }

                    },
                    {
                        mRender: function (data, type, row, full) {
                            if(row.s_parent_id != 0){
                                @foreach($subCategoriesLevel2 as $sub)
                                    if (row.s_parent_id == '{{ $sub->pk_i_id }}'){
                                        return '{{ $sub->s_name }}'
                                }
                                @endforeach
                            }
                            else {
                                return '------'
                            }
                        }
                    },
                     {
                        mRender: function (data, type, row, full) {
                            return '<div class="dropdown">' +
                                '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                '<li>' +
                                '<a class="edit_category">@lang('lang.editCategory')</a>' +
                                '<input type="hidden" id="s_name_ar" value="' + row['s_name_ar'] + '">' +
                                '<input type="hidden" id="s_name_en" value="' + row['s_name_en'] + '">' +
                                '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                '<input type="hidden" id="s_parent_id" value="' + row['s_parent_id'] + '">' +
                                '<input type="hidden" id="dt_status" value="' + row['b_enabled'] + '">' +
                                '</li>' +
                                {{--'<li>' +--}}
                                {{--'<a href="{{url('/')}}/admin/' + row['pk_i_id'] + '/subCategory">@lang('lang.subCategories')</a>' +--}}
                                {{--'</li>' +--}}
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
        });

    </script>


    <script>

    </script>
    <script>
        $('body').on('click', '#addCategory', function () {
            $('#addCategoryModal').modal('show');
//            $('#categoryStatus').val(1);
            $('#categoryStatus').select2();
            $('#addCategoryForm').validate({
                rules: {
                    name_ar: "required",
                    name_en: "required",
                    c_status: "required",
                    categoryTypeAdding: "required"
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    error.appendTo($("#" + name + "_validate1"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    name_ar: "التصنيف حقل مطلوب",
                    name_en: "التصنيف حقل مطلوب (English)",
                    c_status: " الحالة حقل مطلوب",
                    categoryTypeAdding: "نوع التصنيف حقل مطلوب",
                    @else
                    name_ar: "category (Arabic) field is required",
                    name_en: "category field is required",
                    c_status: "status field is required",
                    categoryTypeAdding: "Category Type field is required"
                    @endif
                }, submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>

    <script>
        $('#editCategory').validate({
            rules: {
                name_ar: "required",
                name_en: "required",
                c_status: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() =='ar')
                name_ar: "التصنيف حقل مطلوب",
                name_en: "التصنيف حقل مطلوب (English)",
                c_status: " الحالة حقل مطلوب",
                @else
                name_ar: "category (Arabic) field is required",
                name_en: "category field is required",
                c_status: "status field is required"
                @endif
            }, submitHandler: function (form) {
                var series = []
                $('.editCategories').find('.categories').each(function (index) {
                    if($(this).val() != "")
                        series.push($(this).val())
                })
                $('input[name="categoriesSeries[]"]').val(series)
//                $('input[name="categoriesSeries[]"]').val(series)
                form.submit();
            }
        });
    </script>
    <script>

    </script>
@endsection