@extends('_layout')
@section('style')
    <style>
        .mainCategory{
            background-color:green;
        }

    </style>
@endsection
@section('head_title')
    {{trans('lang.offersProvided')}}
@endsection
@section('title')
    {{trans('lang.offersProvided')}}
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
        {{--<div class="col-sm-12">--}}
        {{--<button class="btn green" id="addCurrency"><span class="fa fa-plus"></span> @lang('lang.newCurrency')</button>--}}
        {{--</div>--}}
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.company_name')</th>
                    <th>@lang('lang.offerTitle')</th>
                    <th>@lang('lang.totalPrice')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.options')</th>
                    <th class="hidden">@lang('lang.options')</th>
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
                "order": [[ 6, "asc" ]],
                "aoColumnDefs": [{ "bVisible": false, "aTargets": [6] }],
                "ajax": {
                    "url": "{!! action('AdminController@getAllOffers') !!}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 'company.s_name', company: 'company.s_name',defaultContent:""},
                    {data: 's_title', tenderTitle: 's_title',defaultContent:""},
                    {
                        mRender: function (data, type, row, full) {
                            return row['total'] +" "+ row['currency']['s_name']
                        }
                    },
                    {data: 'status.s_name', status: 'status.s_name',defaultContent:""},
                    {
                        mRender: function (data, type, row, full) {
                            return '<a href="{{ url('/') }}/admin/offerDetails/'+row["pk_i_id"]+'">@lang('lang.offerDetails')</a>';
                                {{--return '<div class="dropdown">' +--}}
                                {{--'<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +--}}
                                {{--'<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +--}}
                                {{--'<li>' +--}}
                                {{--'<a href="{{ url('') }}/admin/'+row["pk_i_id"]+'/deleteOffer">@lang('lang.delete')</a>' +--}}
                                {{--'</li>' +--}}
                                {{--'<li><a href="{{ url('/') }}/admin/offerDetails/'+row["pk_i_id"]+'">@lang('lang.offerDetails')</a></li>'+--}}
                                {{--'</ul>' +--}}
                                {{--'</div>';--}}

                        }
                    },
                    {data: 'i_status', istatus: 'i_status',defaultContent:""}
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

        $('body').on('click', '.withdrawalORretrieve', function() {
//        e.preventDefault();
            var aTag = $(this);
            var tenderProposal = $(this).attr('id');
            var status = $(this).data('val');
            var msg;
            var successMSG;
            if(status == 99){
                msg = "{{ trans('lang.yes_withdrawal') }}"
                successMSG = "{{ trans('lang.success_withdrawal') }}"
            }
            else {
                msg = "{{ trans('lang.yes_retrieve') }}"
                successMSG = "{{ trans('lang.retrieve_bid') }}"
            }
            swal({
                    title: "{{ trans('lang.sure') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: msg,
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {

                    $.ajax({
                        method:'GET',
                        dataType: 'json',
                        url: '{{url('/')}}/ServiceProvider/' + tenderProposal + '/tenderProposalWithdrawal',
                        data:{
                            "_token": "{{csrf_token()}}",
                            "status" : status
                        },
                        success: function (data, textStatus, jqXHR) {
                            if(data.status){
                                swal("{{trans('lang.success')}}",successMSG, "success");
                                table.ajax.reload()
                            }
                        }
                    })

                });

        })

    </script>


@endsection