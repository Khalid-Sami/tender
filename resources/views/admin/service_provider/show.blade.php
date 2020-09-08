@extends('_layout')
@section('head_title')
    {{trans('lang.company')}}
@endsection
@section('title')
    {!!  trans('lang.company')!!}
@endsection
@section('msg')
    <div id="alert_message" class="alert alert-danger alert-dismissible hidden text-center"
         style=" position: absolute;width: 100%;z-index: 1;">
        <a href="#" id="close_msg" class="close">&times;</a>
        <p id="message"></p>
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

    <div class="col-sm-12">
        {!! Form::open(['id' =>'sendData','method'=>'get','action' =>['MainController@getTableData','getCompany']]) !!}

        <div class="row">

            <div class="form-group col-sm-3">
                {!! Form::label('company',trans('lang.company')) !!}
                {!! Form::text('company',null,['class' =>'form-control','id'=>'CompanyForm']) !!}
            </div>

            {{--<div class="form-group col-sm-3">--}}
            {{--{!! Form::label('status',trans('lang.status')) !!}--}}
            {{--{!! Form::select('status',$status,null,['class' =>'form-control select','id'=>'statusForm']) !!}--}}
            {{--</div>--}}

            <button type="button" style="margin-top:24px" class="btn green" id="getDataTable">@lang('lang.search') <span
                        id="btnSpin" class="fa fa-spinner fa-spin hidden"></span></button>
        </div>
        {!! Form::close() !!}
    </div>
    {{--@if(isset($data))--}}
    <div class="row">
        <a href="{{url("/")}}/admin/company/add" class="btn btn-success pull-right"><i class="icon-plus"></i> @lang("lang.add_new_company")</a>
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.company')</th>
                    <th>@lang('lang.telephone_number')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.mobile_number')</th>
                    <th>@lang('lang.email')</th>
                    <th>@lang('lang.options')</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    {{--@endif--}}


    <div id="updateSubscriptionPackageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id' => 'updateSubscriptionPackageForm','method' =>'post','action' => 'AdminController@changeSubscriptionPackage']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.store_subscription_package')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('pk_i_id',null,['id' => 'pk_i_id_m']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('clinic',trans('lang.company')) !!} <span
                                    class="required" aria-required="true"> * </span>
                            {!! Form::text('provider',null,['class' => 'form-control','readonly','id' => 'provider_m']) !!}

                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('subscription',trans('lang.store_subscription_package')) !!} <span
                                    class="required" aria-required="true"> * </span>
                            {!! Form::select('subscription',isset($subscription_package)?$subscription_package:[],null,['class' => 'form-control select','id'=>'subscription_id_m']) !!}

                            <div id="subscription_validate" class="font-red"></div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}"
                            data-dismiss="modal">{{ trans('lang.cancel') }}</button>
                    <button id="addCompanyModal" type="submit" class="btn btn-primary">{{ trans('lang.save') }} <span
                                id="addCategorySpinner" class="fa fa-spin fa-spinner hidden"></span></button>

                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection
@section('scripts')
    <script>
        $('body').on('click', "#close_msg", function () {
            $('#alert_message').addClass('hidden');
            $('#btnSpin').addClass('hidden');
        });
        $('body').on('click', '.changeSubscription', function () {
            var pk_i_id = $(this).siblings('#pk_i_id').val();
            var provider = $(this).siblings('#provider').val();
            var fk_i_subscription_package_id = $(this).siblings('#fk_i_subscription_package_id').val();

            $('#pk_i_id_m').val(pk_i_id);
            $('#provider_m').val(provider);
            if (fk_i_subscription_package_id == null) {
                $('#subscription_id_m').val(0);
                $('#subscription_id_m').select2();
            } else {
                $('#subscription_id_m').val(fk_i_subscription_package_id);
                $('#subscription_id_m').select2();
            }


            $('#updateSubscriptionPackageModal').modal('show');
        });

        $('#updateSubscriptionPackageForm').validate({
            rules: {
                subscription: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() == 'en')
                subscription: "subscription package is required field",
                @else
                subscription: "خطة الاشتراك حقل مطلوب",
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
    <script>
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
            $('body').on('click', '#getDataTable', function () {
                var i = 1;
                var CompanyForm = $('#CompanyForm').val();
                var status = "";
                if (CompanyForm != "" && CompanyForm != null || status.length != "") {
                    $('#alert_message').addClass('hidden');
                    $('#myTable').DataTable({
                        "destroy": true,
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "{{ route('table.get','getCompany') }}",
                            "data": {company: CompanyForm, status: status, defaultContent: ""}

                        },
                        "columns": [
                            {
                                mRender: function (data, type, row, full) {
                                    return full['row'] + 1;
                                }
                            },
                            {data: 's_name', name: 's_name', defaultContent: ""},
                            {data: 's_telephone_number', name: 's_telephone_number', defaultContent: ""},
                            {data: 'status.s_name', name: 'status.s_name', defaultContent: ""},
                            {data: 's_mobile_number', name: 's_mobile_number', defaultContent: ""},
                            {data: 's_email', name: 's_email', defaultContent: ""},
                            {
                                mRender: function (data, type, row) {

                                    return '<div class="dropdown">' +
                                            '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                            '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                            '<li>' +
                                            '<a target="_blank" href="' + BASE_URL + '/admin/' + row['pk_i_id'] + '/users">@lang('lang.users')</a>' +
                                            '</li>' +
                                            ' <li>' +
                                            '<a target="_blank" href="' + BASE_URL + '/admin/serviceProvider/' + row['pk_i_id'] + '/getProfile">@lang('lang.profile')</a>' +
                                            '</li>' +
                                            {{--'<li>' +--}}
                                                    {{--'<a target="_blank" href="' + BASE_URL + '/admin/' + row['pk_i_id'] + '/reservation">@lang('lang.requests')</a>' +--}}
                                                    {{--'</li>' +--}}
                                                    '<li>' +

                                            '<a class="changeSubscription">@lang('lang.store_subscription_package')</a>' +
                                            '<input type="hidden" id="fk_i_subscription_package_id" value="' + row['fk_i_subscription_package_id'] + '">' +
                                            '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                            '<input type="hidden" id="provider" value="' + row['s_name'] + '">' +
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
                } else {
                    var message;
                    if ('{!! app()->getLocale() !!}' == 'en') {
                        message = 'you must select one value at least';
                    } else {
                        message = 'يجب ان تختار قيمة واحدة على الاقل';
                    }
                    $('#message').html(message);
                    $('#alert_message').removeClass('hidden');
                    $('#btnSpin').addClass('hidden');
                }
            });
            var i = 1;
            var status = "";
            $('#alert_message').addClass('hidden');
            $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','getCompany') }}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 's_name', name: 's_name', defaultContent: ""},
                    {data: 's_telephone_number', name: 's_telephone_number', defaultContent: ""},
                    {data: 'status.s_name', name: 'status.s_name', defaultContent: ""},
                    {data: 's_mobile_number', name: 's_mobile_number', defaultContent: ""},
                    {data: 's_email', name: 's_email', defaultContent: ""},
                    {
                        mRender: function (data, type, row) {

                            return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a target="_blank" href="' + BASE_URL + '/admin/' + row['pk_i_id'] + '/users">@lang('lang.users')</a>' +
                                    '</li>' +
                                    ' <li>' +
                                    '<a target="_blank" href="' + BASE_URL + '/admin/serviceProvider/' + row['pk_i_id'] + '/getProfile">@lang('lang.profile')</a>' +
                                    '</li>' +
                                    {{--'<li>' +--}}
                                            {{--'<a target="_blank" href="' + BASE_URL + '/admin/' + row['pk_i_id'] + '/reservation">@lang('lang.requests')</a>' +--}}
                                            {{--'</li>' +--}}
                                            '<li>' +

                                    '<a class="changeSubscription">@lang('lang.store_subscription_package')</a>' +
                                    '<input type="hidden" id="fk_i_subscription_package_id" value="' + row['fk_i_subscription_package_id'] + '">' +
                                    '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                    '<input type="hidden" id="provider" value="' + row['s_name'] + '">' +
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


@endsection