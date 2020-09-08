@extends('_layout')
@section('styles')

@endsection
@section('head_title')
    {{trans('lang.add_quotation')}}
@endsection
@section('title')
    {!!  trans('lang.add_quotation')!!}
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

    <div class="col-sm-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class=""></i></div>
                <div class="tools">
                    <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: block;">
                {!! Form::open(['id'=>'addQuotationForm','method'=>'post','route'=>['quotation.store',$requestId],'files'=>true]) !!}
                <div class="row">
                    <div class="col-sm-12">
                        <h3>@lang('lang.quotation_details')</h3>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                {!! Form::label('price',trans('lang.price')) !!}
                                {!! Form::text('price',!empty($request)?$request->d_price:null,['class'=>'form-control']) !!}
                                @if($errors->has('price'))
                                    <strong class="font-red">{{ $errors->first('price') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                {!! Form::label('description',trans('lang.description')) !!}
                                {!! Form::textarea('description',!empty($request)?$request->s_description:null,['class'=>'form-control']) !!}
                                @if($errors->has('description'))
                                    <strong class="font-red">{{ $errors->first('description') }}</strong>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h3>@lang('lang.request_attach')</h3>
                        <div class="col-sm-6">
                            <input type="file" name="file[]" class="filestyle" data-input="false" data-badge="false"
                                   multiple id="gallery-photo-add">

                            <div class="row">
                                <div class="gallery"
                                     style="width: 100%;height: 200px;  overflow-y: scroll;margin-bottom: 20px; ">
                                    @if(!empty($request))
                                        <?php
                                        $help = new \App\helper\helpers();
                                        $data = $help->getQuotationAttachment($request->pk_i_id);

                                        ?>
                                        @foreach($data as $d)
                                            <img class="col-sm-3" style="width: 200px;height: 150px;"
                                                 src="{{asset('/images/quotation_attachment/'.$d->s_url)}}" alt="">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">

                        {!! Form::submit(!empty($request)?trans('lang.update'):trans('lang.send'),['class'=>'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(function () {
            // Multiple images preview in browser
            var imagesPreview = function (input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function (event) {
                            $($.parseHTML('<img class="col-sm-3" style="width: 200px;height: 150px;">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        };
                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#gallery-photo-add').on('change', function () {
                imagesPreview(this, 'div.gallery');
            });
        });

    </script>
    <script>
        $(function () {
            $(".glyphicon").removeClass('icon-span-filestyle');
        });
        $(".glyphicon").removeClass('icon-span-filestyle');

    </script>


    <script>
        $('#addQuotationForm').validate({
            rules: {
                price: {
                    required: true,
                    number: true
                },
                description: "required",
                attachment_description: "required"
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
                error.css('color', 'red');
            },
            messages: {
                @if(app()->getLocale() == 'ar')
                price: {
                    required: "السعر حقل مطلوب",
                    number: "السعر يجب ان يحتوي على ارقام فقط"
                },
                description: " الوصف حقل مطلوب",
                attachment_description: " الوصف حقل مطلوب",
                @else
                price: {
                    required: "price field is required",
                    number: "price must contains number only"
                },
                description: "description field is required",
                attachment_description: "description field is required"

                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });


    </script>

@endsection