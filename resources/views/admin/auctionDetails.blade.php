@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.reverseAuctionDetails')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.reverseAuctionDetails')}}
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
                    <h3 class="panel-title">@lang('lang.reverseAuctionDetails')</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.reverseAuctionTitle'): </strong>
                            <cite style="color: #2b71a8">{{ $auction->s_title }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <strong>@lang('lang.reverseAuctionStartDate'): </strong>
                            <cite style="color: #2b71a8">{{ $auction->dt_open_date }}</cite>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('lang.reverseAuctionEndDate'): </strong>
                            <cite style="color: #2b71a8">{{ $auction->dt_close_date }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <strong>@lang('lang.currency'): </strong>
                            <cite style="color: #2b71a8">{{ $auction->currency->s_name }}</cite>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('lang.status'): </strong>
                            <cite style="color: #2b71a8">{{ $auction->status->s_name }}</cite>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.reverseAuctionDetails'): </strong>
                            <div class="note note-info">
                                @if($auction->s_description != "")
                                    <p> {{ $auction->s_description }} </p>
                                @else
                                    <p> @lang('lang.noDetails') </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <strong>@lang('lang.reverseAuctionTerms'): </strong>
                            <div class="note note-danger">
                                @if($auction->s_terms != "")
                                    <p> {{ $auction->s_terms }} </p>
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
                    <h3 class="panel-title">@lang('lang.productDetails')</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="itemsTable" class="col-sm-12" border="1" cellspacing="0">
                            <colgroup>
                                <col width="2%">
                                <col width="20%">
                                <col width="9%">
                                <col width="9%">
                                <col width="9%">
                                <col width="30%">
                            </colgroup>
                            <thead>
                            <tr style="background-color: #3e3e3e;color: white;text-align: center">
                                <th>#</th>
                                <th>{{ trans('lang.product') }}</th>
                                <th>{{ trans('lang.unit') }}</th>
                                <th>{{ trans('lang.quantity') }}</th>
                                <th>{{ trans('lang.currency') }}</th>
                                <th>{{ trans('lang.Notes') }}</th>
                            </tr>
                            </thead>
                            <tbody id="itemsContentBody">
                            <tr>
                                <td></td>
                                <td>{{ $auction->auctionITem->item->s_name }}</td>
                                <td>{{ $auction->auctionITem->item->unit->s_name }}</td>
                                <td class="quantity">{{ $auction->auctionITem->i_quantity }}</td>
                                <td>{{ $auction->currency->s_name }}</td>
                                <td>{{ $auction->auctionITem->s_notes }}</td>
                            </tr>
                            </tbody>
                        </table>
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
                        <table id="pricesTable" class="col-sm-12" border="1" cellspacing="0">
                            <colgroup>
                                <col width="2%">
                                <col width="2%">
                                <col width="20%">
                                <col width="9%">
                                <col width="9%">
                                <col width="30%">
                            </colgroup>
                            <thead>
                            <tr style="background-color: #81c784;color: white;text-align: center">
                                <th></th>
                                <th>#</th>
                                <th>{{ trans('lang.company') }}</th>
                                <th>{{ trans('lang.price') }}</th>
                                <th>{{ trans('lang.total') }}</th>
                                <th>{{ trans('lang.time') }}</th>
                            </tr>
                            </thead>
                            <tbody id="itemsContentBody">
                            @foreach($auction->auctionProposalOffers as $key=>$proposal)
                                <tr data-val="{{ $proposal->pk_i_id }}" style="background-color: @if($auction->i_accept_offer == $proposal->pk_i_id) #c5cae9 @else #ffffff @endif">
                                    <td>
                                        @if($auction->i_accept_offer == 0)
                                            <a class="adoptOffer" data-val="{{ $proposal->pk_i_id }}"><span class="glyphicon glyphicon-check"></span></a>
                                        @endif
                                    </td>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $proposal->auctionProposal->company->s_name }}</td>
                                    <td>{{ $proposal->d_price }}</td>
                                    <td>{{ (float)$proposal->d_price * $auction->auctionITem->i_quantity }}</td>
                                    <td>{{ $proposal->dt_created_date }}</td>
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
    <script>

            Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_KEY') }}', {
            encrypted: false
        });

        var channel = pusher.subscribe('auctionChannel');
        channel.bind('auction', function(data) {
                var index = 0
                if($('#pricesTable >tbody >tr').length > 0){
                    index = $('#pricesTable >tbody >tr:last').find('td:eq(1)').text()
                }
                var name = ('{{ app()->getLocale() == 'ar' }}') ? data.nameAr : data.nameEn
                $('#pricesTable tbody').append([
                    '<tr data-val="'+data.itemID+'">',
                    '<td><a class="adoptOffer" data-val="'+data.itemID+'"><span class="glyphicon glyphicon-check"></span></a></td>',
                    '<td>'+(parseInt(index)+1)+'</td>',
                    '<td>'+name+'</td>',
                    '<td>'+data.price+'</td>',
                    '<td>'+(parseFloat(data.price) * parseFloat($('.quantity').text()))+'</td>',
                    '<td>'+data.time+'</td>',
                    '</tr>'
                ].join(''));
                    @if(app()->getLocale() == 'ar')
                        var message = "(مزاد عكسي) "+data.name + " اضافت سعر في "+data.auction;
                    @else
                        var message = "(Auction) "+data.name + " added price in "+data.auction;
                    @endif
                 $.notify(message, {
                    position: 'bottom left',
                    // default style
                    style: 'bootstrap',
                    // default class (string or [string])
                    className: 'info',
                });
                });

        $('body').on('click', '.adoptOffer', function () {
            var id = $(this).data('val')
            var row = $(this).closest('tr')
            swal({
                    title: "{{ trans('lang.approvedOfferPrice') }}",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#1e88e5 ",
                    confirmButtonText: "{{ trans('lang.okBtn') }}",
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    $.ajax({
                        method: "GET",
                        dataType: "json",
                        url: '{{url('/')}}/admin/'+id+'/adoptionReverseAuctionProposal',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.status) {
                                $('#pricesTable >tbody >tr').find('td:eq(0)').find('.adoptOffer').remove()
                                swal("{{trans('lang.success')}}", "{{trans('lang.successApproved')}}", "success");
                                row.children('td').css('background-color','#c5cae9');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });

                });
        })

    </script>
@endsection