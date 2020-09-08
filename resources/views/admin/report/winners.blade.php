@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.winnersOffers')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.winnersOffers')}}
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
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('lang.winnersOffersOnDate')</h3>
                </div>
                <div class="panel-body">
                    <div class="categories">
                        <div class="form-group col-sm-3 selectCategory">
                            <label name="fromDate">{{ trans('lang.from') }}</label>
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control fromDate" readonly>
                                <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="items">
                        <div class="form-group col-sm-3 selectItem">
                            <label name="toDate">{{ trans('lang.to') }}</label>
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control toDate" readonly>
                                <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        <button class="btn btn-primary" id="showBTN" style="margin-top:24px;">@lang('lang.show')</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="wait" style="display:none">
            <div class="col-md-offset-5">
                <img src='{{ asset('/images/demo_wait.gif') }}' width="64" height="64" /><br>
            </div>
        </div>
        <div class="col-md-12 hidden" id="tablesBody">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>@lang('lang.winnersOffersOnDate')</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body flip-scroll">
                    <div class="icons" style="float: @if(app()->getLocale() == 'en') right @else left @endif">
                    </div>
                    <div class="table-scrollable" id="tables">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $('#showBTN').click(function () {
            $('#tables').empty()
            $('.icons').empty()
            $('#tablesBody').addClass('hidden')
            if($('.fromDate').val() != "" && $('.toDate').val()){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/admin/supplier/winnerReport',
                    data:{
                        "_token": "{{csrf_token()}}",
                        'fromDate' : $('.fromDate').val(),
                        'toDate': $('.toDate').val()
                    },
                    beforeSend: function() {
                        $('.icons').empty()
                        $('#tablesBody').addClass('hidden')
                        $("#wait").css("display", "block");
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.status){
                            if (data.found){
                                $('#tablesBody').removeClass('hidden')
                                $('.icons').append(($('<a></a>').attr('class', 'exportPDF').attr('href','{{ url('/') }}/admin/exportWinnerReport/pdf/'+$('.fromDate').val()+'/'+$('.toDate').val()).append($('<i></i>').attr('class','fa fa-file-pdf-o').css('font-size','2em')))).append(" ")
                                    .append($('<a></a>').attr('class', 'exportExcel').attr('href','{{ url('/') }}/admin/exportWinnerReport/excel/'+$('.fromDate').val()+'/'+$('.toDate').val()).append($('<i></i>').attr('class','fa fa-file-excel-o').css('font-size','2em')))
                                $.each(data.winners, function (i, item) {
                                    var table = $('<table></table>').addClass('table table-bordered table-striped table-condensed flip-content');
                                    var body1 = $('<tbody></tbody>')
                                    body1.append($('<tr></tr>').css({"background-color":"#81d4fa", "color":"white"}).append($('<th></th>').text('@lang('lang.company_account')').attr('colspan', '6')))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.company_name')')).append($('<td></td>').attr('colspan', '5').text(item.company.name)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.address')')).append($('<td></td>').attr('colspan', '5').text(item.company.address)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.city_ar')')).append($('<td></td>').attr('colspan', '2').text(item.company.city)).append($('<th></th>').text('@lang('lang.country_ar')')).append($('<td></td>').attr('colspan', '3').text(item.company.country)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.E-mail')')).append($('<td></td>').attr('colspan', '5').text(item.company.email)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.salesRepresentativeName')')).append($('<td></td>').attr('colspan', '2').text(item.company.sales_r_name)).append($('<th></th>').text('@lang('lang.salesRepresentativeMobile')')).append($('<td></td>').attr('colspan', '3').text(item.company.sales_r_mobile)))
                                    body1.append($('<tr></tr>').css({"background-color":"#1de9b6", "color":"white"}).append($('<th></th>').text('@lang('lang.productDetails')').attr('colspan', '6')))
                                    $.each(item.offerItem, function (i, item) {
                                        body1.append($('<tr></tr>').css({"background-color":"#cfd8dc", "color":"white"}).append($('<th></th>').text('@lang('lang.item')').css({"color":"black"})).append($('<td></td>').attr('colspan', '2').text(item.name)).append($('<th></th>').text('@lang('lang.date')').css({"color":"black"})).append($('<td></td>').attr('colspan', '2').text(item.created_date)))
                                        body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.category')')).append($('<td></td>').attr('colspan', '5').text(item.category)))
                                        body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.currency')')).append($('<td></td>').attr('colspan', '5').text(item.currency)))
                                        body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.quantity')')).append($('<td></td>').text(item.quantity))
                                            .append($('<th></th>').text('@lang('lang.price')')).append($('<td></td>').text(item.price))
                                            .append($('<th></th>').text('@lang('lang.total')')).append($('<td></td>').text(item.total))
                                        )
                                    })
                                    table.append(body1)
                                    $('#tables').append(table)
                                });
                            }
                        }
                    },
                    complete:function(){
                        $("#wait").css("display", "none");
                    }
                })
            }
        })

    </script>
@endsection