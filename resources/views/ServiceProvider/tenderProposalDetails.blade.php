@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.pricesOffers')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.pricesOffers')}}
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
                    <h3 class="panel-title">@lang('lang.tenderDetails')</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.tenderTitle'): </strong>
                            <cite style="color: #2b71a8">{{ $tenderProposal->tender->s_title }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <strong>@lang('lang.tenderStartDate'): </strong>
                            <cite style="color: #2b71a8">{{ $tenderProposal->tender->dt_open_date }}</cite>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('lang.tenderEndDate'): </strong>
                            <cite style="color: #2b71a8">{{ $tenderProposal->tender->dt_close_date }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <strong>@lang('lang.currency'): </strong>
                            <cite style="color: #2b71a8">{{ $tenderProposal->tender->currency->s_name }}</cite>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('lang.status'): </strong>
                            <cite style="color: #2b71a8">{{ $tenderProposal->tender->status->s_name }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.tenderDetails'): </strong>
                            <div class="note note-info">
                                @if($tenderProposal->tender->s_description != "")
                                    <p> {{ $tenderProposal->tender->s_description }} </p>
                                @else
                                    <p> @lang('lang.noDetails') </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.tenderTerms'): </strong>
                            <div class="note note-danger">
                                @if($tenderProposal->tender->s_terms != "")
                                    <p> {{ $tenderProposal->tender->s_terms }} </p>
                                @else
                                    <p> @lang('lang.noTerms') </p>
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
                                <th>{{ trans('lang.isDifferent') }}</th>
                                <th>{{ trans('lang.Notes') }}</th>
                            </tr>
                            </thead>
                            <tbody id="itemsContentBody">
                            @foreach($tenderProposal->tenderProposalItems as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->tenderItems->item->s_name }}</td>
                                    <td>{{ $item->tenderItems->item->unit->s_name }}</td>
                                    <td class="itemQun">{{ $item->tenderItems->i_quantity }}</td>
                                    <td>{{ $item->d_price }}</td>
                                    <td class="itemTotal">{{ $item->d_price * $item->tenderItems->i_quantity }}</td>
                                    <td>
                                        @if($item->b_is_different == 1)
                                            <input style="width: 60%; height: auto" type="checkbox" class="form-control isDiff" name="isDiff[]" value="{{ $item->pk_i_id }}" checked disabled>
                                        @else
                                            <input style="width: 60%; height: auto" type="checkbox" class="form-control isDiff" name="isDiff[]" value="{{ $item->pk_i_id }}" disabled>
                                        @endif
                                    </td>
                                    <td>{{ $item->s_note }}
                                        <input type="hidden" name="itemQuantity[{{$key+1}}]" value="{{$item->tenderItems->i_quantity}}">
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