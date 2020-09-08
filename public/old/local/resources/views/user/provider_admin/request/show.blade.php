@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.request_details')}}
@endsection
@section('title')
    {!!  trans('lang.request_details')!!}
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
        <a class="btn btn-primary" href="{{ route('quotation.add',$requestId) }}"><span class="fa fa-plus"></span> @lang('lang.quotation')</a>
    </div><br><br><br>
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

    <div class="col-sm-12"></div>

@endsection
@section('scripts')

@endsection