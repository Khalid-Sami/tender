@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.newOffer')}}
@endsection
@section('title')
    {!!  trans('lang.newOffer')!!}
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

    <form method="POST" id="newOfferForm" action="{{ action('ServiceProviderController@addNewOffer') }}" enctype="multipart/form-data">

        <div class="row portlet-body form-group">

            <div class="col-sm-12">
                <div class="form-group col-md-12">
                    <label for="offerTitle" class="control-label">{{ trans('lang.offerTitle') }}</label>
                    <input id="offerTitle" name="offerTitle" type="text" class="form-control">
                    <div id="offerTitle_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-12">
                    <label for="editor1" class="control-label">{{ trans('lang.offerDetails') }}</label>
                    <textarea id="editor1" class="wysihtml5 form-control" rows="6" name="editor1" data-error-container="#editor1_error"></textarea>
                    <div id="editor1_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-md-12">
                    <label for="offerFile" class="control-label">{{ trans('lang.attachFile') }}: </label>
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
                                                                <input type="file" name="offerFile" id="offerFile"> </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">{{ trans('lang.remove') }}</a>
                        </div>
                    </div>
                    <div id="offerFile_validate" class="font-red"></div>
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
                            <col width="2%">
                            <!--<col width="50px">-->
                            <col width="15%">
                            <col width="9%">
                            <col width="9%">
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
                            <th>{{ trans('lang.price') }}</th>
                            <th>{{ trans('lang.total') }}</th>
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
            $('#selectCategory').on('change', function (event) {
                $('#selectItems').find('option').not(':first').remove();
                if($(this).val() != ""){
                    $.ajax({
                        method:'GET',
                        dataType: 'json',
                        url: '{{url('/')}}/serviceProvider/' + $(this).val() + '/getItems',
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
                $('#selectItems').val('')
                $('#selectItems').select2()
            })

            $('#offerFile').on('change', function(evt) {
                $('.listFiles').find('a').remove();
                for (var x = 0; x < $(this)[0].files.length; x++) {
                    var f = evt.target.files[x];
                    $('.listFiles').append('<a class="item">' + f.name + ' (' + f.size + ')</a>');
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
                        '<td><input name="price['+(parseInt(index)+1)+']" type="text" class="form-control price"></td>',
                        '<td class="itemTotal">0</td>',
                        '<td><input name="itemNotes['+(parseInt(index)+1)+']" type="text" class="form-control itemNotes">' +
                        '<input type="hidden" name="ids['+(parseInt(index)+1)+']" value="'+id+'">' +
                        '</td>',
                        '</tr>'
                    ].join(''));
                }
            });
            $('.submitForm').click(function () {
                $("#newOfferForm").validate();
                $("[name^=quantityItem]").each(function(){
                    $(this).rules("add", {
                        required: true,
                        number: true
                    });
                });

                $("[name^=price]").each(function(){
                    $(this).rules("add", {
                        required: true,
                        number: true
                    });
                });

                $('#offerFile').rules('add',{
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

            $('#newOfferForm').validate({
                rules: {
                    offerTitle: "required",
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
                    offerTitle: "عنوان العرض حقل مطلوب",
                    currency : "العملة حقل مطلوب",
                    selectItems : {
                        required: "الرجاء اختيار منتج واحد على الأقل",
                    },
                    @else
                    offerTitle: "Offer title field is required",
                    currency: "Currency field is required",
                    selectItems: {
                        required: "Please select items .. at least one !",
                    }
                    @endif
                }, submitHandler: function (form) {
                    form.submit();
                }
            });

            $('body').on('keyup','.price',function (){
                $(this).rules("add", {
                    required: true,
                    number: true
                });
                if($(this).valid()){
                    var value = parseFloat($(this).closest('tr').find('.quantityItem').val()) * parseFloat($(this).val())
                    $(this).closest('tr').find('.itemTotal').text(value)
                }
                else {
                    $(this).closest('tr').find('.itemTotal').text(0)
                }
            });
        })
    </script>
@endsection