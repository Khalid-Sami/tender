@extends('_layout')
@section('styles')

@endsection
@section('head_title')
    {{trans('lang.quotation')}}
@endsection
@section('title')
    {!!  trans('lang.quotation')!!}
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
    <div class="col-sm-12">
    <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
           <thead>
           <tr>
               <th>#</th>
               <th>@lang('lang.service')</th>
               <th>@lang('lang.quotation')</th>
               <th>@lang('lang.from')</th>
               <th>@lang('lang.to')</th>
               <th>@lang('lang.options')</th>
           </tr>
           </thead>
       </table>
   </div>

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
            var status = $('#status').val();
            var role = $('#role').val();
            table = $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','getRequest') }}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row) {
                            return i++;
                        }
                    },
                    {data: 'service.s_service', name: 'service.s_service',  defaultContent:""},
                    {data: 'i_quotation_no', name: 'i_quotation_no',defaultContent:""},
                    {data: 'dt_start_time', name: 'dt_start_time',defaultContent:""},
                    {data: 'dt_end_time', name: 'dt_end_time',defaultContent:""},

                    {
                        mRender: function (data, type, row) {

                            return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a href="{{url('/')}}/user/quotations/' + row['pk_i_id'] + '/show">@lang('lang.show_quotations')</a>' +
                                    '</li>' +
                                    '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
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




        $('body').on('click', '.showQuotations', function () {
            var pk_i_id = $(this).parent().siblings('#pk_i_id').val();


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
@endsection