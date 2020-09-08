@extends('_layout')
@section('style')
    <style>
        .accordion-toggle {
            width: 100% !important;
        }
    </style>
@endsection
@section('title')
    {{trans('lang.add_service')}}
@endsection


@section('head_title')
    {{trans('lang.services')}}
@endsection
@section('msg')

    @if(session('msg'))
        <div class="alert alert-success alert-dismissible text-center"
             style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('msg') }}
        </div>
    @endif
    @if(session('error_msg'))
        <div class="alert alert-danger alert-dismissible text-center"
             style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('error_msg') }}
        </div>
    @endif

@endsection
@section('content')


    {!! Form::open(['id'=>'addServiceForm','method' => 'post','action'=>'ServiceProviderController@addServices']) !!}
    <div class="row">

        <div class="form-group col-sm-3">
            {!! Form::label('category',trans('lang.category')) !!}
            {!! Form::select('category',isset($category)?$category:[],null,['class'=>'form-control select category','id' => 'category']) !!}
             <div class="font-red" id="category_validate"></div>
        </div>
        <div class="form-group col-sm-3" id="serviceHtml">
            {!! Form::label('service',trans('lang.service')) !!}
            {!! Form::select('service',[],null,['class'=>'form-control select service','id' => 'service']) !!}
            <div class="font-red" id="service_validate"></div>

        </div>
        <div class="form-group col-sm-3">
            {!! Form::label('price',trans('lang.price')) !!}
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">DE</span>
                <input type="text" name="price" id="priceHtml" class="form-control" aria-describedby="basic-addon1">
            </div>
            <div class="font-red" id="price_validate"></div>

        </div>
        <div class="col-sm-3 form-group hidden" id="urgent" style="margin-top: 15px;">
            <div class="checkbox">
                <label><input name="urgent" id="urgentCheckbox" type="checkbox" value="0">@lang('lang.urgent_service')</label>
            </div>
        </div>
    </div>
    <div class="row" id="questionsHtml">

    </div>

    <div class="row">
        <div class="form-group col-sm-3">
            {!! Form::input('submit',null,trans('lang.add'), ['class' => 'btn green','style'=>'margin-top:24px;','id' => 'search']) !!}
        </div>
    </div>
{!! Form::close() !!}

@endsection
@section('scripts')
    <script>
        $('#addServiceForm').validate({
            rules: {
                category: "required",
                service: "required",
                number: {
                    required: true,
                    digits: true
                }
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
              @if(app()->getLocale() == 'en')
              category: "category is required field",
                service: "service is required field",
                price: {
                    required: "price is required field",
                    number: "price must contains numbers only and must be equal or greater than 0"
                },
                @else
                category: "التصنيف حقل مطلوب",
                service: "الخدمة حقل مطلوب",
                price: {
                    required: "السعر حقل مطلوب",
                    number: "السعر يجب ان يحتوي على ارقام فقط ويجب ان تكون اكبر من اوتساوي 0"
                }
                @endif
            },submitHandler: function (form) {
                $.ajax({
                    method: "POST",
                    url: "{{ action('ServiceProviderController@addServices') }}",
                    data: $('#addServiceForm').serialize(),
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {
                        swal({
                            type: "success",
                            title: "{{trans('lang.success')}}",
                            text: "",
                            confirmButtonText: "{{trans('lang.cancel')}}"
                    });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
        });
    </script>
    <script>
        $('body').on('change', '.category', function () {
            var id = $(this).val();
            if(id.length != 0) {
                $.ajax({
                    method: "GET",
                    url: "{{ action('ServiceProviderController@showServices') }}",
                    data: {"action": "getServices", "category_id": id},
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {

                        if (data.status) {
                            $('#service').html(data.view);
                            $('#service').prepend('<option selected value="">{{ trans('lang.choose_option') }}</option>');
                            $('.select').select2();
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
        });
        $('body').on('change', '.service', function () {
            var id = $(this).val();
                $.ajax({
                    method: "GET",
                    url: "{{ action('ServiceProviderController@showServices') }}",
                    data: {"action": "getInstant", "service_id": id},
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {
                        if (data.status) {
                            $("#questionsHtml").html(data.question_view);
                            $("#priceHtml").val(data.price);
                            if (data.is_instant) {
                                $('#urgent').removeClass('hidden');
                                $('#urgentCheckbox').val(1);

                            } else {
                                $('#urgent').addClass('hidden');
                                $('#urgentCheckbox').val(0);
                            }
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });

        });
    </script>


@endsection