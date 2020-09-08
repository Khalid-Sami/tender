@extends('_layout')
@section('style')
    <style>
        .mainCategory{
            background-color:green;
        }

    </style>
@endsection
@section('head_title')
    {{trans('lang.tenders')}}
@endsection
@section('title')
    {{trans('lang.tenders')}}
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
                    <th>@lang('lang.tender')</th>
                    <th>@lang('lang.tenderStartDate')</th>
                    <th>@lang('lang.tenderEndDate')</th>
                    <th>@lang('lang.status')</th>
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
                    "url": "{!! route('SPTenders.get') !!}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 's_title', tenderTitle: 's_title',defaultContent:""},
                    {data: 'dt_open_date', startDate: 'dt_open_date',defaultContent:""},
                    {data: 'dt_close_date', endDate: 'dt_close_date',defaultContent:""},
                    {data: 'status.s_name', status: 'status.s_name',defaultContent:""},
                    {
                        mRender: function (data, type, row, full) {
                            var status = row['tenderStatus'];
                            var aTag = "";
                            var tenderProposalID = row['tenderProposalID'];
                            var tenderProposalStatus = row['tenderProposalStatus'];

                            {{--$.ajax({--}}
                                {{--method:'GET',--}}
                                {{--dataType: 'json',--}}
                                {{--url: '{{ route('SPTenders') }}',--}}
                                {{--data:{--}}
                                    {{--"_token": "{{csrf_token()}}",--}}
                                {{--},--}}
                                {{--success: function (data, textStatus, jqXHR) {--}}
                                    {{--if(data.status){--}}
                                        {{--$.each(data.tenderProposal, function (i, item) {--}}
                                            {{--if(item.fk_i_tender_id == row['pk_i_id']){--}}
                                                {{--status = true;--}}
                                                {{--tenderProposalID = item.pk_i_id;--}}
                                                {{--if(item.i_status == 99)--}}
                                                    {{--tenderProposalStatus = true;--}}
                                            {{--}--}}
                                        {{--});--}}
                                    {{--}--}}
                                {{--}--}}
                            {{--})--}}
                            {{--@foreach($checkTenderProposal as $tenderProposal)--}}
                                    {{--if('{{$tenderProposal->fk_i_tender_id}}' == row['pk_i_id']){--}}
                                        {{--status = true;--}}
                                        {{--tenderProposalID = '{{$tenderProposal->pk_i_id}}';--}}
                                        {{--@if($tenderProposal->i_status == 99)--}}
                                            {{--tenderProposalStatus = true;--}}
                                        {{--@endif--}}
                                    {{--}--}}
                            {{--@endforeach--}}
                            if(status){
                                if(row['i_status'] == 97){
                                    if(tenderProposalStatus == true){
                                        aTag = '<a data-val="101" id="'+tenderProposalID+'" class="withdrawalORretrieve">@lang('lang.retrieve')</a>';
                                    }
                                    else{
                                        aTag = '<a href="{{url('/')}}/ServiceProvider/'+row['pk_i_id']+'/editBidding" class="bidding">@lang('lang.edit')</a>&nbsp;'+
                                            '/&nbsp;<a data-val="99" id="'+tenderProposalID+'" class="withdrawalORretrieve">@lang('lang.withdrawal')</a>';
                                    }
                                }
                                else if(row['i_status'] == 98){
                                    {{--if(row['i_accept_offer'] == 0 && tenderProposalStatus == false){--}}
                                        {{--aTag = '<a data-val="99" id="'+tenderProposalID+'" class="withdrawalORretrieve">@lang('lang.withdrawal')</a>';--}}
                                    {{--}--}}
                                        aTag = '<a href="{{url('/')}}/ServiceProvider/showTenderProposalOffer/'+tenderProposalID+'" id="'+tenderProposalID+'" class="showTenderProposal">@lang('lang.show')</a>';
                                }
                            }
                            else{
                                if(row['i_status'] == 97){
                                    aTag = '<a href="{{url('/')}}/ServiceProvider/'+row['pk_i_id']+'/bidding" class="bidding">@lang('lang.bidding')</a>';
                                }
                            }
                            return aTag
                            {{--return '<div class="dropdown">' +--}}
                                {{--'<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +--}}
                                {{--'<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +--}}
                                {{--'<li>' +--}}
{{--                                '<qa class="edit_currency">@lang('lang.edit')</a><li>' +--}}
                                {{--aTag--}}
                                {{--+--}}
                                {{--'</li><input type="hidden" id="tenderID" value="' + row['pk_i_id'] + '">' +--}}
                                {{--'</li>' +--}}
                                {{--'</ul>' +--}}
                                {{--'</div>';--}}

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

        $('body').on('click', '.withdrawalORretrieve', function(e) {
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
            e.preventDefault();
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
                            else{
                                swal(
                                    '@lang('lang.sorry')',
                                    '@lang('lang.tenderEndDateExpired')',
                                    'error'
                                )
                                table.ajax.reload()
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    })

                });

        })

    </script>


@endsection