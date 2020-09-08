@extends('_layout')
@section('head_title')
    {{trans('lang.quotation')}}
@endsection
@section('title')
    <a href="{{action('AdminController@showAllUsers')}}">{!!trans('lang.quotation') !!}</a>{{" / "}}{{$user_name or ''}}
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


    {{--@if(isset($data))--}}
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" id="myTable" style="width: 100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('lang.service_provider')</th>
                    <th>@lang('lang.service')</th>
                    <th>@lang('lang.price')</th>
                    <th>@lang('lang.status')</th>
                    <th>@lang('lang.options')</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    {{--@endif--}}

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.quotation')</h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('scripts')
    <script>
        $('body').on('click', '.changeSubscription', function () {
            var pk_i_id = $(this).siblings('#pk_i_id').val();
            var provider = $(this).siblings('#provider').val();
            var fk_i_subscription_package_id = $(this).siblings('#fk_i_subscription_package_id').val();

            $('#pk_i_id_m').val(pk_i_id);
            $('#provider_m').val(provider);
            if(fk_i_subscription_package_id == null){
                $('#subscription_id_m').val(0);
                $('#subscription_id_m').select2();
            }else{
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
            },submitHandler: function (form) {
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
            var status = $('#statusForm').val();
            $('#alert_message').addClass('hidden');
            var userId = "{{$userId}}";
            $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('table.get','showQuotations') }}",
                    "data":{userId:userId}
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 'provider_name', name: 'provider_name',defaultContent:""},
                    {data: 'service_name', name: 'service_name',defaultContent:""},
                    {data: 'd_price', name: 'd_price',defaultContent:""},
                    {data: 'status.s_name', name: 'status.s_name',defaultContent:""},
                    {
                        mRender: function (data, type, row) {

                            return '<a  data-target="#myModal" data-toggle="modal" href="{{url('/')}}/admin/quotations/'+row['pk_i_id']+'/view">@lang('lang.view_details')</a>';

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