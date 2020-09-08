@extends('_layout')

@section('style')
    <style>
        .error {
            color: #FF0000; /* red */
        }

        .valid {
            color: #32c5d2; /* sky blue */
        }
    </style>
@endsection
@section('head_title')
    {{trans('lang.add_service')}}
@endsection
@section('title')
    {!!  trans('lang.add_service') !!}
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
    <form id="addNewService" action="{{route('saveService')}}" method="POST">
        {{csrf_field()}}
        <div class="form-body">
            <div class="form-group">
                <label class="label-control" style="font-size: 16px !important;">اسم
                    الخدمة
                    (عربي)</label>
                <input id="serviceName_ar" name="serviceName_ar"
                       class="form-control"
                       type="text"
                       placeholder="اسم الخدمة (عربي)"/>
            </div>
            <div class="form-group">
                <label class="label-control" style="font-size: 16px !important;">اسم
                    الخدمة
                    (انجليزي)</label>
                <input id="serviceName_en" name="serviceName_en"
                       class="form-control"
                       type="text"
                       placeholder="اسم الخدمة (انجليزي)"/>
            </div>
            <div class="form-group">
                <label class="label-control" style="font-size: 16px !important;">وصف
                    الخدمة
                    (عربي) </label>
                            <textarea id="description_ar" name="description_ar" class="form-control" rows="3"
                                      placeholder="وصف الخدمة (عربي)"></textarea>
            </div>
            <div class="form-group">
                <label class="label-control" style="font-size: 16px !important;">وصف
                    الخدمة
                    (انجليزي)</label>
                            <textarea id="description_en" name="description_en" class="form-control" rows="3"
                                      placeholder="وصف الخدمة (انجليزي)"></textarea>
            </div>


            <div class="form-group">
                <label class="label-control" style="font-size: 16px !important;">التصنيفات</label>
                <select id="categories" name="categories[]"
                        multiple="multiple"
                        class="form-control select2-multiple select2-hidden-accessible"></select>

            </div>
            <div class="col-lg-4 form-group"
                 style="padding-right: 0 !important;">
                <div class="col-lg-12"></div>
                <label class="control-label"
                       style="font-size: 16px !important;">خدمة مستعجلة
                    : </label>
                <label class="">

                    <div class="radio">
                        <input type="radio" name="emergency" value="نعم"
                               checked/>
                    </div>
                    نعم
                </label>
                <label class="radio-inline">

                    <div class="radio">
                        <input type="radio" name="emergency" value="لا"/>
                    </div>
                    لا
                </label>


            </div>
            <div class="col-lg-4 form-group"
                 style="padding-right: 0 !important;">
                <div class="col-lg-12"></div>
                <label class="control-label"
                       style="font-size: 16px !important;">حالة الخدمة
                    : </label>

                <label class="">

                    <div class="radio">
                        <input id="status" type="radio" name="status" value="نعم"
                        />
                    </div>
                    فعالة </label>
                <label class="radio-inline">

                    <div class="radio">
                        <input id="status" type="radio" name="status" value="لا"/>
                    </div>
                    غير فعالة
                </label>


            </div>
            <div class="form-actions col-lg-12 right1">
                <div class="col lg 12 center" style="text-align: center">
                    <button id="submitButton" class="btn green " name="submit"
                            type="submit">اضافة
                    </button>
                    <button class="btn default " name="reset">تفريغ الحقول</button>
                </div>

            </div>

        </div>
    </form>
@endsection

@section('scripts')
    <script>
        var url = "{{route('ajaxCategory')}}";
        var token = "{{csrf_token()}}";
        $(document).ready(function () {

            getCategories();

            $(function () {
                var $radios = $('#status');
                if ($radios.is(':checked') === false) {
                    $radios.filter('[value=نعم]').prop('checked', true);
                }
            });


        });
        $("#addNewService").validate({
            rules: {
                serviceName_ar: {
                    required: true
                },
                serviceName_en: {
                    required: true
                },
                description_ar: {
                    required: true
                },
                description_en: {
                    required: true
                },
                categories: {
                    required: true
                },
                emergency: {
                    required: true
                },
                status: {
                    required: true
                }
            },
            messages: {
                serviceName_ar: {
                    required: "يجب ادخال اسم الخدمة (عربي)"

                },
                serviceName_en: {
                    required: "يجب ادخال اسم الخدمة (انجليزي)"

                },
                categories: {
                    required: "يجب اختيار تصنيف واحد على الأقل"
                },
                emergency: {
                    required: "يجب ادخال حالة الخدمة"
                },
                description_ar: {
                    required: "يجب ادخال وصف للخدمة (عربي)"
                },
                description_en: {
                    required: "يجب ادخال وصف للخدمة (انجليزي)"
                }

            },
            submitHandler: function (form) {
                alert('work');
                form.submit();
            }
        });
        function getCategories() {
            $.ajax(
                    {
                        url: url,
                        method: "POST",
                        data: {body: '', postId: '', _token: token}
                    }).success(function (response) {
                $.each(response, function (key, value) {
                    console.log(value.id);
                    $('#categories').append('<option id="' + value.id + '">' + value.category_name_ar + '</option>');
                });
            });
        }


    </script>
@endsection




