@extends('_layout')
@section('style')

@endsection
@section('head_title')
@endsection
@section('title')
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
        <div class="col-sm-12">
            @if($user->userRule->s_name_en == 'ServiceProviderAdmin')
                <h2>{{trans('lang.newTenders')}}</h2>
                <div class="col-sm-6">
                    <p><strong>{{ trans('lang.note') }}: </strong>{{ trans('lang.tenderNote') }}</p>
                </div>
                @if(sizeof($tenders))
                    @foreach($tenders as $tender)
                        <div class="panel-group" id="accordion">
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">{{ $tender->s_title }}</a>
                                            </h4>
                                        </div>
                                        <div id="collapse2" class="panel-collapse collapse">
                                            @if($tender->s_description != "")
                                                <div class="panel-body">{{ $tender->s_description }}</div>
                                                @else
                                                <div class="panel-body">{{ trans('lang.noDetails') }}</div>
                                            @endif
                                            <cite style="margin:3%">{{ trans('lang.tenderEndDate') }}: <small style="color: burlywood">{{ $tender->dt_close_date }}</small></cite>

                                               @if(app()->getLocale() == 'en')
                                                   <a id="bidding" data-val="{{ $tender->pk_i_id }}" class="col-sm-offset-11">{{ trans('lang.bidding') }}</a>
                                               @else
                                                   <a id="bidding" data-val="{{ $tender->pk_i_id }}" class="col-sm-offset-9">{{ trans('lang.bidding') }}</a>
                                               @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>

    <form method="POST" id="newTenderForm" action="{{ action('AdminController@addNewTender') }}">

    </form>

@endsection
@section('scripts')
    <script>
        $('#document').ready(function () {
            $('#bidding').click(function () {
                alert($(this).data('val'));
            })
        })
    </script>
@endsection