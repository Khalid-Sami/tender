<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>@lang('lang.subscribe_plan')</title>
</head>
<body>
{!! Form::open(['method' => 'patch','action' => 'AdminController@updateSubscribePlan','id' =>'editSubscribePlanForm']) !!}
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">@lang('lang.subscribe_plan')</h4>
        </div>            <!-- /modal-header -->
        <div class="modal-body">
            <p>


            <div class="row">

                {!! Form::hidden('method','update') !!}
                {!! Form::hidden('pk_i_id',$subscription_packages->pk_i_id) !!}
                <div class="form-group col-sm-6">
                    {!! Form::label('subscription_package_en',trans('lang.subscription_package')) !!}
                    {!! Form::text('subscription_package_en',$subscription_packages->s_name_en,['class' => 'form-control']) !!}
                    @if($errors->has('subscription_package_en'))
                        <strong class="font-red">{{ $errors->first('subscription_package_en') }}</strong>
                    @endif
                    <div class="font-red" id="subscription_package_en_validate"></div>
                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('subscription_package_ar',trans('lang.subscription_package_arabic')) !!}
                    {!! Form::text('subscription_package_ar',$subscription_packages->s_name_ar,['class' => 'form-control']) !!}
                    @if($errors->has('subscription_package_ar'))
                        <strong class="font-red">{{ $errors->first('subscription_package_ar') }}</strong>
                    @endif
                    <div class="font-red" id="subscription_package_ar_validate"></div>

                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('users_count',trans('lang.users_count')) !!}
                    {!! Form::text('users_count',$subscription_packages->i_users_count,['class' => 'form-control']) !!}
                    @if($errors->has('users_count'))
                        <strong class="font-red">{{ $errors->first('users_count') }}</strong>
                    @endif
                    <div class="font-red" id="users_count_validate"></div>
                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('services_count',trans('lang.services_count')) !!}
                    {!! Form::text('services_count',$subscription_packages->i_services_count,['class' => 'form-control']) !!}
                    @if($errors->has('services_count'))
                        <strong class="font-red">{{ $errors->first('services_count') }}</strong>
                    @endif
                    <div class="font-red" id="services_count_validate"></div>

                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('request_count',trans('lang.request_count')) !!}
                    {!! Form::text('request_count',$subscription_packages->i_request_count,['class' => 'form-control']) !!}
                    @if($errors->has('request_count'))
                        <strong class="font-red">{{ $errors->first('request_count') }}</strong>
                    @endif
                    <div class="font-red" id="request_count_validate"></div>

                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('sms_notification',trans('lang.sms_notification')) !!}
                    {!! Form::text('sms_notification',$subscription_packages->i_sms_notification,['class' => 'form-control']) !!}
                    @if($errors->has('sms_notification'))
                        <strong class="font-red">{{ $errors->first('sms_notification') }}</strong>
                    @endif
                    <div class="font-red" id="sms_notification_validate"></div>

                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('email_notification',trans('lang.email_notification')) !!}
                    {!! Form::text('email_notification',$subscription_packages->i_email_notification,['class' => 'form-control']) !!}
                    @if($errors->has('email_notification'))
                        <strong class="font-red">{{ $errors->first('email_notification') }}</strong>
                    @endif
                    <div class="font-red" id="email_notification_validate"></div>

                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('percentage',trans('lang.percentage')) !!}
                    {!! Form::text('percentage',$subscription_packages->d_percentage,['class' => 'form-control']) !!}
                    @if($errors->has('percentage'))
                        <strong class="font-red">{{ $errors->first('percentage') }}</strong>
                    @endif
                    <div class="font-red" id="percentage_validate"></div>

                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('price',trans('lang.price')) !!}
                    <div class="input-group">
                        {!! Form::text('price',$subscription_packages->d_price,['class' => 'form-control']) !!}

                        <span class="input-group-addon">@lang('lang.curr')</span>
                    </div>
                    @if($errors->has('price'))
                        <strong class="font-red">{{ $errors->first('price') }}</strong>
                    @endif
                    <div class="font-red" id="price_validate"></div>

                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('duration',trans('lang.duration')) !!}
                    <div class="input-group">
                        {!! Form::text('duration',$subscription_packages->i_duration,['class' => 'form-control']) !!}
                        <span class="input-group-addon">@lang('lang.one_day')</span>
                    </div>


                    @if($errors->has('duration'))
                        <strong class="font-red">{{ $errors->first('duration') }}</strong>
                    @endif
                    <div class="font-red" id="duration_validate"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {!! Form::label('status',trans('lang.status')) !!}
                    <?php
                    $state;
                    if (app()->getLocale() == 'en') {
                        $state = ['' => 'choose option', '1' => 'enable', '0' => 'disable'];
                    } else {
                        $state = ['' => 'اختر من القائمة', '1' => 'فعال', '0' => 'غير فعال'];
                    }
                    ?>
                    {!! Form::select('status',$state,$subscription_packages->b_enabled,['class' => 'form-control select','id' => 'status_m']) !!}
                    @if($errors->has('status'))
                        <strong class="font-red">{{ $errors->first('status') }}</strong>
                    @endif
                    <div class="font-red" id="status_validate"></div>


                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('listed',trans('lang.listed_on_homepage')) !!}
                    <?php
                    $state;
                    if (app()->getLocale() == 'en') {
                        $state = ['' => 'choose option', '1' => 'show', '0' => 'hide'];
                    } else {
                        $state = ['' => 'اختر من القائمة', '1' => 'عرض', '0' => 'إخفاء'];
                    }
                    ?>
                    {!! Form::select('listed',$state,$subscription_packages->b_listed_on_homepage,['class' => 'form-control select']) !!}
                    @if($errors->has('listed'))
                        <strong class="font-red">{{ $errors->first('listed') }}</strong>
                    @endif
                    <div class="font-red" id="listed_validate"></div>

                </div>


            </div>

            </p>
        </div>            <!-- /modal-body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default {!!  app()->getLocale() =='ar'?'pull-right margin-right-10':'' !!}" data-dismiss="modal">{{trans('lang.cancel')}}</button>
            <button type="submit" id="saveData" class="btn btn-primary">{{trans('lang.save')}}</button>
        </div>            <!-- /modal-footer -->
    </div>         <!-- /modal-content -->
{!! Form::close() !!}


@include('scripts.scripts')
<script>
    $('select').select2();
</script>
</body>
</html>