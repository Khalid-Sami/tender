@extends('_layout')
@section('style')
    <style>
        .mainCategory{
            background-color:green;
        }

    </style>
@endsection
@section('head_title')
    {{trans('lang.reverseAuctions')}}
@endsection
@section('title')
    {{trans('lang.reverseAuctions')}}
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
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.auctionTitle')</th>
                    <th>@lang('lang.auctionStartDate')</th>
                    <th>@lang('lang.auctionEndDate')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.serviceProvider')</th>
                    <th>@lang('lang.options')</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var table;

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
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
            table = $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{!! action('AdminController@getReverseAuctions') !!}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 's_title', auctionTitle: 's_title',defaultContent:""},
                    {data: 'dt_open_date', startDate: 'dt_open_date',defaultContent:""},
                    {data: 'dt_close_date', endDate: 'dt_close_date',defaultContent:""},
                    {data: 'status.s_name', status: 'status.s_name',defaultContent:""},
                    {
                        mRender: function (data, type, row, full) {
                            if(row['accetpoffer'] != null)
                                return row['accetpoffer']['company']['s_name']
                            else
                                return '@lang('lang.undefined')'
                        }
                    },
                    {
                        mRender: function (data, type, row, full) {

                                {{--return '<div class="dropdown">' +--}}
                                {{--'<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +--}}
                                {{--'<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +--}}
                                {{--'<li>' +--}}
                                {{--'<a href="{{ url('') }}/admin/'+row["pk_i_id"]+'/reverseAuctionDetails">@lang('lang.edit')</a>' +--}}
                                {{--'</li>' +--}}
                                {{--'<li><a href="{{ url('/') }}/admin/tenderProposals/'+row["pk_i_id"]+'/pricesOffers">@lang('lang.pricesOffers')</a></li>'+--}}
                                {{--'</ul>' +--}}
                                {{--'</div>';--}}

                                return '<a href="{{ url('') }}/admin/'+row["pk_i_id"]+'/reverseAuctionDetails">@lang('lang.edit')</a>&nbsp;&nbsp;&nbsp;<a href="{{ url('/') }}/admin/reverseAuction/'+row["pk_i_id"]+'/pricesOffers">@lang('lang.pricesOffers')</a>'

                        }
                    },
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