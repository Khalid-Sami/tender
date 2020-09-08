@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.subCategories')}}
@endsection
@section('title')
    {!!  trans('lang.category')." /<small> $name</small>" !!}
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
    <div class="col-sm-12">
        <button class="btn green" id="addCategory"><span class="fa fa-plus"></span> @lang('lang.newCategory')</button>
        <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('lang.category')</th>
                <th>@lang('lang.status')</th>
                <th>@lang('lang.options')</th>
            </tr>
            </thead>

        </table>
    </div>
    <!-- /.modal -->
    <div id="showCategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id'=>'editCategory','method'=>'PATCH','action'=>'AdminController@updateSubCategory']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.editCategory')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('pk_i_id',null,['id'=>'c_pk_i_id']) !!}
                        {!! Form::hidden('fk_parent_i_id',$categoryID) !!}
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
                    <div class="row">
                        <div class="form-group col-sm-6">
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
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="addCategoryModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id'=>'addCategoryForm','method'=>'POST','action'=>'AdminController@insertSubCategory']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.addNewCategory')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('s_parent_id',$categoryID) !!}
                        {!! Form::hidden('key','COUNTRIES') !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_ar',trans('lang.categoryNameAr')) !!}
                            {!! Form::text('name_ar',null,['class'=>'form-control']) !!}
                            <div id="name_ar_validate1" class="font-red"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_en',trans('lang.categoryNameEn')) !!}
                            {!! Form::text('name_en',null,['class'=>'form-control']) !!}
                            <div id="name_en_validate1" class="font-red"></div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
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
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
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
            $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{!! route('category.get','SUBCATEGORY') !!}",
                    "data": {method: 'get', categoryID: "{{ $categoryID }}", '_token': "{{ csrf_token() }}"}
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
                            return '<div class="dropdown">' +
                                '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                '<li>' +
                                '<a class="edit_category">@lang('lang.editCategory')</a>' +
                                '<input type="hidden" id="s_name_ar" value="' + row['s_name_ar'] + '">' +
                                '<input type="hidden" id="s_name_en" value="' + row['s_name_en'] + '">' +
                                '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                '<input type="hidden" id="dt_status" value="' + row['b_enabled'] + '">' +
                                '</li>' +
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
        $('body').on('click', '.edit_category', function () {
            var pk_i_id = $(this).siblings('#pk_i_id').val();
            var s_name_ar = $(this).siblings('#s_name_ar').val();
            var s_name_en = $(this).siblings('#s_name_en').val();
            var status = $(this).siblings('#dt_status').val();
            $('#categoryNameAr').val(s_name_ar);
            $('#categoryNameEn').val(s_name_en);
            $('#c_pk_i_id').val(pk_i_id);
            $('#category_status').val(status);
            $('#category_status').select2();
            $('#showCategory').modal('show');
        });
    </script>
    <script>
        $('body').on('click', '#addCategory', function () {
            $('#addCategoryModal').modal('show');
            $('#categoryStatus').val(1);
            $('#categoryStatus').select2();
        });
        $('#addCategoryForm').validate({
            rules: {
                name_ar: "required",
                name_en: "required",
                c_status: "required"
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
                @else
                name_ar: "category (Arabic) field is required",
                name_en: "category field is required",
                c_status: "status field is required"
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
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
                form.submit();
            }
        });
    </script>
@endsection