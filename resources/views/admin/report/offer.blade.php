@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.offerReports')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.offerReports')}}
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
                    <h3 class="panel-title">@lang('lang.offerReport')</h3>
                </div>
                <div class="panel-body">
                    <div class="categories">
                        <div class="form-group col-sm-3 selectCategory">
                            <label name="category">{{ trans('lang.category') }}</label>
                            <select style="" id="" name="" class="form-control select category">
                                <option value="" selected>{{ trans('lang.selectCategory') }}</option>
                                @foreach($cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="items">
                        <div class="form-group col-sm-3 selectItem">
                            <label name="item">{{ trans('lang.items') }}</label>
                            <select style="" id="" name="" class="form-control select item">
                                <option value="" selected>{{ trans('lang.selectItem') }}</option>
                            </select>
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
                        <i class="fa fa-cogs"></i>@lang('lang.offerReport')</div>
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

        $('.category').on('change', function (event) {
            $('.item').find('option').not(':first').remove();
            if($(this).val() != ""){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/admin/' + $(this).val() + '/getItems',
                    data:{
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.status){
                            $.each(data.items, function (i, item) {
                                $('.item').append($("<option></option>").attr("value",item.pk_i_id).attr('data-unit',item['unit'].s_name).text(item.s_name));
                            });
                        }
                    }
                })
            }
        })

        $('#showBTN').click(function () {
            var value = $('.item').val()
            $('#tables').empty()
            $('.icons').empty()
            $('#tablesBody').addClass('hidden')
            if(value != ""){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/admin/' + value + '/offerReport',
                    data:{
                        "_token": "{{csrf_token()}}"
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
                                $('.icons').append(($('<a></a>').attr('class', 'exportPDF').attr('href','{{ url('/') }}/admin/exportOfferReport/pdf/'+value).append($('<i></i>').attr('class','fa fa-file-pdf-o').css('font-size','2em')))).append(" ")
                                    .append($('<a></a>').attr('class', 'exportExcel').attr('href','{{ url('/') }}/admin/exportOfferReport/excel/'+value).append($('<i></i>').attr('class','fa fa-file-excel-o').css('font-size','2em')))
                                var table = $('<table></table>').addClass('table table-bordered table-striped table-condensed flip-content');
                                var body = $('<tbody></tbody>')
                                body.append($('<tr></tr>').css({"background-color":"#4db6ac", "color":"white"}).append($('<th></th>').text('@lang('lang.productDetails')').attr('colspan', '6')))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.item')')).append($('<td></td>').attr('colspan', '5').text(data.item.name)))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.category')')).append($('<td></td>').attr('colspan', '5').text(data.item.category)))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.unit')')).append($('<td></td>').attr('colspan', '5').text(data.item.unit)))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.type')')).append($('<td></td>').attr('colspan', '5').text(data.item.type)))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.description')')).append($('<td></td>').attr('colspan', '5').text(data.item.description)))
                                {{--body.append($('<tr></tr>').css({"background-color":"#4db6ac", "color":"white"}).append($('<th></th>').attr('colspan', '4').text('@lang('lang.approval')')))--}}
                                table.append(body)
//                            $('#tables').append($('<div></div>').css('margin-bottom', '5%').append(table))
                                $('#tables').append(table)
                                $.each(data.offers, function (i, item) {
                                    var table = $('<table></table>').addClass('table table-bordered table-striped table-condensed flip-content');
                                    var body1 = $('<tbody></tbody>')
                                    body1.append($('<tr></tr>').css({"background-color":"#81d4fa", "color":"white"}).append($('<th></th>').text('@lang('lang.company_account')').attr('colspan', '6')))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.company_name')')).append($('<td></td>').attr('colspan', '5').text(item.company.name)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.address')')).append($('<td></td>').attr('colspan', '5').text(item.company.address)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.city_ar')')).append($('<td></td>').attr('colspan', '2').text(item.company.city)).append($('<th></th>').text('@lang('lang.country_ar')')).append($('<td></td>').attr('colspan', '3').text(item.company.country)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.E-mail')')).append($('<td></td>').attr('colspan', '5').text(item.company.email)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.salesRepresentativeName')')).append($('<td></td>').attr('colspan', '2').text(item.company.sales_r_name)).append($('<th></th>').text('@lang('lang.salesRepresentativeMobile')')).append($('<td></td>').attr('colspan', '3').text(item.company.sales_r_mobile)))
                                    body1.append($('<tr></tr>').css({"background-color":"#1de9b6", "color":"white"}).append($('<th></th>').text('@lang('lang.productDetails')').attr('colspan', '6')))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.item')')).append($('<td></td>').attr('colspan', '2').text(item.offerItem.name)).append($('<th></th>').text('@lang('lang.date')')).append($('<td></td>').attr('colspan', '2').text(item.offerItem.created_date)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.category')')).append($('<td></td>').attr('colspan', '5').text(item.offerItem.category)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.currency')')).append($('<td></td>').attr('colspan', '5').text(item.offerItem.currency)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.quantity')')).append($('<td></td>').text(item.offerItem.quantity))
                                        .append($('<th></th>').text('@lang('lang.price')')).append($('<td></td>').text(item.offerItem.price))
                                        .append($('<th></th>').text('@lang('lang.total')')).append($('<td></td>').text(item.offerItem.total))
                                    )

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