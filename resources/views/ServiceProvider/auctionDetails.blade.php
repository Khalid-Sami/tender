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
                                @if($auction->s_note != "")
                                    <p> {{ $auction->s_note }} </p>
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
                                <col width="20%">
                                <col width="9%">
                                <col width="9%">
                                <col width="30%">
                            </colgroup>
                            <thead>
                            <tr style="background-color: #81c784;color: white;text-align: center">
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
                        @if($auction->i_status != 98)
                        <div class="col-md-12" id="pushPriceBody">
                            <form id="pushPriceForm">
                                <div class="chat-form">
                                    <div class="input-cont">
                                        <input class="form-control" name="priceInput" type="text" placeholder="@lang('lang.typeMessageHere')" />
                                    </div>
                                    <div class="btn-cont">
                                        <span class="arrow"> </span>
                                        <button type="submit" id="pushBTN" class="btn blue icn-only">
                                            <i class="fa fa-check icon-white"></i>
                                        </button>
                                    </div>
                                    <div id="priceInput_validate" class="font-red"></div>
                                </div>
                            </form>
                        </div>
                        @endif
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
            encrypted: true
        });

        var channel1 = pusher.subscribe('auctionChannel');
        channel1.bind('auction', function(data) {
            if('{{ session('user_id') }}' != data.id){
                var index = 0
                if($('#pricesTable >tbody >tr').length > 0){
                    index = $('#pricesTable >tbody >tr:last').find('td:eq(0)').text()
                }
                @if(app()->getLocale() =='ar')
                    var name = data.nameAr
                @else
                    var name = data.nameEn
                @endif
                $('#pricesTable tbody').append([
                    '<tr data-val="'+data.itemID+'">',
                    '<td>'+(parseInt(index)+1)+'</td>',
                    '<td>'+name+'</td>',
                    '<td>'+data.price+'</td>',
                    '<td>'+(parseFloat(data.price) * parseFloat($('.quantity').text()))+'</td>',
                    '<td>'+data.time+'</td>',
                    '</tr>'
                ].join(''));
            }
        });
        var channel2 = pusher.subscribe('adoptAuctionChannel');
        channel2.bind('adoptAuction', function(data) {
               $('#pricesTable >tbody >tr').each(function () {
                   if ($(this).data('val') == data.itemID){
                       $(this).children('td').css('background-color','#c5cae9');
                   }
               })
            $('#pushPriceBody').remove()
        });
        $('document').ready(function () {

            $('#pushPriceForm').submit(function (e) {
                e.preventDefault()
                $('#pushPriceForm').validate()
            })

            $('#pushPriceForm').validate({
                rules: {
                    priceInput: {
                        required: true,
                        number: true
                    }
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    error.appendTo($("#" + name + "_validate"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    priceInput : {
                        required: "الرجاء ادخال السعر",
                        number: 'الرجاء ادخال رقم صحيح'
                    },
                    @else
                    priceInput: {
                        required: "Please enter the price !",
                        number: 'Please enter number'
                    }
                    @endif
                }, submitHandler: function (e) {
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: '{{action('ServiceProviderController@pushAuctionPrice')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'price' : $('input[name="priceInput"]').val(),
                            'auctionID' : '{{ $auction->pk_i_id }}'
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.status) {

                                var index = 0;
                                if($('#pricesTable >tbody >tr').length > 0){
                                    index = $('#pricesTable >tbody >tr:last').find('td:eq(0)').text()
                                }
                                $('#pricesTable tbody').append([
                                    '<tr data-val="'+data.info.itemID+'">',
                                    '<td>'+(parseInt(index)+1)+'</td>',
                                    '<td>'+data.info.name+'</td>',
                                    '<td>'+data.info.price+'</td>',
                                    '<td>'+(parseFloat(data.info.price) * parseFloat($('.quantity').text()))+'</td>',
                                    '<td>'+data.info.time+'</td>',
                                    '</tr>'
                                ].join(''));
                                $('input[name="priceInput"]').val("")
                            }
                            else {
                                $('#pushPriceBody').remove()
                                @if(app()->getLocale() == 'ar')
                                    var message = "تم إغلاق المزاد العكسي"
                                 @else
                                    var message = "This reverse auction has been closed"
                                @endif
                                $.notify(message, {
                                    position: 'bottom left',
                                    // default style
                                    style: 'bootstrap',
                                    // default class (string or [string])
                                    className: 'warn',
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });
                }
            });
        });
    </script>
@endsection