@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.supplierReports')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.supplierReports')}}
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
                    <h3 class="panel-title">@lang('lang.supplierReport')</h3>
                </div>
                <div class="panel-body">
                    <div class="categories">
                        <div class="form-group col-sm-3 selectCategory">
                            <label name="category">{{ trans('lang.category') }}</label>
                            <select style="" id="" name="" class="form-control select category">
                                <option value="" selected>{{ trans('lang.selectCategory') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
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
                        <i class="fa fa-cogs"></i>@lang('lang.supplierReport')</div>
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
        $('body').on('change','.category',function () {
            $(this).closest('.selectCategory').nextAll('.selectCategory').remove()
            $('#showBTN').prop('disabled', true);
            var val = $(this).val()
            var text = $(this).find("option:selected").text()
            if(val != "" && val != 0){
                $.ajax({
                    method: "GET",
                    dataType: "json",
                    url: '{{url('/')}}/admin/' + val + '/getSubCategories',
                    data: {
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (data) {
                        $('#showBTN').prop('disabled', false);
                        if(data.status == 1){
                            var div = $('<div></div>').attr('class','form-group col-sm-3 selectCategory')
                            var label = $('<label></label>').attr('name','category').text('@lang('lang.subCategories') / '+text)
                            var selectTag = $('<select></select>').attr('class','form-control select category')
                            selectTag.append($('<option></option>').attr('value',"").text("@lang('lang.selectCategory')"))
                            $.each(data.subCategories, function (i, item) {
                                selectTag.append($('<option></option>').attr('value',item.id).text(item.name))
                            });
                            div.append(label)
                            div.append(selectTag)
                            $('.categories').append(div)
                            $('.select').select2()
                        }
                    }
                })
            }
            else{
                $('#showBTN').prop('disabled', false);
            }
        })

//        $(document).ready(function(){
//            $(document).ajaxStart(function(){
//                $('#tablesBody').addClass('hidden')
//                $("#wait").css("display", "block");
//            });
//            $(document).ajaxComplete(function(){
//                $("#wait").css("display", "none");
//                $('#tablesBody').removeClass('hidden')
//            });
//        });

        $('#showBTN').click(function () {
            var value = "";
            $('.selectCategory').each(function () {
                var val = $(this).find('.select').val()
                if(val != "")
                    value = val
            })
           $('#tables').empty()
            $('.icons').empty()
            $('#tablesBody').addClass('hidden')
            if(value != ""){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/admin/' + value + '/supplierReport',
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
                                $('.icons').append(($('<a></a>').attr('class', 'exportPDF').attr('href','{{ url('/') }}/admin/exportSupplierReport/pdf/'+value).append($('<i></i>').attr('class','fa fa-file-pdf-o').css('font-size','2em')))).append(" ")
                                    .append($('<a></a>').attr('class', 'exportExcel').attr('href','{{ url('/') }}/admin/exportSupplierReport/excel/'+value).append($('<i></i>').attr('class','fa fa-file-excel-o').css('font-size','2em')))
                                $.each(data.providers, function (i, item) {
                                    var total = 0;
                                    var table = $('<table></table>').addClass('table table-bordered table-striped table-condensed flip-content');
                                    var body1 = $('<tbody></tbody>')
                                    body1.append($('<tr></tr>').css({"background-color":"#81d4fa", "color":"white"}).append($('<th></th>').text('@lang('lang.company_account')').attr('colspan', '6')))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.company_name')')).append($('<td></td>').attr('colspan', '5').text(item.name)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.address')')).append($('<td></td>').attr('colspan', '5').text(item.address)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.city_ar')')).append($('<td></td>').attr('colspan', '2').text(item.city)).append($('<th></th>').text('@lang('lang.country_ar')')).append($('<td></td>').attr('colspan', '3').text(item.country)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.E-mail')')).append($('<td></td>').attr('colspan', '5').text(item.email)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.salesRepresentativeName')')).append($('<td></td>').attr('colspan', '2').text(item.salesRepresentativeName)).append($('<th></th>').text('@lang('lang.salesRepresentativeMobile')')).append($('<td></td>').attr('colspan', '3').text(item.salesRepresentativeMobile)))
                                    body1.append($('<tr></tr>').append($('<th></th>').text('@lang('lang.status')')).append($('<td></td>').attr('colspan', '5').text(item.status)))
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