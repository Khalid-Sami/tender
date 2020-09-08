@extends('_layout')

@section('head_title')
    {{ trans('lang.messages') }}
@endsection

@section('title')
    {{ trans('lang.messages') }}
@endsection
@section('content')
    <?php $max_id = 0 ?>
    <div class="col-md-4 ">

        <div class="portlet light bordered " style="height: 425px">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-bubbles font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">@lang('lang.conversations')</span>
                </div>
                {{--<ul class="nav nav-tabs">--}}
                {{--<li>--}}
                {{--<a href="#"> New Message </a>--}}
                {{--</li>--}}
                {{--</ul>--}}
            </div>
            <div class="">
                <div class="form-group">
                    {{--<input id="provider-json" placeholder="{{trans('lang.search').'...'}}" style="width:100%"/>--}}
                    <input type="hidden" id="provider-json1"/>
                    {{--<select id="multi-append" name="user_id" class="form-control select2">--}}
                    {{--<option selected value="0">Search For User</option>--}}
                    {{--@foreach($users as $u)--}}
                    {{--<option value="{{$u->pk_i_id}}">{{$u->s_first_name}}</option>--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                </div>
            </div>
            <div class="portlet-body scroller" style="height: 295px">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_comments_1">
                        <!-- BEGIN: Comments -->
                        @foreach($cc1 as $c)
                            <div class="mt-comments">
                                <?php
                                $data = \App\helper\helpers::getData($c->user_id, $c->conversation_id);
                                ?>
                                @if(isset($data))
                                    <a class="m_user_id">
                                        <input type="hidden" id="user_id22" value="{{$data->user_id}}">
                                        <input type="hidden" id="conversation_id22" value="{{$data->conversation_id}}">
                                        <div class="mt-comment">
                                            <div class="mt-comment-img">
                                                <img width="45" height="45"
                                                     src="{{ isset($data->s_pic)?url('/')."/images/users_images/".$data->s_pic:asset('/images/users_images/avatar.png') }}"/>
                                            </div>
                                            <div class="mt-comment-body">
                                                <div class="mt-comment-info">
                                                    <span class="mt-comment-author">{{$data->s_first_name}}</span>
                                                    <span class="mt-comment-date">{{$data->updated_at->diffForHumans()}}</span>
                                                </div>
                                                <div class="mt-comment-details">
                                                    {{--<span class="mt-comment-status mt-comment-status-pending">Pending</span>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="portlet-body " id="chats">
            <div class="scroller" style="height: 355px;" data-always-visible="1" data-rail-visible1="1">
                <ul class="chats">

                </ul>
            </div>
            <div class="chat-form" id="chats1">
                <div class="input-cont">
                    <input class="form-control" type="text" placeholder="{{trans('lang.type_message')}}"/></div>
                <div class="btn-cont">
                    <span class="arrow"> </span>
                    <a href="" class="btn blue icn-only">
                        <i class="fa fa-check icon-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script>
        var count = "{{$count_m}}";
        var max_id = "{{$max_id}}";
        var user_id1 = "{{$user_id1}}";

        var count_c = "{{$count_c}}";
        var user_id2 = "{{$userId2}}";
        var con_id = 0;
        var check_flag;
        $(document).ready(function () {
            $('.m_user_id').click(function (event) {
                $(".mt-comments").css("background-color", "");
                $(this).parent(".mt-comments").css("background-color", "lightgray");
                var conversation_id22 = $(this).children("#conversation_id22").val();
                var cont = $('#chats');
                var list = $('.chats', cont);
                var form = $('.chat-form', cont);
                var input = $('input', form);
                var msg = list.text("");
                $("#chats1").removeClass("hidden");
                $.ajax({
                    method: "POST",
                    url: '{{url('/')}}/getPreviousMessages',
                    dataType: 'json',
                    data: {
                        id: 1,
                        con_id: conversation_id22,
                        user_id: user_id1,
                        count: count,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (data, textStatus, jqXHR) {
                        count = data.count;
                        con_id = data.con_id;
                        user_id2 = data.user_id;
                        for (var i = 0; i < data.messages.length; i++) {
                            var time_str = data.messages[i].created_at;
//                            var time_str = getDate(time_str);

                            var image = data.messages[i].s_pic;
                            var tpl = '';
                            if (user_id1 == data.messages[i].user_id) {
                                tpl += '<li class="out">';
                            } else {
                                tpl += '<li class="in">';
                            }
                            if (image) {
                                tpl += '<img class="avatar" alt="" src="' + "{{url('/')}}/images/users_images/" + image + '"/>';
                            } else {
                                tpl += '<img class="avatar" alt="" src="{{asset('/images/users_images/avatar.png')}}"/>';

                            }
                            tpl += '<div class="message">';
                            tpl += '<span class="arrow"></span>';
                            tpl += '<a href="#" class="name">' + data.messages[i].s_first_name + '</a>&nbsp;';
                            tpl += '<span class="datetime">at ' + time_str + '</span>';
                            tpl += '<span class="body">';
                            tpl += data.messages[i].body;
                            tpl += '</span>';
                            tpl += '</div>';
                            tpl += '</li>';
                            var cont = $('#chats');
                            var list = $('.chats', cont);
                            var form = $('.chat-form', cont);
                            var input = $('input', form);

                            var msg = list.append(tpl);

                            max_id = data.messages[i].id;
                        }

                        var getLastPostPos = function () {
                            var height = 0;
                            cont.find("li.out, li.in").each(function () {
                                height = height + ($(this).outerHeight() + 10);
                            });
                            return height;
                        };

                        cont.find('.scroller').slimScroll({
                            scrollTo: getLastPostPos()
                        });
                        $("#chats1").removeClass("hidden");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            });
            $("#multi-append").change(function () {
                user_id2 = $(this).val();

                var cont = $('#chats');
                var list = $('.chats', cont);
                var form = $('.chat-form', cont);
                var input = $('input', form);

                var msg = list.text("");
                $("#chats1").removeClass("hidden");

                if (user_id2 != 0) {
                    $.ajax({
                        method: "POST",
                        url: '{{url('/')}}/getPreviousMessagesFromSelect',
                        dataType: 'json',
                        data: {
                            id: 1,
                            user_id1: user_id1,
                            user_id2: user_id2,
                            '_token': '{{csrf_token()}}'
                        },
                        success: function (data, textStatus, jqXHR) {
                            count = data.count;
                            con_id = data.con_id;
                            user_id2 = data.user_id2;
                            for (var i = 0; i < data.messages.length; i++) {
                                var time_str = data.messages[i].created_at;

                                var image = data.messages[i].s_pic;
                                var tpl = '';
                                if (user_id1 == data.messages[i].user_id) {
                                    tpl += '<li class="out">';
                                } else {
                                    tpl += '<li class="in">';
                                }
                                if (image) {
                                    tpl += '<img class="avatar" alt="" src="' + "{{url('/')}}/images/users_images/" + image + '"/>';
                                } else {
                                    tpl += '<img class="avatar" alt="" src="{{asset('/images/users_images/avatar.png')}}"/>';

                                }
                                tpl += '<div class="message">';
                                tpl += '<span class="arrow"></span>';
                                tpl += '<a href="#" class="name">' + data.messages[i].s_first_name + '</a>&nbsp;';
                                tpl += '<span class="datetime">at ' + time_str + '</span>';
                                tpl += '<span class="body">';
                                tpl += data.messages[i].body;
                                tpl += '</span>';
                                tpl += '</div>';
                                tpl += '</li>';
                                var cont = $('#chats');
                                var list = $('.chats', cont);
                                var form = $('.chat-form', cont);
                                var input = $('input', form);

                                var msg = list.append(tpl);

                                max_id = data.messages[i].id;
                            }

                            var getLastPostPos = function () {
                                var height = 0;
                                cont.find("li.out, li.in").each(function () {
                                    height = height + ($(this).outerHeight() + 10);
                                });
                                return height;
                            };

                            cont.find('.scroller').slimScroll({
                                scrollTo: getLastPostPos()
                            });
                            $("#chats1").removeClass("hidden");
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });
                } else {
                    $("#chats1").addClass("hidden");
                }
            });
            var cont = $('#chats');
            var list = $('.chats', cont);
            var form = $('.chat-form', cont);
            var input = $('input', form);

            var getLastPostPos = function () {
                var height = 0;
                cont.find("li.out, li.in").each(function () {
                    height = height + $(this).outerHeight();
                });
                return height;
            };

            cont.find('.scroller').slimScroll({
                scrollTo: getLastPostPos()
            });
            $("#multi-append1").select2(

            );

            $("#multi-append").select2();
        });


        $(function(){


        var Dashboard = function () {

            return {
                initChat: function () {
                    var cont = $('#chats');
                    var list = $('.chats', cont);
                    var form = $('.chat-form', cont);
                    var input = $('input', form);
                    var btn = $('.btn', form);

                    var handleClick1 = function (e) {
                        e.preventDefault();
                        var text = input.val();
                        if (text.length == 0) {
                            return;
                        }


                        $.ajax({
                            method: "POST",
                            url: '{{url('/')}}/sendMessage',
                            dataType: 'json',
                            data: {
                                id: 1,
                                user_id1: user_id1,
                                user_id2: user_id2,
                                con_id: con_id,
                                text: text,
                                '_token': '{{csrf_token()}}'
                            },
                            success: function (data, textStatus, jqXHR) {
                                con_id = data.con_id;
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });
                        handleClick(e);
                    };
                    var handleClick = function (e) {
                        e.preventDefault();
                        var text = input.val();
                        if (text.length == 0) {
                            return;
                        }

                        var time = new Date();
                        var time_str = (time.getHours() + ':' + time.getMinutes());
//                        var time_str = getDate(time_str);

                        var image = "{{$u1->s_pic}}";
                        var tpl = '';
                        tpl += '<li class="out">';
                        if (image) {
                            tpl += '<img class="avatar" alt="" src="' + "{{url('/')}}/images/users_images/" + image + '"/>';
                        } else {
                            tpl += '<img class="avatar" alt="" src="{{asset('/images/users_images/avatar.png')}}"/>';

                        }
                        tpl += '<div class="message">';
                        tpl += '<span class="arrow"></span>';
                        tpl += '<a href="#" class="name">{{$u1->s_first_name}}</a>&nbsp;';
                        tpl += '<span class="datetime">at ' + time_str + '</span>';
                        tpl += '<span class="body">';
                        tpl += text;
                        tpl += '</span>';
                        tpl += '</div>';
                        tpl += '</li>';

                        var msg = list.append(tpl);
                        input.val("");

                        var getLastPostPos = function () {
                            var height = 0;
                            cont.find("li.out, li.in").each(function () {
                                height = height + $(this).outerHeight();
                            });

                            return height;
                        };

                        cont.find('.scroller').slimScroll({
                            scrollTo: getLastPostPos()
                        });
                    };

                    $('body').on('click', '.message .name', function (e) {
                        e.preventDefault(); // prevent click event

                        var name = $(this).text(); // get clicked user's full name
                        input.val('@' + name + ':'); // set it into the input field
                        App.scrollTo(input); // scroll to input if needed
                    });

                    btn.click(handleClick1);

                    input.keypress(function (e) {
                        if (e.which == 13) {
                            handleClick1(e);
                            return false; //<---- Add this line
                        }
                    });
                },
                init: function () {
                    this.initChat();
                }
            };

        }();

        if (App.isAngularJsApp() === false) {
            jQuery(document).ready(function () {
                Dashboard.init(); // init metronic core componets
            });
        }
        $('.date-picker').datepicker({
            format: 'yyyy-m-dd'
        });
        setInterval(function () {
            if (count_c != 0) {
                $.ajax({
                    method: "POST",
                    url: '{{url('/')}}/getConversations',
                    dataType: 'json',
                    data: {
                        id: 1,
                        user_id: user_id1,
                        user_id2: user_id2,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (data, textStatus, jqXHR) {
                        count_c = data.count_c;
                        $("#portlet_comments_1").html(data.view1);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }
            if (con_id != 0) {
                $.ajax({
                    method: "POST",
                    url: '{{url('/')}}/checkCountM',
                    dataType: 'json',
                    data: {
                        id: 1,
                        max_id: max_id,
                        user_id: user_id2,
                        con_id: con_id,
                        count: count,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (data, textStatus, jqXHR) {
                        count = data.count;
                        for (var i = 0; i < data.messages.length; i++) {
                            var time_str = data.messages[i].created_at;
//                            var time_str = getDate(time_str);

                            var image = data.messages[i].s_pic;
                            var tpl = '';
                            tpl += '<li class="in">';
                            if (image) {
                                tpl += '<img class="avatar" alt="" src="' + "{{url('/')}}/images/users_images/" + image + '"/>';
                            } else {
                                tpl += '<img class="avatar" alt="" src="{{asset('/images/users_images/avatar.png')}}"/>';

                            }
                            tpl += '<div class="message">';
                            tpl += '<span class="arrow"></span>';
                            tpl += '<a href="#" class="name">' + data.messages[i].s_first_name + '</a>&nbsp;';
                            tpl += '<span class="datetime">at ' + time_str + '</span>';
                            tpl += '<span class="body">';
                            tpl += data.messages[i].body;
                            tpl += '</span>';
                            tpl += '</div>';
                            tpl += '</li>';
                            var cont = $('#chats');
                            var list = $('.chats', cont);
                            var form = $('.chat-form', cont);
                            var input = $('input', form);

                            var msg = list.append(tpl);
                            var getLastPostPos = function () {
                                var height = 0;
                                cont.find("li.out, li.in").each(function () {
                                    height = height + $(this).outerHeight();
                                });
                                return height;
                            };
                            cont.find('.scroller').slimScroll({
                                scrollTo: getLastPostPos()
                            });
                            max_id = data.messages[i].id;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            }

        }, 3000);
        });
    </script>
    <script>
        {{--$(function () {--}}
            {{--var options = {--}}
                {{--url: "{{url('/')}}/search",--}}
                {{--getValue: function (element) {--}}
                    {{--return element.name;--}}
                {{--},--}}
                {{--list: {--}}
                    {{--onSelectItemEvent: function () {--}}
                        {{--var selectedItemValue = $("#provider-json").getSelectedItemData().user_id;--}}
                        {{--$("#provider-json1").val(selectedItemValue);--}}
                    {{--},--}}
                    {{--onHideListEvent: function () {--}}
                        {{--var selectedItemValue = $("#provider-json1").val();--}}
                        {{--if (user_id2 != selectedItemValue) {--}}
                            {{--user_id2 = selectedItemValue;--}}

                            {{--var cont = $('#chats');--}}
                            {{--var list = $('.chats', cont);--}}
                            {{--var form = $('.chat-form', cont);--}}
                            {{--var input = $('input', form);--}}

                            {{--var msg = list.text("");--}}
                            {{--$("#chats1").removeClass("hidden");--}}

                            {{--if (user_id2 != 0) {--}}
                                {{--$.ajax({--}}
                                    {{--method: "POST",--}}
                                    {{--url: '{{url('/')}}/getPreviousMessagesFromSelect',--}}
                                    {{--dataType: 'json',--}}
                                    {{--data: {--}}
                                        {{--id: 1,--}}
                                        {{--user_id1: user_id1,--}}
                                        {{--user_id2: user_id2,--}}
                                        {{--'_token': '{{csrf_token()}}'--}}
                                    {{--},--}}
                                    {{--success: function (data, textStatus, jqXHR) {--}}
                                        {{--count = data.count;--}}
                                        {{--con_id = data.con_id;--}}
                                        {{--user_id2 = data.user_id2;--}}
                                        {{--for (var i = 0; i < data.messages.length; i++) {--}}
                                            {{--var time_str = data.messages[i].created_at;--}}
{{--//                                            var time_str = getDate(time_str);--}}

                                            {{--var image = data.messages[i].s_pic;--}}
                                            {{--var tpl = '';--}}
                                            {{--if (user_id1 == data.messages[i].user_id) {--}}
                                                {{--tpl += '<li class="out">';--}}
                                            {{--} else {--}}
                                                {{--tpl += '<li class="in">';--}}
                                            {{--}--}}
                                            {{--if (image) {--}}
                                                {{--tpl += '<img class="avatar" alt="" src="' + "{{url('/')}}/images/users_images/" + image + '"/>';--}}
                                            {{--} else {--}}
                                                {{--tpl += '<img class="avatar" alt="" src="{{asset('/images/users_images/avatar.png')}}"/>';--}}

                                            {{--}--}}
                                            {{--tpl += '<div class="message">';--}}
                                            {{--tpl += '<span class="arrow"></span>';--}}
                                            {{--tpl += '<a href="#" class="name">' + data.messages[i].s_first_name + '</a>&nbsp;';--}}
                                            {{--tpl += '<span class="datetime">at ' + time_str + '</span>';--}}
                                            {{--tpl += '<span class="body">';--}}
                                            {{--tpl += data.messages[i].body;--}}
                                            {{--tpl += '</span>';--}}
                                            {{--tpl += '</div>';--}}
                                            {{--tpl += '</li>';--}}
                                            {{--var cont = $('#chats');--}}
                                            {{--var list = $('.chats', cont);--}}
                                            {{--var form = $('.chat-form', cont);--}}
                                            {{--var input = $('input', form);--}}

                                            {{--var msg = list.append(tpl);--}}

                                            {{--max_id = data.messages[i].id;--}}
                                        {{--}--}}

                                        {{--var getLastPostPos = function () {--}}
                                            {{--var height = 0;--}}
                                            {{--cont.find("li.out, li.in").each(function () {--}}
                                                {{--height = height + ($(this).outerHeight() + 10);--}}
                                            {{--});--}}
                                            {{--return height;--}}
                                        {{--};--}}

                                        {{--cont.find('.scroller').slimScroll({--}}
                                            {{--scrollTo: getLastPostPos()--}}
                                        {{--});--}}
                                        {{--$("#chats1").removeClass("hidden");--}}
                                    {{--},--}}
                                    {{--error: function (jqXHR, textStatus, errorThrown) {--}}
                                    {{--}--}}
                                {{--});--}}
                            {{--} else {--}}
                                {{--$("#chats1").addClass("hidden");--}}
                            {{--}--}}
                        {{--}--}}
                    {{--},--}}
                    {{--match: {--}}
                        {{--enabled: true--}}
                    {{--}--}}
                {{--}--}}
            {{--};--}}
            {{--$("#provider-json").easyAutocomplete(options);--}}
        {{--});--}}
    </script>
@endsection