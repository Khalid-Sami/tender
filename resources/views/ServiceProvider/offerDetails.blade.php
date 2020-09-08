@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.offerDetails')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.offerDetails')}}
        </div>
    </div>
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
    {{--<form method="get" id="adoptionTenderProposal">--}}
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('lang.offerDetails')</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.offerTitle'): </strong>
                            <cite style="color: #2b71a8">{{ $offer->s_title }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <strong>@lang('lang.currency'): </strong>
                            <cite style="color: #2b71a8">{{ $offer->currency->s_name }}</cite>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('lang.status'): </strong>
                            <cite style="color: #2b71a8">{{ $offer->status->s_name }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.offerDetails'): </strong>
                            <div class="note note-info">
                                @if($offer->s_note != "")
                                    <p> {{ $offer->s_note }} </p>
                                @else
                                    <p> @lang('lang.noDetails') </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('lang.showPrices')</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="itemsTable" class="col-sm-12" border="1" cellspacing="0">
                            <colgroup>
                                <col width="2%">
                                <!--<col width="50px">-->
                                <col width="15%">
                                <col width="9%">
                                <col width="9%">
                                <col width="9%">
                                <col width="9%">
                                <col width="5%">
                                <col width="30%">
                            </colgroup>
                            <thead>
                            <tr style="background-color: #3e3e3e;color: white;text-align: center">
                                <th>#</th>
                                <th>{{ trans('lang.product') }}</th>
                                <th>{{ trans('lang.unit') }}</th>
                                <th>{{ trans('lang.quantity') }}</th>
                                <th>{{ trans('lang.price') }}</th>
                                <th>{{ trans('lang.total') }}</th>
                                <th>{{ trans('lang.Notes') }}</th>
                            </tr>
                            </thead>
                            <tbody id="itemsContentBody">
                            @foreach($offer->items as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->item->s_name }}</td>
                                    <td>{{ $item->item->unit->s_name }}</td>
                                    <td class="itemQun">{{ $item->i_quantity }}</td>
                                    <td>{{ $item->d_price }}</td>
                                    <td class="itemTotal">{{ $item->d_price * $item->i_quantity }}</td>
                                    <td>{{ $item->s_note }}
                                        <input type="hidden" name="itemQuantity[{{$key+1}}]" value="{{$item->i_quantity}}">
                                        <input type="hidden" name="tenderItemID[{{$key+1}}]" value="{{ $item->pk_i_id }}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--</form>--}}
@endsection
@section('scripts')
@endsection