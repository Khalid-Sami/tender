@extends('_layout')
@section('head_title')
    {{trans('lang.service_update')}}
@endsection
@section('title')
    {!!  trans('lang.service_update')!!}
@endsection
@section('msg')
    <div id="alert_message" class="alert alert-danger alert-dismissible hidden text-center"  style=" position: absolute;width: 100%;z-index: 1;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p id="message"></p>
    </div>
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
            <table class="table table-striped table-bordered table-hover" id="myTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.service_provider')</th>
                    <th>@lang('lang.telephone_number')</th>
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


            <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><span>{{ trans('lang.cancel') }}</span></button>
                    <button type="button" class="btn btn-primary">{{ trans('lang.save') }}</button>
                </div>
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div> <!-- /.modal -->

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
            var i = 1;
            var status = $('#statusForm').val();
            $('#alert_message').addClass('hidden');
            table = $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','getCompanyUpdates') }}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 's_name', name: 's_name',defaultContent:""},
                    {data: 's_telephone_number', name: 's_telephone_number',defaultContent:""},
                    {data: 's_mobile_number', name: 's_mobile_number',defaultContent:""},
                    {data: 's_email', name: 's_email',defaultContent:""},
                    {
                        mRender: function (data, type, row) {
                            return '<a  href="' + BASE_URL + '/admin/company/' + row['pk_i_id'] + '/update" class="btn btn-success view" data-toggle="modal" data-target="#myModal"> @lang('lang.view')</a>';

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
               $('#myTable_length').addClass('pull-left');
            $('#myTable_info').addClass('pull-left');
            $('#myTable_filter').addClass('pull-right');
            $('#myTable_paginate').addClass('pull-right');
            @endif
        });
    </script>

    <script>
        $('body').on('click','.view',function(){

        });

    </script>
@endsection