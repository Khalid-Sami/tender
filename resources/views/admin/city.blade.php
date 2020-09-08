@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.constant_management')}}
@endsection
@section('title')
    {!!  trans('lang.constant_management')." /<small>$name</small>" !!}
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
    <div class="col-sm-12">
        <button class="btn green" id="addCity"><span class="fa fa-plus"></span> @lang('lang.city')</button>

        <table class="table" id="myTable" style="width: 100%">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('lang.city')</th>
                <th>@lang('lang.status')</th>
                <th>@lang('lang.options')</th>
            </tr>
            </thead>

        </table>
    </div>
    <!-- /.modal -->
    <div id="editCityModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id'=>'editCityForm','method'=>'PATCH','action'=>'AdminController@updateConstant']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.edit_city')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('pk_i_id',null,['id'=>'c_pk_i_id']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_ar',trans('lang.city_ar')) !!}
                            {!! Form::text('name_ar',null,['class'=>'form-control','id'=>'city_ar']) !!}
                            <div id="name_ar_validate" class="font-red"></div>
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('name_en',trans('lang.city_en')) !!}
                            {!! Form::text('name_en',null,['class'=>'form-control','id'=>'city_en']) !!}
                            <div id="name_en_validate" class="font-red"></div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {!! Form::label('c_status',trans('lang.status')) !!}
                            <?php
                            $status;
                            if (app()->getLocale() == 'en') {
                                $status = array('' => 'Choose Option', '1' => 'enable', '0' => 'disable');
                            } else {
                                $status = array('' => 'اختار من القائمة', '1' => 'فعال', '0' => 'غير فعال');
                            }

                            ?>

                            {!! Form::select('c_status',isset($status)?$status:[],null,['class'=>'form-control select','id'=>'city_status']) !!}
                            <div id="c_status_validate" class="font-red"></div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">@lang('lang.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="addCityModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id'=>'addCityForm','method'=>'POST','action'=>'AdminController@storeConstant']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.add_country')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('fk_i_parent_id',isset($country_id)?$country_id:'') !!}
                        {!! Form::hidden('key','CITIES') !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_ar',trans('lang.city_ar')) !!}
                            {!! Form::text('name_ar',null,['class'=>'form-control']) !!}
                            <div id="name_ar_validate1" class="font-red"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_en',trans('lang.city_en')) !!}
                            {!! Form::text('name_en',null,['class'=>'form-control']) !!}
                            <div id="name_en_validate1" class="font-red"></div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {!! Form::label('c_status',trans('lang.status')) !!}
                            <?php
                            $status;
                            if (app()->getLocale() == 'en') {
                                $status = array('' => 'Choose Option', '1' => 'enable', '0' => 'disable');
                            } else {
                                $status = array('' => 'اختار من القائمة', '1' => 'فعال', '0' => 'غير فعال');
                            }

                            ?>

                            {!! Form::select('c_status',isset($status)?$status:[],null,['class'=>'form-control select', 'id' => 'cityStatus']) !!}
                            <div id="c_status_validate1" class="font-red"></div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">@lang('lang.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.alert-dismissible').delay(3000).fadeOut('slow');
            var lang = {
                sLengthMenu: "عرض _MENU_ من العناصر",
                sSearch: "ابحث هنا",
                sEmptyTable: "لا يوجد عناصر مضافة حاليا",
                sInfo: "عرض _START_ الى _END_ من _TOTAL_ العناصر",
                sInfoEmpty: "لا يوجد عناصر",
                sInfoFiltered: "(من العدد الكلي)",
                sInfoPostFix: "",
                sLoadingRecords: "يتم تحميل المعلومات ....",
                sProcessing: "تتم المعاملة",
                sZeroRecords: "لا يوجد عناصر مطابقة للبحث",
                sPaginate: {
                    "first": "الأول",
                    "previous": "السابق",
                    "next": "التالي",
                    "last": "الأخير"
                },
                aria: {
                    "sortAscending": ": اضغط للترتيب تصاعديا",
                    "sortDescending": ": اضغط للترتيب تنازليا"
                },
                decimal: "",
                thousands: ","

            };
            $('#myTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{!! route('constant.get',['ConstantView',$country_id]) !!}"
                },
                "columns": [
                    {
                        mRender: function (data, type, row, full) {
                            return full['row'] + 1;
                        }
                    },
                    {data: 's_name', name: 's_name',defaultContent:""},
                    {
                        mRender: function (data, type, row, full) {
                            @if(app()->getLocale() == 'en')
                            if (row['b_enabled'] == 1) {
                                return "enable";
                            } else {
                                return "disable";
                            }
                            @else
                            if (row['b_enabled'] == 0) {
                                return "غير فعال";
                            } else {
                                return "فعال";
                            }
                            @endif
                        }
                    },
                    {
                        mRender: function (data, type, row, full) {

                            return '<div class="dropdown">' +
                                    '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">@lang('lang.options')<span class="caret"></span> </button>' +
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">' +
                                    '<li>' +
                                    '<a class="edit_city">@lang('lang.edit_city')</a>' +
                                    '<input type="hidden" id="s_name_ar" value="' + row['s_name_ar'] + '">' +
                                    '<input type="hidden" id="s_name_en" value="' + row['s_name_en'] + '">' +
                                    '<input type="hidden" id="pk_i_id" value="' + row['pk_i_id'] + '">' +
                                    '<input type="hidden" id="dt_status" value="' + row['b_enabled'] + '">' +
                                    '</li>' +
                                    '<li>' +
                                    {{--'<a href="{{url('/')}}/admin/' + row['pk_i_id'] + '/district">@lang('lang.show_district')</a>' +--}}
                                    '</li>' +
                                    '</ul>' +
                                    '</div>';
                        }
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: '',
                        className: 'hidden'
                    }

                ],
                "bLengthChange": true,
                "bFilter": true,
                "pageLength": 10,
                @if(app()->getLocale() == 'ar')
                language: lang
                @endif
            });
            @if(app()->getLocale() == 'ar')
            $('.prev').children().children().removeClass('fa fa-angle-left');
            $('.prev').children().children().addClass('fa fa-angle-right');
            $('.next').children().children().removeClass('fa fa-angle-right');
            $('.next').children().children().addClass('fa fa-angle-left');
            @endif
        });
    </script>


    <script>
        $('body').on('click', '.edit_city', function () {
            var pk_i_id = $(this).siblings('#pk_i_id').val();
            var s_name_ar = $(this).siblings('#s_name_ar').val();
            var s_name_en = $(this).siblings('#s_name_en').val();
            var status = $(this).siblings('#dt_status').val();

            $('#city_ar').val(s_name_ar);
            $('#city_en').val(s_name_en);
            $('#c_pk_i_id').val(pk_i_id);
            $('#city_status').val(status);
            $('#city_status').select2();
            $('#editCityModal').modal('show');
        });
    </script>
    <script>
        $('body').on('click', '#addCity', function () {
            $('#addCityModal').modal('show');
            $('#cityStatus').val(1);
            $('#cityStatus').select2();
            $('#addCityForm').validate({
                rules: {
                    name_ar: "required",
                    name_en: "required",
                    c_status: "required"
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");
                    error.appendTo($("#" + name + "_validate1"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    name_ar: "المدينة حقل مطلوب",
                    name_en: "المدينة حقل مطلوب (English)",
                    c_status: " الحالة حقل مطلوب",
                    @else
                    name_ar: "city (Arabic) field is required",
                    name_en: "city field is required",
                    c_status: "status field is required"
                    @endif
                }, submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>

    <script>
        $('#editCityForm').validate({
            rules: {
                name_ar: "required",
                name_en: "required",
                c_status: "required"
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_validate"));
            },
            messages: {
                @if(app()->getLocale() =='ar')
                name_ar: "الدولة حقل مطلوب",
                name_en: "الدولة حقل مطلوب (English)",
                c_status: " الحالة حقل مطلوب",
                @else
                name_ar: "country (Arabic) field is required",
                name_en: "country field is required",
                c_status: "status field is required"
                @endif
            }, submitHandler: function (form) {
                form.submit();
            }
        });
    </script>




@endsection