@extends('_layout')
@section('styles')
    <style>
        .margin-top-10 {
            margin-top: 10px;;
        }
    </style>

    <link href="{{ asset('/css/star-rating.min.css') }}" media="all" rel="stylesheet"/>
    <script src="{{ asset('/js/star-rating.min.js') }}"></script>
@endsection
@section('head_title')
    {{trans('lang.rating')}}
@endsection
@section('title')
    @lang('lang.rating')
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
    {!! Form::open(['id'=>'addData','method'=> 'post','route'=>['rating.store',$requestId]]) !!}
    <div class="col-sm-12">
        @if($evaluationData->isEmpty())
            @foreach($evaluation as $index => $eval)
                <div class="row">
                    <div class="col-sm-4"><h4>{{$eval->s_name}}</h4></div>
                    <div class="col-sm-4">
                        <input class="rating-input" id="rating{{$index}}" name="rating{{$index}}" type="text" title=""/>
                        {!! Form::hidden("evaluation$index",$eval->pk_i_id) !!}
                    </div>

                </div>
            @endforeach
            <br>
            {!! Form::hidden('iterate',count($evaluation)) !!}
            <div class="col-sm-10">
                {!! Form::label('review',trans('lang.review')) !!}
                {!! Form::textarea('review',null,['class'=>'form-control col-sm-10','id'=>'review']) !!}
            </div>
        @else
            @foreach($evaluationData as $eval)
            <div class="row">
                <div class="col-sm-4"><h4>{{$eval->evaluation->s_name}}</h4></div>
                <div class="col-sm-4">
                    <input class="rating-input1" type="text" value="{{$eval->d_value}}" title=""/>
                </div>

            </div>
            @endforeach
                <br>

        @endif
        <br>
        @if($isEvaluated == 0)
            <div class="col-sm-12">
                <button id="send" type="button" class="btn btn-primary margin-top-10">@lang('lang.send')</button>
            </div>
        @endif
    </div>
    {!! Form::close() !!}

@endsection

@section('scripts')
    <script>
        var count = parseInt("{{count($evaluation)}}");

        $('body').on('click', '#send', function () {
            var flag = 0;
            $('.rating-input').each(function () {
                if ($(this).val().length == 0) {
                    flag = 1;
                }
            });
            if (flag) {
                swal("{{trans('lang.eval')}}", "", "error");
            } else {
                if ($('#review').val().length == 0) {
                    swal("{{trans('lang.eval')}}", "", "error");
                } else {
                    $('#addData').submit();
                }

            }
        });

        var $inp = $('.rating-input');

        $inp.rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'sm',
            showClear: false
        });
        var $inp1 = $('.rating-input1');

        $inp1.rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'sm',
            showClear: false,
            readonly:true
        });

    </script>
@endsection