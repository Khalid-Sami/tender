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
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class=""></i></div>
                <div class="tools">
                    <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: block;">

                <div class="row">
                    <div class="col-sm-12">
                        <h3>@lang('lang.quotation_details')</h3>
                        <h4> @lang('lang.price') : {{ $requestsQuotation->d_price }}</h4>

                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b>@lang('lang.description')</b></div>
                                <div class="panel-body">{{$requestsQuotation->s_description}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <?php
                        $help = new \App\helper\helpers();
                        $quotationAttachment = $help->getQuotationAttachment($requestsQuotation->pk_i_id);
                        ?>

                        @foreach($quotationAttachment as $attach)
                            <h3>@lang('lang.quotation_attach')</h3>
                            <a href="{{asset('/images/quotation_attachment/'.$attach->s_url)}}"
                               data-lightbox="{{$attach->s_url}}">
                                <img class="col-sm-3" width="200" height="150"
                                     src="{{ asset('/images/quotation_attachment/'.$attach->s_url) }}" alt="">

                            </a>
                        @endforeach
                    </div>

                </div>
                <div class="row">
                    <br><br>
                    <div class="col-sm-2">
                        {!! Form::open(['id'=>'acceptForm','method'=>'post','route'=>['booking.status.change',$requestId,$serviceProviderId]]) !!}
                        {!! Form::hidden('method','accept') !!}
                        <a  class="btn btn-success" id="accept">@lang('lang.accept')</a>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-sm-2">
                        {!! Form::open(['id'=>'cancelForm','method'=>'post','route'=>['booking.status.change',$requestId,$serviceProviderId]]) !!}
                        {!! Form::hidden('method','cancel') !!}
                        <a class="btn btn-danger" id="cancel">@lang('lang.cancel')</a>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $('body').on('click', '#accept', function () {

            swal({
                        title: "{{trans('lang.sure')}}",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans('lang.yes_change')}}",
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                method: "POST",
                                url: "{{ route('booking.status.change',[$requestId,$serviceProviderId]) }}",
                                dataType: "json",
                                data: $('#acceptForm').serialize(),
                                success: function (data, textStatus, jqXHR) {
                                    if (data.status) {
                                        swal({
                                            type: "success",
                                            title: "{{trans('lang.quotation_accepted')}}",
                                            text: "",
                                            confirmButtonText: "{{trans('lang.ok')}}"
                                        });
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                }
                            });
                            return false;
                        }

                    });

        });

    </script>
    <script>
        $('body').on('click', '#cancel', function () {
            swal({
                        title: "{{trans('lang.sure')}}",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans('lang.yes_change')}}",
                        closeOnConfirm: false
                    },
                    function () {
                        $.ajax({
                            method: "POST",
                            url: "{{ route('booking.status.change',[$requestId,$serviceProviderId]) }}",
                            dataType: "json",
                            data: $('#cancelForm').serialize(),
                            success: function (data, textStatus, jqXHR) {
                                if (data.status) {
                                    swal({
                                        type: "success",
                                        title: "{{trans('lang.quotation_canceled')}}",
                                        text: "",
                                        confirmButtonText: "{{trans('lang.ok')}}"
                                    });
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });
                        return false;
                    });


        });

    </script>
@endsection