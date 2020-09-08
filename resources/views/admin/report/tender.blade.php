@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.tenderReports')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.tenderReports')}}
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
        <a href="{{ action('AdminController@tryPusher') }}">pusher</a>
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@lang('lang.tenderReports')</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-6 col-md-offset-2" style="display:flex;">
                            <strong style="">@lang('lang.tender')</strong>
                            <select style="" id="tenders" name="" class="form-control select">
                                <option value="">{{ trans('lang.selectTender') }}</option>
                                @foreach($tenders as $tender)
                                    <option value="{{ $tender->id }}">{{ $tender->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-primary" id="showBTN" style="">@lang('lang.show')</a>
                        </div>
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
                        <i class="fa fa-cogs"></i>@lang('lang.tenderReport')</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                        {{--<div id="editor"></div>--}}
                    </div>
                </div>
                <div class="portlet-body flip-scroll">
                    <div class="icons" style="float: @if(app()->getLocale() == 'en') right @else left @endif">
                        {{--<a class="exportPDF"><i class="fa fa-file-pdf-o" style="font-size: 2em"></i></a>--}}
                        {{--<a class="exportExcel"><i class="fa fa-file-excel-o" style="font-size: 2em"></i></a>--}}
                        {{--<a href="{{ action('AdminController@tryReport') }}"><i class="fa fa-file-excel-o" style="font-size: 2em"></i></a>--}}
                    </div>
                    <div class="table-scrollable" id="tables">

                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    <a href="{{ action('AdminController@exportTenderReport') }}">pdf</a>--}}
@endsection
@section('scripts')
    <script>

        {{--$('body').on('click','.exportPDF',function () {--}}
            {{--$.ajax({--}}
                {{--method: "GET",--}}
                {{--dataType: "json",--}}
                {{--url: "{{ url('/') }}/admin/exportTenderReport/pdf/"+$('#tenders').val(),--}}
                {{--data: {--}}
                    {{--"_token": "{{csrf_token()}}"--}}
                {{--},--}}
                {{--success: function () {--}}

                {{--}--}}
            {{--})--}}
        {{--})--}}
        
        {{--$('.exportPDF').click(function () {--}}
            {{--$.ajax({--}}
                {{--method: "GET",--}}
                {{--dataType: "json",--}}
                {{--url: "{{ url('/') }}/admin/exportTenderReport/pdf/"+$('#tenders').val(),--}}
                {{--data: {--}}
                    {{--"_token": "{{csrf_token()}}"--}}
                {{--},--}}
                {{--success: function () {--}}

                {{--}--}}
            {{--})--}}
        {{--})--}}

        {{--$('.exportExcel').click(function () {--}}
            {{--$.ajax({--}}
                {{--method: "GET",--}}
                {{--dataType: "json",--}}
                {{--url: "{{ url('/') }}/admin/exportTenderReport/excel/"+$('#tenders').val(),--}}
                {{--data: {--}}
                    {{--"_token": "{{csrf_token()}}"--}}
                {{--},--}}
                {{--success: function () {--}}

                {{--}--}}
            {{--})--}}
        {{--})--}}

        $(document).ready(function(){
            $(document).ajaxStart(function(){
                $('.icons').empty()
                $('#tablesBody').addClass('hidden')
                $("#wait").css("display", "block");
            });
            $(document).ajaxComplete(function(){
                $("#wait").css("display", "none");
                $('#tablesBody').removeClass('hidden')
            });
        });

//        var doc = new jsPDF();
//        var specialElementHandlers = {
//            '#editor': function (element, renderer) {
//                return true;
//            }
//        };
//
//        $('#cmd').click(function () {
//            doc.fromHTML($('#tryTable').html(), 15, 15, {
//                'width': 170,
//                'elementHandlers': specialElementHandlers
//            });
//            doc.save('tables.pdf');
//        })

        $('#showBTN').click(function () {
             $('#tables').empty()
            $('.icons').empty()
            $('#tablesBody').addClass('hidden')
            if($('#tenders').val() != ""){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/admin/' + $('#tenders').val() + '/tenderReport',
                    data:{
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.status){
                            if(data.found){
                                $('.icons').append(($('<a></a>').attr('class', 'exportPDF').attr('href','{{ url('/') }}/admin/exportTenderReport/pdf/'+$("#tenders").val()).append($('<i></i>').attr('class','fa fa-file-pdf-o').css('font-size','2em')))).append(" ")
                                    .append($('<a></a>').attr('class', 'exportExcel').attr('href','{{ url('/') }}/admin/exportTenderReport/excel/'+$('#tenders').val()).append($('<i></i>').attr('class','fa fa-file-excel-o').css('font-size','2em')))
                                var table = $('<table></table>').addClass('table table-bordered table-striped table-condensed flip-content');
                                var body = $('<tbody></tbody>')
                                body.append($('<tr></tr>').css({"background-color":"#4db6ac", "color":"white"}).append($('<th></th>').text('@lang('lang.tenderDetails')').attr('colspan', '6')))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.tender')')).append($('<td></td>').attr('colspan', '3').text(data.tender.title)))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.tenderStartDate')')).append($('<td></td>').attr('colspan', '3').text(data.tender.odate)))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.tenderEndDate')')).append($('<td></td>').attr('colspan', '3').text(data.tender.cdate)))
                                body.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.currency')')).append($('<td></td>').attr('colspan', '3').text(data.tender.currencyName)))
                                body.append($('<tr></tr>').css({"background-color":"#4db6ac", "color":"white"}).append($('<th></th>').attr('colspan', '4').text('@lang('lang.approval')')))
                                body.append($('<tr></tr>')
                                    .append($('<th></th>').text('@lang('lang.company')')).append($('<td></td>').text(function () {
                                        if(data.tender.acceptOffer != ""){
                                            return data.tender.acceptOffer.companyName;
                                        } else{
                                            return "-----"
                                        }
                                    }))
                                    .append($('<th></th>').text('@lang('lang.date')')).append($('<td></td>').text(function () {
                                        if(data.tender.acceptOffer != ""){
                                            return data.tender.acceptOffer.date;
                                        } else{
                                            return "-----"
                                        }
                                    }))
                                )
                                table.append(body)
//                        $('#tables').append($('<div></div>').css('margin-bottom', '5%').append(table))
                                $('#tables').append(table)
                                $.each(data.proposals, function (i, item) {
                                    var total = 0;
                                    var table = $('<table></table>').addClass('table table-bordered table-striped table-condensed flip-content');
                                    var body1 = $('<tbody></tbody>')
                                    body1.append($('<tr></tr>').css({"background-color":"#81d4fa", "color":"white"}).append($('<th></th>').text('@lang('lang.company_account')').attr('colspan', '6')))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.company_name')')).append($('<td></td>').attr('colspan', '5').text(item.companyInfo.s_name)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.address')')).append($('<td></td>').attr('colspan', '5').text(item.companyInfo.s_address_ar)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.city_ar')')).append($('<td></td>').attr('colspan', '2').text(item.companyInfo.city.s_name)).append($('<th></th>').text('@lang('lang.country_ar')')).append($('<td></td>').attr('colspan', '3').text(item.companyInfo.country.s_name)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.E-mail')')).append($('<td></td>').attr('colspan', '5').text(item.companyInfo.s_email)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.phone')')).append($('<td></td>').text(item.companyInfo.s_telephone_number)).append($('<th></th>').text('@lang('lang.mobile')')).append($('<td></td>').text(item.companyInfo.s_mobile_number)).append($('<th></th>').text('@lang('lang.fax')')).append($('<td></td>').text(item.companyInfo.s_fax)))
                                    table.append(body1)
                                    var body2 = $('<tbody></tbody>')
                                    body2.append($('<tr></tr>').css({"background-color":"#81d4fa", "color":"white"}).append($('<th></th>').text('@lang('lang.items')').attr('colspan', '6')))
                                    body2.append($('<tr></tr>')
                                        .append($('<th></th>').text('@lang('lang.item') #'))
                                        .append($('<th></th>').text('@lang('lang.item')'))
                                        .append($('<th></th>').text('@lang('lang.Notes')'))
                                        .append($('<th></th>').text('@lang('lang.quantity')'))
                                        .append($('<th></th>').text('@lang('lang.unitCost')'))
                                        .append($('<th></th>').text('@lang('lang.totalCost')'))
                                    )
                                    $.each(item.proposalItem, function (i, item) {
                                        total = parseFloat(total) + parseFloat(item.d_price) * parseFloat(item.tender_items.i_quantity)
                                        body2.append($('<tr></tr>')
                                            .append($('<td></td>').text(i+1))
                                            .append($('<td></td>').text(item.tender_items.item.s_name))
                                            .append($('<td></td>').text(item.s_note))
                                            .append($('<td></td>').text(item.tender_items.i_quantity))
                                            .append($('<td></td>').text(item.d_price))
                                            .append($('<td></td>').text(parseFloat(item.d_price) * parseFloat(item.tender_items.i_quantity)))
                                        )
                                    })
                                    body2.append($('<tr></tr>').append($('<td></td>').attr('colspan', '4')).append($('<th></th>').text('@lang('lang.total')')).append($('<td></td>').text(total)))
                                    table.append(body2)

//                            $('#tables').append($('<div></div>').css('margin-bottom', '5%').append(table))
                                    $('#tables').append(table)
                                });
                            }
                        }
                    }
                })
            }
        })

    </script>
@endsection