@extends('_layout')
@section('styles')
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
@endsection

@section('title')
    {{trans('lang.addNewItem')}}
@endsection
@section('head_title')
    {{trans('lang.newItems')}}
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
    <div class="col-sm-6 col-sm-offset-3 alert alert-danger alert-dismissible text-center" id="alreadyExistItem" style="display: none;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ trans('lang.alreadyExistItem') }}
    </div>
    <div class="col-sm-6 col-sm-offset-3 alert alert-danger alert-dismissible text-center" id="alreadyExistItemBarcode" style="display: none;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ trans('lang.itemBarcodeAlreadyExist') }}
    </div>
    {{--@if(session('alreadyExistItem'))--}}
        {{--<div class="alert alert-success alert-dismissible text-center" style=" position: absolute;width: 100%;z-index: 1;">--}}
            {{--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
            {{--{{ trans('lang.alreadyExistItem') }}--}}
        {{--</div>--}}
    {{--@endif--}}
{{--    {!! Form::model(['id'=>'newItemForm','method' => 'POST', 'action' =>['AdminController@addNewItem'],'files' => true]) !!}--}}
    <form method="POST" id="newItemForm" action="{{ action('AdminController@addNewItem') }}">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group col-md-6">
                    <label name="s_name_ar" class="control-label">{{ trans('lang.itemNameAr') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::text('s_name_ar',null,['class' => 'form-control']) !!}
                    @if($errors->has('s_name_ar'))
                        <strong class="font-red">{{ $errors->first('s_name_ar') }}</strong>
                    @endif
                    <div id="s_name_ar_validate" class="font-red"></div>
                </div>
                <div class="form-group col-md-6">
                    <label name="s_name_en" class="control-label">{{ trans('lang.itemNameEn') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::text('s_name_en',null,['class' => 'form-control']) !!}
                    @if($errors->has('s_name_en'))
                        <strong class="font-red">{{ $errors->first('s_name_en') }}</strong>
                    @endif
                    <div id="s_name_en_validate" class="font-red"></div>

                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group col-md-6">
                    <label name="i_type" class="control-label">{{ trans('lang.itemType') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::select('i_type',[null=>trans('lang.selectItemType')],null,['class'=>'form-control select','id' => 'itemType']) !!}
                    <div id="i_type_validate" class="font-red"></div>
                </div>
                <div class="form-group col-md-6">
                    <label name="i_unit" class="control-label">{{ trans('lang.itemUnit') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::select('i_unit',[null=>trans('lang.selectItemUnit')],null,['class'=>'form-control select','id' => 'itemUnit']) !!}
                    <div id="i_unit_validate" class="font-red"></div>

                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group col-md-6">
                    <label name="d_price" class="control-label">{{ trans('lang.itemPrice') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::text('d_price',null,['class' => 'form-control']) !!}
                    <div id="d_price_validate" class="font-red"></div>
                </div>
                <div class="form-group col-md-6">
                    <label name="i_currency" class="control-label">{{ trans('lang.BankAccountCurrency') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::select('i_currency',[null=>trans('lang.selectCurrency')],null,['class'=>'form-control select','id' => 'itemCurrency']) !!}
                    <div id="i_currency_validate" class="font-red"></div>

                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group col-md-6">
                    <label name="s_barcode" class="control-label">{{ trans('lang.itemCode') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::text('s_barcode',null,['class' => 'form-control']) !!}
                    <div id="s_barcode_validate" class="font-red"></div>
                </div>
                <div class="form-group col-md-6">
                    <label name="s_brand" class="control-label">{{ trans('lang.itemBrand') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::text('s_brand',null,['class' => 'form-control']) !!}
                    <div id="s_brand_validate" class="font-red"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group col-md-12">
                    {!! Form::label('c_status',trans('lang.status')) !!}
                    <span class="required font-red">*</span>
                    <?php
                    $status;
                    if (app()->getLocale() == 'en') {
                        $status = array('' => 'Choose Option', '1' => 'enable', '0' => 'disable');
                    } else {
                        $status = array('' => 'اختار من القائمة', '1' => 'فعال', '0' => 'غير فعال');
                    }

                    ?>

                    {!! Form::select('c_status',isset($status)?$status:[],null,['class'=>'form-control select','id'=>'country_status']) !!}
                    <div id="c_status_validate" class="font-red"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group col-md-6 CategoriesSelect">
                    <label name="itemNameAr" class="control-label">{{ trans('lang.category') }}</label>
                    <span class="required font-red">*</span>
                    {!! Form::select('superCategory',[null=>trans('lang.selectCategory')],null,['class'=>'form-control select categorySelect','id' => 'superCategory']) !!}
                    {{--<select name="superCategory" id="superCategory" class="form-control select2 categorySelect">--}}
                        {{--<option value="">{{ trans('lang.selectCategory') }}</option>--}}
                    {{--</select>--}}
                    <div id="superCategory_validate" class="font-red"></div>

                </div>
                <div class="form-group col-md-6 CategoriesSelect">
                    <label name="itemNameAr" class="control-label">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                    {{--<span class="required font-red">*</span>--}}
                    {!! Form::select('subCategory1',[null=>trans('lang.selectCategory')],null,['class'=>'form-control select categorySelect','id' => 'subCategoryLevel1']) !!}
                    <div id="subCategory1_validate" class="font-red"></div>
                </div>
                <div class="form-group col-md-6 CategoriesSelect">
                    <label name="itemNameAr" class="control-label">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                    {{--<span class="required font-red">*</span>--}}
                    {!! Form::select('subCategory2',[null=>trans('lang.selectCategory')],null,['class'=>'form-control select categorySelect','id' => 'subCategoryLevel2']) !!}
                    <div id="subCategory2_validate" class="font-red"></div>
                </div>
                <div class="form-group col-md-6 CategoriesSelect">
                    <label name="itemNameAr" class="control-label">{{ trans('lang.subCategories') }} / <cite class="superCategory"></cite></label>
                    {{--<span class="required font-red">*</span>--}}
                    {!! Form::select('subCategory3',[null=>trans('lang.selectCategory')],null,['class'=>'form-control select categorySelect','id' => 'subCategoryLevel3']) !!}
                    <div id="subCategory3_validate" class="font-red"></div>
                </div>
            </div>

            {{--end inputs--}}
            <div class="col-sm-12">
                <div class="form-group col-md-4">
                    <label name="itemPhoto" class="control-label">{{ trans('lang.itemPhoto') }}</label>
                    <br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail"
                             style="width: 200px; height: 150px;">
{{--                            <img src="{{ isset($service_provider->s_image)?asset('/images/service_provider_images/'.$service_provider->s_image):asset('/images/items_images/defaultItem.png') }}"--}}
                            <img src="{{ asset('/images/items_images/defaultItem.png') }}"
                                 alt=""></div>
                        <div class="fileinput-preview fileinput-exists thumbnail"
                             style="max-width: 200px; max-height: 150px;"></div>
                        <div>
                                                                            <span class="btn default btn-file">
                                                                                <span class="fileinput-new"> {{trans('lang.select_image')}} </span>
                                                                                <span class="fileinput-exists"> {{ trans('lang.change_img') }} </span>
                                                                                <input type="file"
                                                                                       name="item_image"> </span>
                            <a href="javascript:;"
                               class="btn default fileinput-exists"

                               data-dismiss="fileinput">{{trans('lang.remove')}} </a>
                        </div>
                    </div>

                </div>
                <div class="form-group col-md-8">
                    <label name="s_description" class="control-label">{{ trans('lang.Notes') }}</label>
                    {{--<span class="required font-red">*</span>--}}
                    {!! Form::textarea('s_description',null,['class' => 'form-control']) !!}
                    {{--<div id="s_description_validate" class="font-red"></div>--}}

                </div>
            </div>
            <div class="form-group col-sm-3 col-sm-offset-4" style="margin-top: 10px;">
                {!! Form::submit(trans('lang.save'),['class' => 'btn green submitForm']) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </div>
{{--    {!! Form::close() !!}--}}
    </form>

@endsection
@section('scripts')

    <script>
        $('#document').ready(function () {
            $('.alert-dismissible').delay(3000).fadeOut('slow');
//            $('.newItemForm').click(function () {
//                $('#newItemForm').validate();
//            })

            $('.categorySelect').select2({
                allowClear:true,
                {{--                placeholder: '{{ trans('lang.category') }}'--}}
            });
            $.ajax({
                type: "GET",
                url: '{!! route('constantData.get',['ConstantView','ITEM_TYPE']) !!}',
                dataType:"json",
                success: function(data)
                {
                    $.each(data.itemsType, function (i, item) {
                        $('#itemType').append($('<option>', {
                            value: item.pk_i_id,
                            text : function () {
                                return item.s_name
                            }
                        }));
                    });
                    $.each(data.itemUnits, function (i, item) {

                        $('#itemUnit').append($('<option>', {
                            value: item.pk_i_id,
                            text : function () {
                                return item.s_name
                            }
                        }));

                    });
                    $.each(data.categories, function (i, item) {

                        $('#superCategory').append($('<option>', {
                            value: item.pk_i_id,
                            text : function () {
                                return item.s_name
                            }
                        }));
                    });

//                    $.each(data.status, function (i, item) {
//
//                        $('#superCategory').append($('<option>', {
//                            value: item.pk_i_id,
//                            text : function () {
//                                return item.s_name
//                            }
//                        }));
//                    });

                    $.each(data.currencies, function (i, item) {

                        $('#itemCurrency').append($('<option>', {
                            value: item.pk_i_id,
                            text : function () {
                                return item.s_name
                            }
                        }));
                    });

                }
            });
            $.validator.addMethod(
                "uniqueItemBarcode",
                function(value, element) {
                    var  response;
                    $.ajax({
                        type: "GET",
                        url: '{{url('/')}}/admin/checkBarcodeItem',
                        data: {'itemBarcode': value},
                        dataType:"json",
                        success: function(msg)
                        {
                            //If username exists, set response to true
                            var response = ( msg.status == true ) ? true : false;
                        }
                    });
                    return response;
                }
//                "ItemBarcode is Already Taken"
            );
            $('#newItemForm').validate({
                rules: {
                    s_name_ar: "required",
                    s_name_en: "required",
                    i_type: "required",
                    i_unit: "required",
                    d_price: {
                        required: true,
                        number: true
                    },
                    i_currency: "required",
                    s_barcode: {
                        required: true,
//                        uniqueItemBarcode: true
                    },
                    c_status: "required",
                    s_brand: {
                        required: true
                    },
                    superCategory: "required",
                    subCategory1: {
                        required: function () {
                            if($('#subCategoryLevel1 option').size() > 1){
                                return true;
                            }
                            return false;
                        }
                    },
                    subCategory2: {
                        required: function () {
                            if($('#subCategoryLevel2 option').size() > 1){
                                return true;
                            }
                            return false;
                        }
                    },
                    subCategory3: {
                        required: function () {
                            if($('#subCategoryLevel3 option').size() > 1){
                                return true;
                            }
                            return false;
                        }
                    }
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    error.appendTo($("#" + name + "_validate"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    s_name_ar: "اسم الصنف (عربي) حقل مطلوب",
                    s_name_en: "اسم الصنف (انجليزي) حقل مطلوب",
                    i_type: " نوع الصنف حقل مطلوب",
                    i_unit: "وحدة الصنف حقل مطلوب",
                    d_price : {
                        required: "سعر الصنف حقل مطلوب",
                        number: 'الرجاء ادخال قيمة صحيحة'
                    },
                    i_currency : "العملة حقل مطلوب",
                    s_barcode : {
                        required: " رمز الصنف حقل مطلوب",
                        uniqueItemBarcode: "الرمز موجود ! الرجاء ادخال رمز آخر"
                    },
                    c_status: 'الحالة حقل مطلوب',
                    s_brand: {
                        required: "العلامة التجارية حقل مطلوب"
                    },
                    superCategory : "التصنيف الأساسي حقل مطلوب",
                    subCategory1 : "التصنيف الفرعي حقل مطلوب",
                    subCategory2 : "التصنيف الفرعي حقل مطلوب",
                    subCategory3: "التصنيف الفرعي حقل مطلوب",
                    @else
                    s_name_ar: "Bank name (Arabic) field is required",
                    s_name_en: "Bank name (English) field is required",
                    i_type: "Item type field is required",
                    i_unit: "Item unit field is required",
                    d_price: {
                        required: "Item price field id required",
                        number: "Please enter valid input"
                    },
                    i_currency: "Item currency field id required",
                    s_barcode: {
                        required: "Item barcode field id required",
                        uniqueItemBarcode: "Barcode is Already Taken ! Please enter another barcode"
                    },
                    c_status: "Status field id required",
                    s_brand: {
                        required: "Brand field is required"
                    },
                    superCategory: "Category field id required",
                    subCategory1: "Sub Category field id required",
                    subCategory2: "Sub Category field id required",
                    subCategory3: "Sub Category field id required"
                    @endif
                }, submitHandler: function (form) {
                    $.ajax({
                        type: "GET",
                        url: '{{url('/')}}/admin/checkUniqueItem',
                        data: {
                            'itemNameAr': $('input[name="s_name_ar"]').val(),
                            'itemNameEn': $('input[name="s_name_en"]').val(),
                            'itemCode': $('input[name="s_barcode"]').val(),
                            'superCategory': $('select[name="superCategory"]').val(),
                            'subCategory1': $('select[name="subCategory1"]').val(),
                            'subCategory2': $('select[name="subCategory2"]').val(),
                        },
                        dataType:"json",
                        success: function(msg)
                        {
                            //If username exists, set response to true
                            //response = ( msg == 'true' ) ? true : false;
                            if(msg.msg == 0){
                                $('#alreadyExistItem').show();
                                $('.alert-dismissible').delay(3000).fadeOut('slow');
                                $('html,body').scrollTop(0);
                            }
                            else if(msg.msg == 1){
                                $('#alreadyExistItemBarcode').show();
                                $('.alert-dismissible').delay(3000).fadeOut('slow');
                                $('html,body').scrollTop(0);
                            }
                            else {
                                form.submit();
                            }

                        }
                    });

                }
            });
        })

    </script>
    <script>
        $('body').on('change', '.categorySelect', function () {
            var thisSelect = $(this).closest('.CategoriesSelect').next('.CategoriesSelect').find('select').attr('id');
            var text = $(this).find("option:selected").text();
            var status = false;
            if($(this).attr('id') != 'subCategoryLevel3'){
                $(this).closest('.CategoriesSelect').nextAll('.CategoriesSelect').each(function () {
                    $(this).find('.superCategory').empty();
                    $(this).find('select option').not(':first').remove();
                });
            }
            else{
                status = true;
            }
            if($(this).val() && !status){
                $.ajax({
                    method:'GET',
                    dataType: 'json',
                    url: '{{url('/')}}/' + $(this).val() + '/getSubCategories',
                    data:{
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('#'+thisSelect).closest('.CategoriesSelect').find('.superCategory').html(text);
                        if (data.status){
                                $.each(data.subCategories, function (i, item) {
                                    $('#'+thisSelect).append($("<option></option>").attr("value",item.pk_i_id).text(item.s_name));
                                });
                        }
                    }
                })
            }
        });
    </script>
@endsection

