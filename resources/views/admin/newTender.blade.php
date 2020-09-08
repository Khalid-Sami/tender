@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.newTender')}}
@endsection
@section('title')
    {!!  trans('lang.newTender')!!}
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

    <form method="POST" id="newTenderForm" action="{{ action('AdminController@addNewTender') }}" enctype="multipart/form-data">

    <div class="row portlet-body form-group">

        <div class="col-sm-12">
            <div class="form-group col-md-12">
                <label for="tenderTitle" class="control-label">{{ trans('lang.tenderTitle') }}</label>
                <input id="tenderTitle" name="tenderTitle" type="text" class="form-control">
                <div id="tenderTitle_validate" class="font-red"></div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group col-sm-6">
                <label for="startDatepicker" class="control-label">{{ trans('lang.tenderStartDate') }} / (GMT +02:00) Jerusalem</label>
                <div class="input-group date form_meridian_datetime form_datetime bs-datetime" id="startDateTender" data-date="2017-06-11T15:25:00Z">
                    <input id="startDate" name="startDate" type="text" size="16" class="form-control" >
                    <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
                <div id="startDate_validate" class="font-red"></div>
            </div>
            <div class="form-group col-sm-6">
                <label for="endDatepicker" class="control-label">{{ trans('lang.tenderEndDate') }} / -(GMT +02:00)- Jerusalem</label>
                <div class="input-group date form_meridian_datetime form_datetime bs-datetime" data-date="2017-06-11T15:25:00Z">
                    <input id="endDate" name="endDate" type="text" size="16" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
                <div id="endDate_validate" class="font-red"></div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group col-sm-12">
                <label for="editor1" class="control-label">{{ trans('lang.tenderDetails') }}</label>
                {{--<textarea id="tenderDetails" name="markdown" data-provide="markdown" rows="5" data-error-container="#editor_error"></textarea>--}}
                <textarea id="editor1" class="wysihtml5 form-control" rows="6" name="editor1" data-error-container="#editor1_error"></textarea>
                <div id="editor1_validate" class="font-red"></div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group col-sm-12">
                <label for="tenderTerms" class="control-label">{{ trans('lang.tenderTerms') }}</label>
                {{--<textarea id="tenderDetails" name="markdown" data-provide="markdown" rows="5" data-error-container="#editor_error"></textarea>--}}
                <textarea id="tenderTerms" class="wysihtml5 form-control" rows="6" name="tenderTerms" data-error-container="#tenderTerms_error"></textarea>
                <div id="tenderTerms_validate" class="font-red"></div>
            </div>
        </div>

        <div class="col-sm-12">
            {{--<div class="form-group col-md-12">--}}
            <div class="col-md-12">
                <label for="tenderTitle" class="control-label">{{ trans('lang.attachFile') }}: </label>
            </div>
            <div class="col-md-6">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="input-group input-large">
                        <div class="form-control uneditable-input input-fixed input-medium">
                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                            <span class="fileinput-filename"> </span>
                        </div>
                        <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new">{{ trans('lang.selectFile') }}</span>
                                                                <span class="fileinput-exists">{{ trans('lang.change_file') }}</span>
                                                                <input type="file" name="tenderFile[]" id="fileTender" multiple=""> </span>
                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">{{ trans('lang.remove') }}</a>
                    </div>
                </div>
                <div id="fileTender_validate" class="font-red"></div>
            </div>
            {{--</div>--}}
        </div>
        <div class="col-sm-12">
            <div class="col-sm-12 listFiles">

            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group col-sm-12">
                <label for="currency" class="control-label">{{ trans('lang.currency') }}</label>
                <select id="currency" name="currency" class="form-control select">
                    <option value="">{{ trans('lang.selectCurrency') }}</option>
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->pk_i_id }}">{{ $currency->s_name }}</option>
                    @endforeach
                </select>
                <div id="currency_validate" class="font-red"></div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group col-sm-6">
                <label class="control-label">{{ trans('lang.category') }}</label>
                <?php
                    $cats = array();
                    foreach ($categories as $cat){
                        $cats[$cat->pk_i_id] = $cat->s_name;
                    }
                ?>
                {!! Form::select('selectCategory',[null=>trans('lang.selectCategory')]+$cats,null,['class'=>'form-control select','id'=>'selectCategory']) !!}
                <div id="selectCategory_validate" class="font-red"></div>
            </div>
            <div class="form-group col-sm-6">
                <label class="control-label">{{ trans('lang.items') }}</label>
                {{--<select name="selectItems" id="selectItems" class="js-example-basic-multiple" multiple="multiple">--}}
                    {{--@foreach($items as $item)--}}
                    {{--<option value="{{ $item->pk_i_id }}">{{ $item->s_name }}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
                {!! Form::select('selectItems',[null=>trans('lang.selectItem')],null,['class'=>'form-control select','id'=>'selectItems']) !!}
                <div id="selectItems_validate" class="font-red"></div>
            </div>
        </div>
        <div class="col-sm-12">

        </div>
        <div class="col-sm-12" style="padding-top: 50px">
            <div class="col-sm-12">
                <table id="itemsTable" class="col-sm-12" border="1" cellspacing="0">
                    <colgroup>
                        <col width="2%">
                        <col width="2%">
                        <!--<col width="50px">-->
                        <col width="15%">
                        <col width="9%">
                        <col width="9%">
                        <col width="30%">
                    </colgroup>
                    <thead>
                    <tr style="background-color: #3e3e3e;color: white;text-align: center">
                        <th></th>
                        <th>#</th>
                        <th>{{ trans('lang.product') }}</th>
                        <th>{{ trans('lang.unit') }}</th>
                        <th>{{ trans('lang.quantity') }}</th>
{{--                        <th style="text-align: center">{{ trans('lang.price') }}</th>--}}
{{--                        <th style="text-align: center">{{ trans('lang.total') }}</th>--}}
{{--                        <th style="text-align: center">{{ trans('lang.isDifferent') }}</th>--}}
                        <th>{{ trans('lang.Notes') }}</th>
                    </tr>
                    </thead>
                    <tbody id="itemsContentBody">
                    {{--<tr>--}}
                        {{--<td style="text-align: center">s</td>--}}
                        {{--<td style="text-align: center">z</td>--}}
                        {{--<td style="text-align: center">z</td>--}}
                        {{--<td style="text-align: center">z</td>--}}
                        {{--<td style="text-align: center">z</td>--}}
                        {{--<td style="text-align: center">z</td>--}}
                        {{--<td style="text-align: center">z</td>--}}
                        {{--<td style="text-align: center">z</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group col-sm-offset-5" style="margin-top: 20px;">
                <input type="submit" value="{{trans('lang.save')}}" class="btn green submitForm col-sm-3">
{{--                {!! Form::submit(trans('lang.save'),['class' => 'btn green submitForm']) !!}--}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </div>

    </div>

    </form>

@endsection
@section('scripts')
<script>
    $('#document').ready(function () {
        $('.alert-dismissible').delay(3000).fadeOut('slow');
        $('#selectCategory').on('change', function (event) {
            $('#selectItems').find('option').not(':first').remove();
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
                                $('#selectItems').append($("<option></option>").attr("value",item.pk_i_id).attr('data-unit',item['unit'].s_name).text(item.s_name));
                            });
                        }
                    }
                })
            }
        })

        $('body').on('click','.removeItem',function () {
            $(this).closest('tr').remove()
            $('#itemsTable >tbody >tr').each(function (index, elem) {
                $(this).find('td:eq(1)').text(index+1)
            })
        })

        $('#fileTender').on('change', function(evt) {
            $('.listFiles').find('a').remove();
            for (var x = 0; x < $(this)[0].files.length; x++) {
                var f = evt.target.files[x];
                $('.listFiles').append('<a class="item">' + f.name + ' (' + f.size + ')</a>');
            }

        });

//        $(".js-example-basic-multiple").select2();
//
//        $.validator.addMethod("callbackPage", function (value, element) {
//            return $('#itemsTable >tbody >tr').length > 0;
//        });

        $('.submitForm').click(function () {
            $("#newTenderForm").validate();
            $("[name^=quantityItem]").each(function(){
                $(this).rules("add", {
                    required: true,
                    number: true
                });
            });

            $('#fileTender').rules('add',{
                required: true,
                messages: {
                    @if(app()->getLocale() =='ar')
                    required: "الملف حقل مطلوب",
                    @else
                    required: "File field is required"
                    @endif
                }
            });

        })

        $('#newTenderForm').validate({
            rules: {
                tenderTitle: "required",
                startDate: "required",
                endDate: "required",
//                markdown: "required",
                currency: "required",
                selectItems: {
                    required: function () {
                        if($('#itemsTable >tbody >tr').length == 0)
                            return true;
                        return false
                    },
//                    callbackPage: true
                }
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("id");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() =='ar')
                tenderTitle: "عنوان المناقصة حقل مطلوب",
                startDate: "تاريخ بداية المناقصة حقل مطلوب",
                endDate: " تاريخ نهاية المناقصة حقل مطلوب",
//                markdown: "",
                currency : "العملة حقل مطلوب",
                selectItems : {
                    required: "الرجاء اختيار منتج واحد على الأقل",
//                    callbackPage: "يجب اعادة تحديد المنتجات او تحديثها !"
                },
                @else
                tenderTitle: "Tender title field is required",
                startDate: "Tender start date field is required",
                endDate: "Tender end date field is required",
                currency: "Currency field is required",
                selectItems: {
                    required: "Please select items .. at least one !",
//                    callbackPage: "You must be re-select items or updated !"
                }
                @endif
            }, submitHandler: function (form) {
                  form.submit();
            }
        });


        $('#selectItems').change(function(){
            var unit = $(this).find('option:selected').data('unit')
            var id = $(this).find('option:selected').val()
            var text = $(this).find('option:selected').text()
            var index = 0;
            if($('#itemsTable >tbody >tr').length > 0){
                index = $('#itemsTable >tbody >tr:last').find('td:eq(1)').text()
            }
            var ids = []
            var status = false;

            $('#itemsTable >tbody >tr').each(function () {
                ids.push($(this).attr('id'))
            })

            jQuery.each(ids, function(index, item) {
                if(id == item)
                    status = true
            });

            if($(this).val() != "" && !status){
                $('#itemsTable tbody').append([
                '<tr id="'+id+'">',
                '<td><a class="removeItem"><span class="glyphicon glyphicon-remove-circle"></span></a></td>',
                '<td>'+(parseInt(index)+1)+'</td>',
                '<td>'+text+'</td>',
                '<td>'+unit+'</td>',
                '<td><input name="quantityItem['+(parseInt(index)+1)+']" type="text" class="form-control quantityItem"></td>',
                '<td><input name="itemNotes['+(parseInt(index)+1)+']" type="text" class="form-control itemNotes">' +
                '<input type="hidden" name="ids['+(parseInt(index)+1)+']" value="'+id+'">' +
                '</td>',
                '</tr>'
                ].join(''));
            }
            {{--var itemsVal = [];--}}
            {{--var itemsText = [];--}}
            {{--$('#selectItems :selected').each(function(i, selected){--}}
                {{--itemsVal[i] = $(selected).val();--}}
                {{--itemsText[i] = $(selected).text();--}}
            {{--});--}}
            {{--if(itemsVal.length == 0)--}}
                {{--$("#itemsContentBody").empty();--}}

            {{--if(itemsVal.length > 0){--}}
                {{--$.ajax({--}}
                    {{--method:'GET',--}}
                    {{--dataType: 'json',--}}
                    {{--url: '{{url('/')}}/admin/itemDetails',--}}
                    {{--data:{--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                        {{--'itemsVal': itemsVal--}}
                    {{--},--}}
                    {{--success: function (data, textStatus, jqXHR) {--}}
                        {{--$("#itemsContentBody").empty();--}}
                        {{--$.each(data.items, function (i, item) {--}}
{{--//                            $('#city').append($('<option>', {--}}
{{--//                                value: item.pk_i_id,--}}
{{--//                                text : function () {--}}
{{--//                                    return item.s_name--}}
{{--//                                }--}}
{{--//                            }));--}}
                            {{--$('#itemsTable tbody').append([--}}
                                {{--'<tr id="'+item.itemID+'">',--}}
                                {{--'<td>'+(i+1)+'</td>',--}}
                                {{--'<td>'+item.itemName+'</td>',--}}
                                {{--'<td>'+item.itemUnit+'</td>',--}}
                                {{--'<td><input name="quantityItem['+(i+1)+']" type="text" class="form-control quantityItem"></td>',--}}
                                {{--'<td><input name="itemNotes['+(i+1)+']" type="text" class="form-control itemNotes">' +--}}
                                {{--'<input type="hidden" name="ids['+(i+1)+']" value="'+item.itemID+'">' +--}}
                                {{--'</td>',--}}
                                {{--'</tr>'--}}
                            {{--].join(''));--}}
                        {{--});--}}
                    {{--}--}}
                {{--})--}}
            {{--}--}}



        });


//        $("#tenderDetails").markdown({autofocus:true,savable:true})
    })
</script>
@endsection