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
                    <th>@lang('lang.offerTitle')</th>
                    <th>@lang('lang.total')</th>
                    <th>@lang('lang.currency')</th>
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
                    "url": "{!! route('companyOffers.get') !!}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 'offerTitle', offerTitle: 'offerTitle',defaultContent:""},
                    {data: 'total', total: 'total',defaultContent:""},
                    {data: 'currency', currency: 'currency',defaultContent:""},
                    {data: 'status', status: 'status',defaultContent:""},
                    {
                        mRender: function (data, type, row, full) {

                            if (row['statusID'] != 103 && row['statusID'] != 99){
                                return '<a href="{{url('/')}}/ServiceProvider/offer/'+row['offerID']+'" class="edit_currency">@lang('lang.edit')</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" class="deleteOrRetrieveOffer" data-id="0" data-val="'+row['offerID']+'">@lang('lang.delete')</a>';
                                {{--return '<div class="dropdown">' +--}}
                                    {{--'<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +--}}
                                    {{--'<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +--}}
                                    {{--'<li>' +--}}
                                    {{--'<a href="{{ url('') }}/admin/'+row["pk_i_id"]+'/deleteOffer">@lang('lang.delete')</a>' +--}}
                                    {{--'</li>' +--}}
                                    {{--'<li>' +--}}
                                    {{--'<a href="{{url('/')}}/ServiceProvider/offer/'+row['offerID']+'" class="edit_currency">@lang('lang.edit')</a>' +--}}
                                    {{--'<input type="hidden" id="offerID" value="' + row['offerID'] + '">' +--}}
                                    {{--'</li>' +--}}
                                    {{--'</ul>' +--}}
                                    {{--'</div>';--}}
                            }
                            else if(row['statusID'] == 99){
                                return '<a href="{{url('/')}}/ServiceProvider/offer/'+row['offerID']+'" class="edit_currency">@lang('lang.edit')</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" class="deleteOrRetrieveOffer" data-id="1" data-val="'+row['offerID']+'">@lang('lang.retrieve')</a>';
                            }
                            else{
                                return '<a href="{{url('/')}}/serviceProvider/offerDetails/'+row['offerID']+'" class="">@lang('lang.show')</a>'
                            }

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


        $('body').on('click','.deleteOrRetrieveOffer',function (event) {
            var thisButton = $(this);
            var value = $(this).data('val')
            var check = $(this).data('id')
            var confirmed;
            var success;
            var operation;
            if(check == 0){
                operation = 'remove'
                confirmed = '@lang("lang.yes_delete")'
                success = '@lang("lang.deleted")'
            }
            else{
                operation = 'retrieve'
                confirmed = '@lang("lang.yes_retrieve")'
                success = '@lang("lang.retrieve_offer")'
            }
            event.preventDefault();
            swal({
                    title: "{{ trans('lang.sure') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: confirmed,
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    $.ajax({
                        method: "GET",
                        dataType: "json",
                        url: '{{url('/')}}/serviceProvider/offer/'+operation+'/'+value,
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.status) {
                                swal("{{trans('lang.success')}}", success, "success");
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