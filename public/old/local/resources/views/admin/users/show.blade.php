@extends('_layout')
@section('style')

@endsection
@section('title')
    {{trans('lang.users')}}
@endsection

@section('head_title')
    {{trans('lang.users')}}
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
        <div class="form-group col-sm-3">
            {!! Form::label('role',trans('lang.role')) !!}
            {!! Form::select('role',$user_role,isset($r)?$r:'',['class'=>'form-control select','id' => 'role']) !!}
        </div>
        <div class="form-group col-sm-3">
            {!! Form::label('status',trans('lang.status')) !!}
            {!! Form::select('status',isset($status)?$status:[],null,['class'=>'form-control select','id' => 'status']) !!}
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
                    <th>@lang('lang.user_name')</th>
                    <th>@lang('lang.gender')</th>
                    <th>@lang('lang.birth_date')</th>
                    <th>@lang('lang.mobile_number')</th>
                    <th>@lang('lang.role')</th>
                    <th>@lang('lang.email')</th>
                    <th>@lang('lang.status')</th>
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
            {{--{!! Form::open(['id' => 'userJobForm','action' =>'ClinicController@storePermissions', 'method' => 'post']) !!}--}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.user_job')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('pk_i_id',null,['id' => 'pk_i_id_m']) !!}
                        <div class="form-group col-sm-5">
                            {!! Form::label('user_name',trans('lang.user_name')) !!}
                            {!! Form::text('user_name',null,['class' => 'form-control','id' => 'user_name_m','disabled']) !!}
                            <div class="font-red" id="user_name_validate"></div>
                        </div>

                        <div class="form-group col-sm-5">
                            {!! Form::label('user_type',trans('lang.user_type')) !!}
                            {!! Form::select('user_type',isset($status)?$status:[],null,['class' => 'form-control select','id' => 'user_type_m']) !!}
                            <div class="font-red" id="user_type_validate"></div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}"
                            data-dismiss="modal">{{trans('lang.cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('lang.save') }}</button>
                </div>
            </div><!-- /.modal-content -->
            {{--{!! Form::close() !!}--}}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('scripts')

    <script>
        var table;
        $(document).ready(function () {
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
                var i = 1;
                var status = $('#status').val();
                var role = $('#role').val();
                table = $('#myTable').DataTable({
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('table.get','showUsers') }}",
                        "data": {role: role, status: status}
                    },
                    "columns": [
                        {
                            mRender: function (data, type, row) {
                                return i++;
                            }
                        },
                        {
                            mRender: function (data, type, row) {
                                return '<a href="' + BASE_URL + '/user/accountSetting/' + row['pk_i_id'] + '/getUser">' + row['s_first_name'] + ' ' + row['s_last_name'] + '</a>';
                            }
                        },
                        {data: 'gender.s_name', name: 'gender.s_name', defaultContent: ""},
                        {data: 'dt_birth_date', name: 'dt_birth_date', defaultContent: ""},
                        {data: 's_mobile_number', name: 's_mobile_number', defaultContent: ""},
                        {data: 'user_rule.s_name', name: 'userRule.s_name', defaultContent: ""},
                        {data: 's_email', name: 's_email', defaultContent: ""},
                        {
                            mRender: function (data, type, row) {
                                var state;
                                if (row['b_enabled'] == 1) {
                                    if ('{{app()->getLocale()}}' == 'en') {
                                        state = 'enable';
                                    } else {
                                        state = ' فعال';
                                    }
                                } else {
                                    if ('{{app()->getLocale()}}' == 'en') {
                                        state = 'disable';
                                    } else {
                                        state = 'غير فعال';
                                    }
                                }
                                return state;
                            }
                        },

                        {
                            mRender: function (data, type, row) {
                                var li;
                                var li1 = '<li><a target="_blank" id="changeState" data-val="0" data-id="' + row['pk_i_id'] + '">@lang('lang.pause')</a></li>';
                                var li2 = '<li><a target="_blank" id="changeState" data-val="1" data-id="' + row['pk_i_id'] + '">@lang('lang.enable')</a></li>';
                                if (row['b_enabled'] == 1) {
                                    li = li1;
                                }
                                if (row['b_enabled'] == 0) {
                                    li = li2;
                                }
                                return '<div class="dropdown">' +
                                        '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                        '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                        '<li>' +
                                        '<a target="_blank"href="' + BASE_URL + '/user/accountSetting/' + row['pk_i_id'] + '/getUser">@lang('lang.profile')</a>' +
                                        '</li>' +
                                        li +
                                        '<li>' +
                                        '<a target="_blank" href="' + BASE_URL + '/admin/user/' + row['pk_i_id'] + '/showUserPermission">@lang('lang.user_permission')</a>' +
                                        '</li>' +
                                        '<li>' +
                                        '<a class="showUserJob">@lang('lang.user_job')</a>' +
                                        '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                        '<input type="hidden" id="user_type" value="' + row['fk_i_role_id'] + '">' +
                                        '<input type="hidden" id="user_name" value="' + row['s_first_name'] + ' ' + row['s_last_name'] + '">' +
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

            });
            var i = 1;
            var status = $('#status').val();
            var role = $('#role').val();
            table = $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','showUsers') }}",
                    "data": {method: 'get', role: role, status: status, '_token': "{{ csrf_token() }}"}
                },
                "columns": [
                    {
                        mRender: function (data, type, row) {
                            return i++;
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            return '<a href="' + BASE_URL + '/user/accountSetting/' + row['pk_i_id'] + '/getUser">' + row['s_first_name'] + ' ' + row['s_last_name'] + '</a>';
                        }
                    },
                    {data: 'gender.s_name', name: 'gender.s_name', defaultContent: ""},
                    {data: 'dt_birth_date', name: 'dt_birth_date', defaultContent: ""},
                    {data: 's_mobile_number', name: 's_mobile_number', defaultContent: ""},
                    {data: 'user_rule.s_name', name: 'userRule.s_name', defaultContent: ""},
                    {data: 's_email', name: 's_email', defaultContent: ""},
                    {
                        mRender: function (data, type, row) {
                            var state;
                            if (row['b_enabled'] == 1) {
                                if ('{{app()->getLocale()}}' == 'en') {
                                    state = 'enable';
                                } else {
                                    state = ' فعال';
                                }
                            } else {
                                if ('{{app()->getLocale()}}' == 'en') {
                                    state = 'disable';
                                } else {
                                    state = 'غير فعال';
                                }
                            }
                            return state;
                        }
                    },

                    {
                        mRender: function (data, type, row) {
                            var li;
                            var li1 = '<li><a target="_blank" id="changeState" data-val="0" data-id="' + row['pk_i_id'] + '">@lang('lang.pause')</a></li>';
                            var li2 = '<li><a target="_blank" id="changeState"  data-val="1" data-id="' + row['pk_i_id'] + '">@lang('lang.enable')</a></li>';
                            if (row['b_enabled'] == 1) {
                                li = li1;
                            }
                            if (row['b_enabled'] == 0) {
                                li = li2;
                            }
                            return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a target="_blank"href="' + BASE_URL + '/user/accountSetting/' + row['pk_i_id'] + '/getUser">@lang('lang.profile')</a>' +
                                    '</li>' +
                                    li +
                                    '<li>' +
                                    '<a target="_blank" href="' + BASE_URL + '/admin/user/' + row['pk_i_id'] + '/showUserPermission">@lang('lang.user_permission')</a>' +
                                    '</li>' +
                                    '<li>' +
                                    '<a class="showUserJob">@lang('lang.user_job')</a>' +
                                    '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                    '<input type="hidden" id="user_type" value="' + row['fk_i_role_id'] + '">' +
                                    '<input type="hidden" id="user_name" value="' + row['s_first_name'] + ' ' + row['s_last_name'] + '">' +
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


        $('body').on('click', '#changeState', function () {
            var user_id = $(this).data("id");
            var status = $(this).data("val");
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
                            url: '{{url('/')}}/admin/' + user_id + '/changeStatus',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "status": status
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


    <script>
        $('body').on('click', '.showUserJob', function () {
            var name = $(this).siblings('#user_name').val();
            var type = $(this).siblings('#user_type').val();
            var pk_i_id = $(this).siblings('#pk_i_id').val();
            $('#user_name_m').val(name);
            $('#pk_i_id_m').val(pk_i_id);
            $('#user_type_m').val(type);
            $('#user_type_m').select2();
            $('#userJobModal').modal('show');
        });

        $('#userJobForm').validate({
            rules: {
                user_type: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() == 'en')
                user_type: "user type field is required",
                @else
                user_type: " نوع المستخدم حقل مطلوب",

                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
@endsection