<input id="last_date" type="hidden" value="{{ $last_date }}">
<a href="javascript:;" id="show_notifications" class="dropdown-toggle"
   data-toggle="dropdown"
   data-hover="dropdown"
   data-close-others="true" aria-expanded="true">
    <i class="icon-bell"></i>
    @if($notifications_count[0]->cou != 0)
        <span class="badge badge-default"> {{$notifications_count[0]->cou }} </span>
    @else
        <span class="badge badge-default"></span>

    @endif
</a>
<ul class="dropdown-menu">
    <li class="external">
        <h3><span>{{ trans('lang.notifications') }}</span></h3>
    </li>
    <li>
        <ul class="dropdown-menu-list scroller" style="height: 250px;"
            data-handle-color="#637283">
            <li>

                @foreach($notifications as $not)


                    <a href="#">
                        <span class="time">{{ \Carbon\Carbon::parse($not->dt_created_date)->setTimezone(session('timezone'))->diffForHumans()}}</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-plus"></i>
                                                        </span> {!! !empty($not->fk_i_notification_template_id)?(!empty($not->s_template_en)?\App\helper\helpers::getNotificationTitle(app()->getLocale()=='en'?$not->s_template_en:$not->s_template_ar, app()->getLocale()=='en'?$not->s_title_en:$not->s_title_ar):$not->s_title_en):(app()->getLocale()=='ar'?$not->s_title_ar:$not->s_title_en)  !!}</span>
                    </a>
                @endforeach
            </li>
        </ul>
    </li>
</ul>