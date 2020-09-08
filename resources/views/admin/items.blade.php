@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.managementItems')}}
@endsection
@section('title')
    {{trans('lang.managementItems')}}
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
            <a href="{{action('AdminController@newItem')}}" class="btn green col-sm-2 col-sm-offset-10"><span class="fa fa-plus"></span> @lang('lang.newItems')</a>
        </div>
    </div>

    <form id="searchForm" method="get">
    <div class="row allSelectCategories">
        {{--{!! Form::model(['id' => 'searchForm','method' => 'get']) !!}--}}
        <div class="col-md-12 A" id="first">
            <div class="form-group col-md-3 selectCategoriesAdding">
                <label name="categoryTypeAdding">{{ trans('lang.categoryType') }}</label>
                <select name="superCategory" id="superCategory" class="select2 categories">
                    @if(app()->getLocale() == 'en')
                        <option value="0" selected>All</option>
                    @else
                        <option value="0" selected>الكل</option>
                    @endif
                    @foreach($categories as $category)
                        <option value="{{ $category->pk_i_id }}">{{ $category->s_name }}</option>
                    @endforeach
                </select>
                <div id="superCategory_validate" class="font-red"></div>
            </div>
            <div class="form-group col-md-3 selectCategoriesAdding">
                <label name="selectSubCategories">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                <select name="subCategoryTypeAdding1" id="subCategoryLevel1" class="select2 categories subCategories">
                    <option value="">{{ trans('lang.selectCategory') }}</option>
                </select>
                <div id="subCategoryLevel1_validate" class="font-red"></div>
            </div>
        </div>
        <div class="col-md-12 A" id="second">
            <div class="form-group col-md-3 selectCategoriesAdding">
                <label name="selectSubCategories">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                <select name="subCategoryTypeAdding2" id="subCategoryLevel2" class="select2 categories subSubCategories">
                    <option value="">{{ trans('lang.selectCategory') }}</option>
                </select>
                <div id="subCategoryLevel2_validate" class="font-red"></div>
            </div>
            <div class="form-group col-md-3 selectCategoriesAdding">
                <label name="selectSubCategories">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                <select name="subCategoryTypeAdding3" id="subCategoryLevel3" class="select2 categories subSubCategories">
                    <option value="">{{ trans('lang.selectCategory') }}</option>
                </select>
                <div id="subCategoryLevel3_validate" class="font-red"></div>
            </div>
            <div class="form-group col-md-3">
                {!! Form::input('button',null,trans('lang.search'), ['class' => 'btn green','style'=>'margin-top:24px;','id' => 'search']) !!}
            </div>
        </div>
        {{--</div>--}}
    </div>
    </form>


    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.item')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.category')</th>
                    <th>@lang('lang.options')</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
    <!-- /.modal -->
@endsection
@section('scripts')
    <script>
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $(document).ready(function () {
            var selectValue = 0
            $('#categoryStatus').val(1);

            $('.categories').select2({
                allowClear:true,
                {{--                placeholder: '{{ trans('lang.category') }}'--}}
            });

            $('body').on('change', '.categories', function() {
                selectValue = $(this).val();
                var categoryID = $(this).val();
                var thisSelect = $(this).closest('.selectCategoriesAdding').next('.selectCategoriesAdding').find('select').attr('id');
                if(thisSelect == undefined && $(this).attr('id') != 'subCategoryLevel3'){
                    thisSelect = $(this).closest('.A').next('.A').find('.selectCategoriesAdding:first-child').find('select').attr('id');
                }
                var text = $(this).find("option:selected").text();
                var status = false;
                if($(this).attr('id') != 'subCategoryLevel3'){
                    var type = $(this).closest('.A').attr('id');
                    $(this).closest('.selectCategoriesAdding').nextAll('.selectCategoriesAdding').each(function () {
                        $(this).find('.superCategory').empty();
                        $(this).find('select option').not(':first').remove();
                    });
                    if(type == 'first'){
                        $('#second').find('.selectCategoriesAdding').each(function () {
                            $(this).find('.superCategory').empty();
                            $(this).find('select option').not(':first').remove();
                        });
                    }
                }
                else{
                    status = true;
                }
                if($(this).val() != 0 && !status){
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
                                    $('#'+thisSelect).append($("<option></option>").attr("value",item.pk_i_id).text(item.s_name));
                                });

                            }
                        }
                    })
                }

            })

            $('#searchForm').validate({
                rules: {
                    subCategoryTypeAdding1: {
                        required: function () {
                            if($('#subCategoryLevel1 option').size() > 1){
                                return true;
                            }
                            return false;
                        }
                    },
                    subCategoryTypeAdding2: {
                        required: function () {
                            if($('#subCategoryLevel2 option').size() > 1){
                                return true;
                            }
                            return false;
                        }
                    },
                    subCategoryTypeAdding3: {
                        required: function () {
                            if($('#subCategoryLevel3 option').size() > 1){
                                return true;
                            }
                            return false;
                        }
                    }

                },
                errorPlacement: function (error, element) {
                    var id = $(element).attr("id");
                    error.appendTo($("#" + id + "_validate"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    subCategoryTypeAdding1: {
                        required: "التصنيف حقل مطلوب"
                    },
                    subCategoryTypeAdding2: {
                        required: "التصنيف حقل مطلوب"
                    },
                    subCategoryTypeAdding3: {
                        required: "التصنيف حقل مطلوب"
                    },
                    @else
                    subCategoryTypeAdding1: {
                        required: "Category field is required"
                    },
                    subCategoryTypeAdding2: {
                        required: "Category field is required"
                    },
                    subCategoryTypeAdding3: {
                        required: "Category field is required"
                    },
                    @endif
                }
                , submitHandler: function (form) {

                }
            });


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
                $("#searchForm").validate();
                if(!$('#searchForm').valid())
                    return
//                var selectedID = "";
//                if($('#subCategoryTypeAdding2').val() != ""){
//                    selectedID = $('#subCategoryTypeAdding2').val();
//                }
//                else if($('#subCategoryTypeAdding1').val() != ""){
//                    selectedID = $('#subCategoryTypeAdding1').val();
//                }
//                else {
//                    selectedID = $('#categoryTypeAdding1').val();
//                }
                $('#myTable').DataTable({
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": '{{url('/')}}/admin/' + selectValue + '/getAllItems'
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
                        {data: 'category.s_name', name: 'category.s_name',defaultContent:""},
                        {
                            mRender: function (data, type, row, full) {
                                return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a href="{{url('/')}}/admin/' + row['pk_i_id'] + '/item">@lang('lang.editItem')</a>' +
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
                    "url": "{!! route('items.get') !!}"
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
                    {data: 'category.s_name', name: 'category.s_name',defaultContent:""},
                    {
                        mRender: function (data, type, row, full) {
                            return '<div class="dropdown">' +
                                '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                '<li>' +
                                '<a href="{{url('/')}}/admin/' + row['pk_i_id'] + '/item">@lang('lang.editItem')</a>' +
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
@endsection