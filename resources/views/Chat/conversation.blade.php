@foreach($cc1 as $c)
    <?php
    $data = \App\helper\helpers::getData($c->user_id, $c->conversation_id);
    ?>
    <div class="mt-comments"
         @if($user_id2 == $data->user_id)
         style="border-radius: 10px;background-color:lightgray;"
            @endif
    >
        <a class="m_user_id">
            <input type="hidden" id="user_id22" value="{{$data->user_id}}">
            <input type="hidden" id="conversation_id22" value="{{$data->conversation_id}}">
            <div class="mt-comment">
                <div class="mt-comment-img">
                    <img width="45" height="45" src="{{ isset($data->s_pic)?url('/')."/images/users_images/".$data->s_pic:asset('/images/users_images/avatar.png') }}"/></div>
                <div class="mt-comment-body">
                    <div class="mt-comment-info">
                        <span class="mt-comment-author">{{$data->s_first_name}}</span>
                        <span class="mt-comment-date"
                              style="color: #3a3a3a;"
                        >{{$data->updated_at->diffForHumans()}}</span>
                    </div>
                    <div class="mt-comment-details">
                        {{--<span class="mt-comment-status mt-comment-status-pending">Pending</span>--}}
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
<script>
    function getDate(offset){
        var now = new Date();
        var hour = 60*60*1000;
        var min = 60*1000;
        return new Date(now.getTime() + (now.getTimezoneOffset() * min) + (offset * hour));
    }

    $(document).ready(function () {
        $('.m_user_id').click(function (event) {
            $(".mt-comments").css( "background-color", "" );
            $(this).parent(".mt-comments").css( "background-color", "lightgray" );
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
                        var image = data.messages[i].s_pic;
                        var tpl = '';
                        if (user_id1 == data.messages[i].user_id) {
                            tpl += '<li class="out">';
                        } else {
                            tpl += '<li class="in">';
                        }
                        if(image) {
                            tpl += '<img class="avatar" alt="" src="' + "{{url('/')}}/images/users_images/" + image + '"/>';
                        }else{
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
                            height = height + ($(this).outerHeight()+10);
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
    });
</script>