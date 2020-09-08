<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>@lang('lang.subscribe_plan')</title>
</head>
<body>
{{--{!! Form::open(['method' => 'patch','action' => 'AdminController@updateSubscribePlan','id' =>'editSubscribePlanForm']) !!}--}}
<div class="modal-content modal-lg">
    <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span>@lang('lang.service_desc')</span></h4>
    </div>            <!-- /modal-header -->
    <div class="modal-body">
        <p>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('lang.service')</th>
                        <th>@lang('lang.instant')</th>
                        <th>@lang('lang.price')</th>
                        <th>@lang('lang.options')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $index => $service)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{$service->service->s_service}}</td>
                            <td>{{$service->is_instant or '-'}}</td>
                            <td>{{$service->d_price}}</td>
                            <td>


                                @if($service->b_approved == 0)
                                    <a class="btn btn-success approve">@lang('lang.approve')</a>
                                    <a class="btn btn-danger reject">@lang('lang.reject')</a>
                                @endif
                                @if($service->b_approved == 1)
                                    <a class="btn btn-danger reject">@lang('lang.reject')</a>
                                @endif
                                @if($service->b_approved == 2)
                                    <a class="btn btn-success approve">@lang('lang.approve')</a>
                                @endif
                                <input type="hidden" id="service_provider_id"
                                       value="{{$service->fk_i_service_provider_id}}">
                                <input type="hidden" id="service_id" value="{{$service->fk_i_service_id}}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </p>
    </div>            <!-- /modal-body -->
</div>         <!-- /modal-content -->
{{--{!! Form::close() !!}--}}


<script>
    $('body').on('click', '.approve', function () {
        var serviceId = $(this).siblings('#service_id').val();
        var serviceProviderId = $(this).siblings('#service_provider_id').val();
        swal({
                    title: "{{trans('lang.sure')}}",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('lang.yes_change') }}",
                    showLoaderOnConfirm: true,
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false
                },
                function () {
                    $('#myModal').modal('hide');

                    $.ajax({
                        method: "get",
                        url: "{{ route('admin.company') }}",
                        dataType: "json",
                        data: {'method': 'approve', 'serviceId': serviceId, 'serviceProviderId': serviceProviderId},
                        success: function (data, textStatus, jqXHR) {
                            swal("{{ trans('lang.done') }}", "{{trans('lang.updated')}}", "success");
                            table.ajax.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });

                });
    });
</script>
<script>
    $('body').on('click', '.reject', function () {
        var serviceId = $(this).siblings('#service_id').val();
        var serviceProviderId = $(this).siblings('#service_provider_id').val();
        swal({
                    title: "{{trans('lang.sure')}}",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('lang.yes_change') }}",
                    showLoaderOnConfirm: true,
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false
                },
                function () {
                    $('#myModal').modal('hide');

                    $.ajax({
                        method: "get",
                        url: "{{ route('admin.company') }}",
                        dataType: "json",
                        data: {'method': 'reject', 'serviceId': serviceId, 'serviceProviderId': serviceProviderId},
                        success: function (data, textStatus, jqXHR) {
                            swal("{{ trans('lang.done') }}", "{{trans('lang.updated')}}", "success");
                            table.ajax.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });

                });
    });
</script>

</body>
</html>