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
                    <i class=""></i>@lang('lang.request_details') </div>
                <div class="tools">
                    <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: block;">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger pull-right cancelRequest">@lang('lang.cancel_request')</a>
                    </div>
                    <div class="col-sm-12">
                        <h3>@lang('lang.request_info')</h3>
                        <ul class="list-group">
                            <li class="list-group-item col-sm-3"><span><b>@lang('lang.service')
                                        : </b></span>{{$requests->service->s_service}} </li>
                            <li class="list-group-item col-sm-3"><span><b>@lang('lang.quotation_number')
                                        : </b></span>{{$requests->i_quotation_no}}</li>
                            <li class="list-group-item col-sm-3"><span><b>@lang('lang.from')
                                        : </b></span>{{ date('Y-m-d',strtotime($requests->dt_start_time))}}</li>
                            <li class="list-group-item col-sm-3"><span><b>@lang('lang.from')
                                        : </b></span>{{date('Y-m-d',strtotime($requests->dt_end_time))}}</li>
                        </ul>
                    </div>
                    <div class="col-sm-12">
                        <h3>@lang('lang.request_attach')</h3>
                        @foreach($attachment as $attach)
                            <a href="{{asset('/images/request_attachment/'.$attach->s_url)}}"
                               data-lightbox="{{$attach->s_url}}">
                                <img class="col-sm-3" width="200" height="150"
                                     src="{{ asset('/images/request_attachment/'.$attach->s_url) }}" alt="">

                            </a>
                        @endforeach
                    </div>
                    <div class="col-sm-12">
                        <h3>@lang('lang.question_option')</h3>
                        <div class="panel-group accordion col-sm-8" id="accordion3">
                            @foreach($requestQuestionAnswer as $index=>$item)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle accordion-toggle-styled collapsed"
                                               data-toggle="collapse" data-parent="#accordion3"
                                               href="#collapse_3_{{$index}}"
                                               aria-expanded="false">{{ $item->serviceQuestion->s_question }} </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_{{$index}}" class="panel-collapse collapse"
                                         aria-expanded="false"
                                         style="height: 0px;">
                                        <div class="panel-body">
                                            <p> {{ $item->serviceQuestionOption->s_option }} </p>

                                        </div>
                                    </div>
                                </div>


                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        @foreach($requestQuotation as $quotation)
            <div class="mt-timeline-content col-sm-10">
                <div class="mt-content-container bg-white border-grey-steel"
                     style="padding: 40px;border: 2px solid #d3d7e9;">
                    <div class="mt-author">
                        <div class="mt-avatar">

                            <img class="img-circle" width="80" height="80"
                                 src="{{ isset($user->s_pic)? asset("/images/users_images/".$user->s_pic):asset('/images/users_images/avatar.png') }}">
                            {{ $quotation->serviceProvider->s_name }}
                        </div>
                        <div class="row">
                            <h4>@lang('lang.price'): {{$quotation->d_price}} </h4>
                        </div>

                    </div>
                    <div class="mt-content border-grey-steel">
                        <p>{{ str_limit($quotation->s_description,100)."..." }}</p>
                        <div class="pull-right">
                            <a href="{{ route('user.quotation.show',$quotation->pk_i_id) }}"  class="btn btn-circle blue-steel dropdown-toggle moreDetails" type="button"
                                     data-target="#myModal" data-toggle="modal"> @lang('lang.more')
                            </a>
                            <a href="{{ route('message.show',$quotation->serviceProvider->pk_i_id) }}"  class="btn btn-circle blue-steel dropdown-toggle moreDetails" type="button"> @lang('lang.chat')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


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
        $('body').on('click', '.cancelRequest', function () {

            swal({
                        title: "{{trans('lang.sure')}}",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans('lang.yes_change')}}",
                        showLoaderOnConfirm: true,
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                method: "POST",
                                url: "{{ route('booking.status.change',[$requestId,0]) }}",
                                dataType: "json",
                                data: {'method':'cancelRequest','_token':"{{ csrf_token() }}"},
                                success: function (data, textStatus, jqXHR) {
                                    if (data.status) {
                                        swal({
                                            type: "success",
                                            title: "{{trans('lang.request_canceled')}}",
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



@endsection