@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.newReverseAuction')}}
@endsection
@section('title')
    {!!  trans('lang.newReverseAuction')!!}
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

    <form method="POST" id="newReverseAuctionForm" action="{{ action('AdminController@addNewReverseAuction') }}" enctype="multipart/form-data">

        <div class="row portlet-body form-group">

            <div class="col-sm-12">
                <div class="form-group col-md-12">
                    <label for="reverseAuctionTitle" class="control-label">{{ trans('lang.reverseAuctionTitle') }}</label>
                    <input id="reverseAuctionTitle" name="reverseAuctionTitle" type="text" class="form-control">
                    <div id="reverseAuctionTitle_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-6">
                    <label for="startDatepicker" class="control-label">{{ trans('lang.reverseAuctionStartDate') }} / (GMT +02:00) Jerusalem</label>
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
                    <label for="endDatepicker" class="control-label">{{ trans('lang.reverseAuctionEndDate') }} / -(GMT +02:00)- Jerusalem</label>
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
                    <label for="editor1" class="control-label">{{ trans('lang.reverseAuctionDetails') }}</label>
                    <textarea id="editor1" class="wysihtml5 form-control" rows="6" name="editor1" data-error-container="#editor1_error"></textarea>
                    <div id="editor1_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-12">
                    <label for="reverseAuctionTerms" class="control-label">{{ trans('lang.reverseAuctionTerms') }}</label>
                    <textarea id="reverseAuctionTerms" class="wysihtml5 form-control" rows="6" name="reverseAuctionTerms" data-error-container="#reverseAuctionTerms_error"></textarea>
                    <div id="reverseAuctionTerms_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-md-12">
                    <label for="reverseAuctionTitle" class="control-label">{{ trans('lang.attachFile') }}: </label>
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
                                                                <input type="file" name="reverseAuctionFile[]" id="reverseAuctionFile" multiple=""> </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">{{ trans('lang.remove') }}</a>
                        </div>
                    </div>
                    <div id="reverseAuctionFile_validate" class="font-red"></div>
                </div>
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
                            <col width="20%">
                            <col width="12%">
                            <col width="10%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                        <tr style="background-color: #3e3e3e;color: white;text-align: center">
                            <th></th>
                            <th>{{ trans('lang.product') }}</th>
                            <th>{{ trans('lang.unit') }}</th>
                            <th>{{ trans('lang.quantity') }}</th>
                            <th>{{ trans('lang.Notes') }}</th>
                        </tr>
                        </thead>
                        <tbody id="itemsContentBody">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-offset-5" style="margin-top: 20px;">
                    <input type="submit" value="{{trans('lang.save')}}" class="btn green submitForm col-sm-3">
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

            $('#reverseAuctionFile').on('change', function(evt) {
                $('.listFiles').find('a').remove();
                for (var x = 0; x < $(this)[0].files.length; x++) {
                    var f = evt.target.files[x];
                    $('.listFiles').append('<a class="item">' + f.name + ' (' + f.size + ')</a>');
                }

            });

            $('.submitForm').click(function () {
                $("#newReverseAuctionForm").validate();
                $("[name=quantityItem]").each(function(){
                    $(this).rules("add", {
                        required: true,
                        number: true
                    });
                });

                $('#reverseAuctionFile').rules('add',{
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

            $('#newReverseAuctionForm').validate({
                rules: {
                    reverseAuctionTitle: "required",
                    startDate: "required",
                    endDate: "required",
                    currency: "required",
                    selectItems: {
                        required: function () {
                            if($('#itemsTable >tbody >tr').length == 0)
                                return true;
                            return false
                        },
                    }
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("id");
                    error.appendTo($("#" + name + "_validate"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    reverseAuctionTitle: "عنوان المزاد حقل مطلوب",
                    startDate: "تاريخ بداية المزاد حقل مطلوب",
                    endDate: " تاريخ نهاية المزاد حقل مطلوب",
                    currency : "العملة حقل مطلوب",
                    selectItems : {
                        required: "الرجاء اختيار منتج واحد على الأقل",
                    },
                    @else
                    reverseAuctionTitle: "Auction title field is required",
                    startDate: "Auction start date field is required",
                    endDate: "Auction end date field is required",
                    currency: "Currency field is required",
                    selectItems: {
                        required: "Please select items .. at least one !",
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
                $('#itemsTable >tbody >tr').remove()

                if($(this).val() != "" && !status){
                    $('#itemsTable tbody').append([
                        '<tr id="'+id+'">',
                        '<td></td>',
                        '<td>'+text+'</td>',
                        '<td>'+unit+'</td>',
                        '<td><input name="quantityItem" type="text" class="form-control quantityItem"></td>',
                        '<td><input name="itemNotes" type="text" class="form-control itemNotes">' +
                        '<input type="hidden" name="ids" value="'+id+'">' +
                        '</td>',
                        '</tr>'
                    ].join(''));
                }


            });

        })
    </script>
@endsection