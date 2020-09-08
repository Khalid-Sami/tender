@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.constant_management')}}
@endsection
@section('title')
    {{trans('lang.constant_management')}}
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
    {{--<div class="col-sm-12">--}}
        {{--<button class="btn green" id="addCountry"><span class="fa fa-plus"></span> @lang('lang.country')</button>--}}
        {{--<table class="table" id="myTable" style="width: 100%">--}}
            {{--<thead>--}}
            {{--<tr>--}}
                {{--<th>#</th>--}}
                {{--<th>@lang('lang.country')</th>--}}
                {{--<th>@lang('lang.status')</th>--}}
                {{--<th>@lang('lang.options')</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}

        {{--</table>--}}
    {{--</div>--}}
    <!-- /.modal -->
    <div id="showCountry" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id'=>'editCountry','method'=>'PATCH','action'=>'AdminController@updateConstant']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.edit_country')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('pk_i_id',null,['id'=>'c_pk_i_id']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_ar',trans('lang.country_ar')) !!}
                            {!! Form::text('name_ar',null,['class'=>'form-control','id'=>'country_ar']) !!}
                            <div id="name_ar_validate" class="font-red"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_en',trans('lang.country_en')) !!}
                            {!! Form::text('name_en',null,['class'=>'form-control','id'=>'country_en']) !!}
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

                            {!! Form::select('c_status',isset($status)?$status:[],null,['class'=>'form-control select','id'=>'country_status']) !!}
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
    <div id="addCountryModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            {!! Form::open(['id'=>'addCountryForm','method'=>'POST','action'=>'AdminController@storeConstant']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('lang.add_country')</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! Form::hidden('fk_i_parent_id',8) !!}
                        {!! Form::hidden('key','COUNTRIES') !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_ar',trans('lang.country_ar')) !!}
                            {!! Form::text('name_ar',null,['class'=>'form-control']) !!}
                            <div id="name_ar_validate1" class="font-red"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('name_en',trans('lang.country_en')) !!}
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

                            {!! Form::select('c_status',isset($status)?$status:[],null,['class'=>'form-control select', 'id' => 'countryStatus']) !!}
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

@endsection