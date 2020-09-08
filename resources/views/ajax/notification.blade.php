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
        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
            <li>

                @foreach($notifications as $not)


                    @if(str_contains($not->s_ids,['/']))
                        <?php
                        $splitMe = explode('/', $not->s_ids);
                        ?>
                        <a href="{{$not->s_url == '#'?'#':route($not->s_url,[$splitMe[0],$splitMe[1]])}}">
                            <span class="time">{{$not->dt_created_date}}</span><span
                                    class="details"><span
                                        class="label label-sm label-icon label-success"><i
                                            class="fa fa-plus"></i></span> {{ !empty($not->s_title)?$not->s_title:$not->title}}</span>
                        </a>

                    @else
                        @if(empty($not->request_id))
                            @if($not->fk_i_notification_template_id == 4)
                                <a href="{{$not->s_url == '#'?'#':route($not->s_url,$not->s_ids)}}">
                                    <span class="time">{{$not->dt_created_date}}</span><span
                                            class="details"><span
                                                class="label label-sm label-icon label-danger"><i
                                                    class="fa fa-bolt"></i></span> {{ !empty($not->s_title)?$not->s_title:$not->title}}</span>
                                </a>
                                @else
                                <a href="{{$not->s_url == '#'?'#':route($not->s_url,$not->s_ids)}}">
                                    <span class="time">{{$not->dt_created_date}}</span><span
                                            class="details"><span
                                                class="label label-sm label-icon label-success"><i
                                                    class="fa fa-plus"></i></span> {{ !empty($not->s_title)?$not->s_title:$not->title}}</span>
                                </a>
                                @endif
                        @else
                            <a href="{{$not->s_url == '#'?'#':route($not->s_url,$not->request_id)}}">
                                <span class="time">{{$not->dt_created_date}}</span><span
                                        class="details"><span
                                            class="label label-sm label-icon label-success"><i
                                                class="fa fa-plus"></i></span> {{ !empty($not->s_title)?$not->s_title:$not->title}}</span>
                            </a>
                        @endif
                    @endif

                @endforeach
            </li>
        </ul>
    </li>
</ul>