@extends('_layout')

@section('head_title')
{{trans('lang.notifications')}}
@endsection
@section('title')
{!!  trans('lang.notifications')!!}
@endsection
@section('content')

        <!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase"></span>
                    </div>
                    <ul class="nav nav-tabs">
                        @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state'))
                            <li class="active">
                                <a href="#tab_1_1" data-toggle="tab">@lang('lang.receive_notifications')</a>
                            </li>
                        @else
                            <li class="{{session('tab1_state')?session('tab1_state'):''}}">
                                <a href="#tab_1_1" data-toggle="tab">@lang('lang.receive_notifications')</a>
                            </li>
                        @endif

                        <li class="{{session('tab2_state')?session('tab2_state'):''}}">
                            <a href="#tab_1_2" data-toggle="tab">@lang('lang.send_notifications')</a>
                        </li>

                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- PERSONAL INFO TAB -->
                        @if(!session('tab1_state') && !session('tab2_state') && !session('tab3_state') && !session('tab4_state') )
                            <div class="tab-pane active" id="tab_1_1">
                                @else
                                    <div class="tab-pane {{session('tab1_state')?session('tab1_state'):''}}"
                                         id="tab_1_1">
                                        @endif

                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered table-hover myTable1" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>@lang('lang.notifications')</th>
                                                    <th>@lang('lang.since')</th>

                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                    <!-- CHANGE AVATAR TAB -->
                                    <div class="tab-pane {{session('tab2_state')?session('tab2_state'):''}}"
                                         id="tab_1_2">

                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered table-hover myTable2" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>@lang('lang.notifications')</th>
                                                    <th>@lang('lang.since')</th>

                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- END CHANGE AVATAR TAB -->


                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="myData">
    <!-- END PROFILE CONTENT -->
</div>


@endsection
@section('scripts')
    <script>
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd'
        });
    </script>


    <script>

        $(document).ready(function () {
            var data1;
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
            $('.myTable1').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','NotificationView') }}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            if (row['s_title'] == null) {
                                return row['title'];
                            } else {
                                return row['s_title'];
                            }

                        }
                    },
                    {data: 'dt_created_date', name: 'dt_created_date',defaultContent:""}

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
            {{--$('.myTable2').DataTable({--}}

                {{--"processing": true,--}}
                {{--"serverSide": true,--}}
                {{--"ajax": "{{ route('table.get','SendNotificationView') }}",--}}

                {{--"columns": [--}}
                    {{--{--}}
                        {{--mRender: function (data, type, row, full) {--}}
                            {{--if (row['s_title'] == null) {--}}
                                {{--return row['title'];--}}
                            {{--} else {--}}
                                {{--return row['s_title'];--}}
                            {{--}--}}

                        {{--}--}}
                    {{--},--}}

                    {{--{data: 'dt_created_date', name: 'dt_created_date',defaultContent:""}--}}
                {{--],--}}
                {{--dom: 'Bfrtip',--}}
                {{--buttons: [--}}
                    {{--{--}}
                        {{--text: '',--}}
                        {{--className: 'hidden'--}}
                    {{--}--}}

                {{--],--}}
                {{--"bLengthChange": true,--}}
                {{--"bFilter": true,--}}
                {{--"pageLength": 10,--}}
                {{--@if(app()->getLocale() == 'ar')--}}
                {{--language: lang--}}
                {{--@endif--}}
            {{--});--}}
            @if(app()->getLocale() == 'ar')
             $('.prev').children().children().removeClass('fa fa-angle-left');
            $('.prev').children().children().addClass('fa fa-angle-right');
            $('.next').children().children().removeClass('fa fa-angle-right');
            $('.next').children().children().addClass('fa fa-angle-left');
            @endif
        });
    </script>


@endsection