@extends('_layout')

@section('head_title')
    {{trans('lang.subscribe_plan')}}
@endsection
@section('title')
    {!!  trans('lang.subscribe_plan')!!}
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

    <div class="row">
        <a href="{{ action('AdminController@createSubscribePlan') }}" class="btn green"> <span
                    class="fa fa-plus"></span> @lang('lang.subscribe_plan')</a>
    </div>
    <br><br>
    @if(! $subscription_packages->isEmpty())
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('lang.subscribe_plan')</th>
                        <th>@lang('lang.status')</th>
                        <th>@lang('lang.options')</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($subscription_packages as $i => $package)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$package->s_name}}</td>
                            <td>{{$package->b_enabled == 1?(app()->getLocale()=='en'?'enable':'فعال'):(app()->getLocale()=='ar'?'غير فعال':'disable')}}</td>
                            <td>
                                <a href="{{ route('admin.subscribe.plan.get',$package->pk_i_id) }}" data-toggle="modal" data-target="#myModal" class="edit">@lang('lang.edit')</a>
                                <a class="delete" data-token="{{ csrf_token() }}">@lang('lang.delete')</a>

                                <input type="hidden" id="pk_i_id" value="{{$package->pk_i_id}}">
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @endif
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
                        <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">{{ trans('lang.cancel') }}</button>
                        <button type="button" class="btn btn-primary">{{ trans('lang.save') }}</button>
                    </div>
                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog -->
        </div> <!-- /.modal -->
@endsection
@section('scripts')

    <script>
        $('.date-picker').datepicker({
            format: 'yyyy-m-dd'
        });
    </script>


    <script>
        $('body').on('click', '.delete', function () {
            var token = $(this).data("token");
            var pk_i_id = $(this).siblings('#pk_i_id').val();

            swal({
                        title: "{{ trans('lang.sure') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ trans('lang.yes_delete') }}",
                        cancelButtonText: "{{ trans('lang.cancel') }}",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true

                    },
                    function () {
                        $.ajax({
                            method: "POST",
                            dataType: "json",
                            url: '/Tabebk/admin/subscriptions/updateSubscribePlan',
                            data: {
                                "_method": 'PATCH',
                                "_token": token,
                                'pk_i_id': pk_i_id,
                                'method': 'delete'
                            },
                            success: function (data, textStatus, jqXHR) {
                                swal("{{trans('lang.deleted_success')}}!", "{{ trans('lang.deleted') }}", "success");

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });
                    });
        });
    </script>

    <script>
        $(document).ready(function () {
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
            $('#myTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: '',
                        className: 'hidden'
                    }

                ],
                "bLengthChange": true,
                "bFilter": true,
                "pageLength": 25,
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