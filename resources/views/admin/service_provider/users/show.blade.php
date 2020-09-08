@extends('_layout')
@section('head_title')
    {{trans('lang.company')}}
@endsection
@section('title')
    <a href="{{action('AdminController@Company')}}">{!!trans('lang.users') !!}</a>{{" / "}}{{$name or ''}}
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

    {{--@if(isset($data))--}}
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.user_name')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.mobile_number')</th>
                    <th>@lang('lang.email')</th>
                    <th>@lang('lang.gender')</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    {{--@endif--}}


@endsection
@section('scripts')
    <script>
        $('body').on('click', '.changeSubscription', function () {
            var pk_i_id = $(this).siblings('#pk_i_id').val();
            var clinic = $(this).siblings('#clinic').val();
            var invoice_id = $(this).siblings('#invoice_id').val();

            $('#pk_i_id_m').val(pk_i_id);
            $('#clinic_m').val(clinic);
            $('#subscription_id_m').val(invoice_id);
            $('#subscription_id_m').select2();

            $('#updateSubscriptionPackageModal').modal('show');
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
            var i = 1;
            var clinic = $('#clinicForm').val();
            var city = $('#cityForm').val();
            var status = $('#statusForm').val();
            $('#alert_message').addClass('hidden');
            $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','getCompanyUsers') }}",
                    "data": {id: "{{$id}}"}

                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 'full_name', name: 'full_name',defaultContent:""},
                    {data: 'rule', name: 'rule',defaultContent:""},
                    {data: 'user.s_mobile_number', name: 'user.s_mobile_number',defaultContent:""},
                    {data: 'user.s_email', name: 'user.s_email',defaultContent:""},
                    {data: 'gender', name: 'gender',defaultContent:""}
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