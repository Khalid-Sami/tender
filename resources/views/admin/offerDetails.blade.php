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
        @if($offer->i_status != 102 && $offer->i_status != 103)
            <div class="col-md-2 col-md-offset-6">
                <a href="{{ action('AdminController@reviewedOfferPO',$offer->pk_i_id) }}" class="btn btn-success" id="reviewedBTN">@lang('lang.reviewed')</a>
            </div>
        @endif
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('lang.company_account')</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.company_name'): </strong>
                            <cite>{{ $offer->company->s_name }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.e-mail'): </strong>
                            <cite>{{ $offer->company->s_email }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <strong>@lang('lang.faxNumber'): </strong>
                            <cite>{{ $offer->company->s_fax }}</cite>
                        </div>
                        <div class="col-md-4">
                            <strong>@lang('lang.tel'): </strong>
                            <cite>{{ $offer->company->s_telephone_number }}</cite>
                        </div>
                        <div class="col-md-4">
                            <strong>@lang('lang.mobile_number'): </strong>
                            <cite>{{ $offer->company->s_mobile_number }}</cite>
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
        @if($offer->i_status != 103)
            <div class="col-md-offset-5">
                <a class="btn btn-primary" id="adoption" href="">@lang('lang.acceptOffer')</a>
            </div>
        @endif
        <a href="{{action('AdminController@showOffers')}}" class="hidden" id="returnOffersPage">ggg</a>
    </div>
    {{--</form>--}}
@endsection
@section('scripts')
    <script>
        $('document').ready(function () {

            {{--$.ajax({--}}
                {{--method: "GET",--}}
                {{--dataType: "json",--}}
                {{--url: '{{action('AdminController@getOfferStatus',$offer->pk_i_id)}}',--}}
                {{--data: {--}}
                    {{--"_token": "{{ csrf_token() }}"--}}
                {{--},--}}
                {{--success: function (data, textStatus, jqXHR) {--}}
                        {{--if(data.status == 102 || data.status == 103){--}}
                            {{--$('#reviewedBTN').remove()--}}
                        {{--}--}}
                        {{--else if(data.status == 103){--}}
                            {{--$('#adoption').remove()--}}
                        {{--}--}}
                        {{--else{--}}
                            {{--$('#reviewedBTN').removeClass('hidden')--}}
                            {{--$('#adoption').removeClass('hidden')--}}
                        {{--}--}}
                {{--},--}}
                {{--error: function (jqXHR, textStatus, errorThrown) {--}}
                {{--}--}}
            {{--});--}}

            $('#adoption').click(function(event){
                var thisButton = $(this);
                event.preventDefault();
                swal({
                        title: "{{ trans('lang.approvedRequest') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ trans('lang.okBtn') }}",
                        cancelButtonText: "{{ trans('lang.cancel') }}",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        $.ajax({
                            method: "GET",
                            dataType: "json",
                            url: '{{action('AdminController@adoptionOffer',$offer->pk_i_id)}}',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data, textStatus, jqXHR) {
                                if (data.status) {
                                    {{--swal("{{trans('lang.success')}}", "{{trans('lang.successApproved')}}", "success");--}}
                                    thisButton.remove()
                                    $('#reviewedBTN').remove()
                                    $('#returnOffersPage:first')[0].click()
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });

                    });
            })
        })
    </script>
@endsection