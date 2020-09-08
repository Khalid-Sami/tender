@extends('_layout')
@section('style')

@endsection
@section('title')
    {{trans('lang.providers')}}
{{--    <a href="{{route("admin.create.account")}}" class="btn btn-success pull-right"><i class="icon-plus"></i> @lang("lang.add_new_user")</a>--}}
@endsection

@section('head_title')
    {{trans('lang.providers')}}
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



    {{--@if(isset($data) && !$data->isEmpty())--}}
    {{--{!! Form::open(['method' => 'get','action' => ['ClinicController@showUsers']]) !!}--}}
    <div class="row">
        {!! Form::hidden('method','get') !!}
        {{--{!! Form::hidden('clinic_id',$clinic_id) !!}--}}
        {{--<div class="form-group col-sm-3">--}}
            {{--{!! Form::label('role',trans('lang.role')) !!}--}}
            {{--{!! Form::select('role',$user_role,isset($r)?$r:'',['class'=>'form-control select','id' => 'role']) !!}--}}
        {{--</div>--}}
        <?php
        $status;
        if (app()->getLocale() == 'en') {
            $status = array('' => 'Choose Option', '1' => 'enable', '0' => 'disable');
        } else {
            $status = array('' => 'اختار من القائمة', '1' => 'فعال', '0' => 'غير فعال');
        }

        ?>
        <div class="col-md-12">
            <div class="form-group col-md-6">
                {!! Form::label('status',trans('lang.status')) !!}
                {!! Form::select('status',$status,null,['class'=>'form-control select','id' => 'status']) !!}
{{--                {!! Form::select('status',isset($status)?$status:[],null,['class'=>'form-control select','id' => 'status']) !!}--}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group col-md-3 CategoriesSelect">
                {!! Form::label('category',trans('lang.category')) !!}
                <select name="subCategory[]" id="superCategory" class="form-control categories">
                    <option value="">@lang('lang.selectCategory')</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->pk_i_id }}">{{ $category->s_name }}</option>
                    @endforeach
                </select>
{{--                {!! Form::select('superCategory',isset($categories)?$categories:[],null,['class'=>'form-control select','id' => 'superCategory']) !!}--}}
            </div>
            <div class="form-group col-md-3 CategoriesSelect">
                {!! Form::label('subCategory',trans('lang.subCategories')) !!} \ <cite class="superCategory"></cite>
                <select name="subCategory[]" id="subCategory1" class="form-control categories">
                    <option value="">@lang('lang.selectCategory')</option>
                </select>
{{--                {!! Form::select('subCategory',isset($categories)?$categories:[],null,['class'=>'form-control select','id' => 'subCategory1']) !!}--}}
            </div>
            <div class="form-group col-md-3 CategoriesSelect">
                {!! Form::label('subCategory',trans('lang.subCategories')) !!} \ <cite class="superCategory"></cite>
                <select name="subCategory[]" id="subCategory2" class="form-control categories">
                    <option value="">@lang('lang.selectCategory')</option>
                </select>
{{--                {!! Form::select('subCategory',isset($categories)?$categories:[],null,['class'=>'form-control select','id' => 'subCategory2']) !!}--}}
            </div>
            <div class="form-group col-md-3 CategoriesSelect">
                {!! Form::label('subCategory',trans('lang.subCategories')) !!} \ <cite class="superCategory"></cite>
                <select name="subCategory[]" id="subCategory3" class="form-control categories">
                    <option value="">@lang('lang.selectCategory')</option>
                </select>
{{--                {!! Form::select('subCategory',isset($categories)?$categories:[],null,['class'=>'form-control select','id' => 'subCategory3']) !!}--}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group col-md-3">
                {!! Form::input('button',null,trans('lang.search'), ['class' => 'btn green','style'=>'margin-top:24px;','id' => 'search']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {{--<table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">--}}
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.company_name')</th>
                    <th>@lang('lang.email')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.Certified')</th>
                    <th>@lang('lang.options')</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>


    <div id="userJobModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div><!-- /.modal-content -->
            {{--{!! Form::close() !!}--}}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('scripts')

    <script>

        $('body').on('change', '.categories', function () {
            var thisSelect = $(this).closest('.CategoriesSelect').next('.CategoriesSelect').find('select').attr('id');
            var text = $(this).find("option:selected").text();
            var status = false;
            if($(this).attr('id') != 'subCategory3'){
                $(this).closest('.CategoriesSelect').nextAll('.CategoriesSelect').each(function () {
                    $(this).find('.superCategory').empty();
                    $(this).find('select option').not(':first').remove();
                });
            }
            else{
                status = true;
            }
            if($(this).val() && !status){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/' + $(this).val() + '/getSubCategories',
                    data:{
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('#'+thisSelect).closest('.CategoriesSelect').find('.superCategory').html(text);
                        if (data.status){
                            $.each(data.subCategories, function (i, item) {
                                $('#'+thisSelect).append($("<option></option>").attr("value",item.pk_i_id).text(item.s_name));
                            });
                        }
                    }
                })
            }
        });

        var table;
        $(document).ready(function () {

            $('.categories').select2()

            var BASE_URL = "{!! url('/') !!}";
            var lang = {
                sLengthMenu: "عرض _MENU_ من العناصر",
                sSearch: "ابحث هنا",
                sEmptyTable: "لا يوجد عناصر مضافة حاليا",
                sInfo: "عرض _START_ الى _END_ من _TOTAL_ العناصر",
                sInfoEmpty: "لا يوجد عناصر",
                sInfoFiltered: "(من العدد الكلي)",
                sInfoPostFix: "",
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
                var values = [];
                $("select[name='subCategory[]']").each(function() {
                    if($(this).val() != "")
                        values.push($(this).val());
                });

                var status = $('#status').val();
                var categoryID = $('#category').val();
                table = $('#myTable').DataTable({
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('table.get','showCompanies') }}",
                        "data": {method: 'get', status: status, categoryIDS: values, '_token': "{{ csrf_token() }}"}
                    },
                    "columns": [
                        {
                            mRender: function (data, type, row, full) {
                                return full['row']+1;
                            }
                        },
                        {
                            mRender: function (data, type, row) {
                                if ('{{app()->getLocale()}}' == 'en') {
                                    return '<a href="' + BASE_URL + '/provider/accountSetting/' + row['pk_i_id'] + '/getProvider">' + row['s_name_en'] + '</a>';
                                }
                                else{
                                    return '<a href="' + BASE_URL + '/provider/accountSetting/' + row['pk_i_id'] + '/getProvider">' + row['s_name_ar'] + '</a>';
                                }
                            }
                        },
//                    {data: 's_email', name: 's_email', defaultContent: ""},
//                    {data: 'enabled.s_name', name: 'enabled.s_name', defaultContent: ""},
                        {data: 's_email', name: 's_email', defaultContent: ""},
                        {
                            mRender: function (data, type, row) {
                                var state;
                                if (row['b_enabled'] == 2) {
                                    if ('{{app()->getLocale()}}' == 'en') {
                                        state = 'enable';
                                    } else {
                                        state = ' فعال';
                                    }
                                } else if(row['b_enabled'] == 1) {
                                    if ('{{app()->getLocale()}}' == 'en') {
                                        state = 'Pending management approval';
                                    } else {
                                        state = 'بانتظار موافقة الادارة';
                                    }
                                }
                                else if(row['b_enabled'] == 0) {
                                    if ('{{app()->getLocale()}}' == 'en') {
                                        state = 'Suspended';
                                    } else {
                                        state = 'موقوف';
                                    }
                                }
                                else if(row['b_enabled'] == 3) {
                                    if ('{{app()->getLocale()}}' == 'en') {
                                        state = 'Not enabled by email';
                                    } else {
                                        state = 'غير فعال بواسطة البريد الالكتروني';
                                    }
                                }
                                return state;
                            }
                        },
                        {
                            mRender: function (data, type, row) {
                                if(row['i_status'] == 20)
                                    return '{{ trans('lang.ok') }}'

                                else
                                    return '{{ trans('lang.no') }}'
                            }
                        },
                        {
                            mRender: function (data, type, row) {
                                var li;
                                var li1 = '<li><a target="_blank" id="changeState" data-val="0" data-id="' + row['pk_i_id'] + '" class="48">@lang('lang.pause')</a></li>';
                                var li2 = '<li><a target="_blank" id="changeState"  data-val="1" data-id="' + row['pk_i_id'] + '" class="48">@lang('lang.pause')</a></li>';
                                var li3 = '<li><a target="_blank" id="changeState"  data-val="2" data-id="' + row['pk_i_id'] + '" class="'+47+'">@lang('lang.enable')</a></li>';
                                {{--var liQuotation = "";--}}
                                        {{--var quotationLi = '<li>' +--}}
                                        {{--'<a href="' + BASE_URL + '/admin/quotations/' + row['pk_i_id'] + '/show">@lang('lang.quotation')</a>' +--}}
                                        {{--'<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +--}}
                                        {{--'<input type="hidden" id="user_type" value="' + row['fk_i_role_id'] + '">' +--}}
                                        {{--'<input type="hidden" id="user_name" value="' + row['s_first_name'] + ' ' + row['s_last_name'] + '">' +--}}
                                        {{--'</li>';--}}
                                if (row['b_enabled'] == 1) {
                                    li = li3;
                                }
                                if (row['b_enabled'] == 0) {
                                    li = li3;
                                }
                                if (row['b_enabled'] == 2) {
                                    li = li1;
                                }
                                if (row['b_enabled'] == 3) {
                                    li = li3;
                                }


//                            if (row['status'] ['s_name_en'] == 'ServiceProviderAdmin') {
//                                liQuotation = quotationLi;
//                            }
                                return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a target="_blank"href="' + BASE_URL + '/provider/accountSetting/' + row['pk_i_id'] + '/getProvider">@lang('lang.service_provider_profile')</a>' +
                                    '</li>' +
                                    li +
                                        {{--'<li>' +--}}
                                                {{--'<a target="_blank" href="' + BASE_URL + '/admin/user/' + row['pk_i_id'] + '/showUserPermission">@lang('lang.user_permission')</a>' +--}}
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

//            var i = 1;
            var status = $('#status').val();
            table = $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','showCompanies') }}",
                    "data": {method: 'get', status: status, '_token': "{{ csrf_token() }}"}
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row']+1;
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            if ('{{app()->getLocale()}}' == 'en') {
                                return '<a href="' + BASE_URL + '/provider/accountSetting/' + row['pk_i_id'] + '/getProvider">' + row['s_name_en'] + '</a>';
                            }
                            else{
                                return '<a href="' + BASE_URL + '/provider/accountSetting/' + row['pk_i_id'] + '/getProvider">' + row['s_name_ar'] + '</a>';
                            }
                            }
                    },
//                    {data: 's_email', name: 's_email', defaultContent: ""},
//                    {data: 'enabled.s_name', name: 'enabled.s_name', defaultContent: ""},
                    {data: 's_email', name: 's_email', defaultContent: ""},
                    {
                        mRender: function (data, type, row) {
                            var state;
                            if (row['b_enabled'] == 2) {
                                if ('{{app()->getLocale()}}' == 'en') {
                                    state = 'enable';
                                } else {
                                    state = ' فعال';
                                }
                            } else if(row['b_enabled'] == 1) {
                                if ('{{app()->getLocale()}}' == 'en') {
                                    state = 'Pending management approval';
                                } else {
                                    state = 'بانتظار موافقة الادارة';
                                }
                            }
                            else if(row['b_enabled'] == 0) {
                                if ('{{app()->getLocale()}}' == 'en') {
                                    state = 'Suspended';
                                } else {
                                    state = 'موقوف';
                                }
                            }
                            else if(row['b_enabled'] == 3) {
                                if ('{{app()->getLocale()}}' == 'en') {
                                    state = 'Not enabled by email';
                                } else {
                                    state = 'غير فعال بواسطة البريد الالكتروني';
                                }
                            }
                            return state;
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            if(row['i_status'] == 20)
                                return '{{ trans('lang.yes') }}'

                            else
                                return '{{ trans('lang.no') }}'
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            var li;
                            var li1 = '<li><a target="_blank" id="changeState" data-val="0" data-id="' + row['pk_i_id'] + '" class="48">@lang('lang.pause')</a></li>';
                            var li2 = '<li><a target="_blank" id="changeState"  data-val="1" data-id="' + row['pk_i_id'] + '" class="48">@lang('lang.pause')</a></li>';
                            var li3 = '<li><a target="_blank" id="changeState"  data-val="2" data-id="' + row['pk_i_id'] + '" class="'+47+'">@lang('lang.enable')</a></li>';
                            {{--var liQuotation = "";--}}
                            {{--var quotationLi = '<li>' +--}}
                                {{--'<a href="' + BASE_URL + '/admin/quotations/' + row['pk_i_id'] + '/show">@lang('lang.quotation')</a>' +--}}
                                {{--'<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +--}}
                                {{--'<input type="hidden" id="user_type" value="' + row['fk_i_role_id'] + '">' +--}}
                                {{--'<input type="hidden" id="user_name" value="' + row['s_first_name'] + ' ' + row['s_last_name'] + '">' +--}}
                                {{--'</li>';--}}
                            if (row['b_enabled'] == 1) {
                                li = li3;
                            }
                            if (row['b_enabled'] == 0) {
                                li = li3;
                            }
                            if (row['b_enabled'] == 2) {
                                li = li1;
                            }
                            if (row['b_enabled'] == 3) {
                                li = li3;
                            }


//                            if (row['status'] ['s_name_en'] == 'ServiceProviderAdmin') {
//                                liQuotation = quotationLi;
//                            }
                            return '<div class="dropdown">' +
                                '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                '<li>' +
                                '<a target="_blank"href="' + BASE_URL + '/provider/accountSetting/' + row['pk_i_id'] + '/getProvider">@lang('lang.service_provider_profile')</a>' +
                                '</li>' +
                                li +
                                {{--'<li>' +--}}
                                {{--'<a target="_blank" href="' + BASE_URL + '/admin/user/' + row['pk_i_id'] + '/showUserPermission">@lang('lang.user_permission')</a>' +--}}
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

$('body').on('click', '#changeState', function () {
    var user_id = $(this).data("id");
    var status = $(this).data("val");
    var stID = parseInt($(this).attr('class'));
//    alert($(this).attr('class'));
    swal({
            title: "{{ trans('lang.sure') }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{ trans('lang.yes_change') }}",
            cancelButtonText: "{{ trans('lang.cancel') }}",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function () {
            $.ajax({
                method: "POST",
                dataType: "json",
                url: '{{url('/')}}/admin/' + user_id + '/changeCompanyStatus',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status,
                    'stID': stID
                },
                success: function (data, textStatus, jqXHR) {
                    if (data.status) {
                        swal("{{trans('lang.success')}}", "{{trans('lang.status_change')}}", "success");
                        table.ajax.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });

        });

});
    </script>
@endsection