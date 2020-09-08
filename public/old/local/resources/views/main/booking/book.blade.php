<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title Of Site -->
    <title>Services - Find best professionals for all your service need.</title>
    <meta name="description" content="Find best professionals for all your service need."/>
    <meta name="keywords" content="beauty, business , health, hobbies, home care, learning, repair, wedding, veichle"/>
    <meta name="author" content="Shift-ICT">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <!-- CSS Plugins -->
    <link rel="stylesheet" type="text/css" href="{{asset('/MainAssets/bootstrap/css/bootstrap.min.css')}}"
          media="screen">

    <link href="{{asset('/MainAssets/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('/MainAssets/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('/MainAssets/icons/icons.css')}}" rel="stylesheet">

    <link href="{{asset('/MainAssets/css/component.css')}}" rel="stylesheet">

    <link href="{{asset('/MainAssets/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- CSS Custom -->
    <link href="{{asset('/MainAssets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('/MainAssets/custom.css')}}" rel="stylesheet">
    <link href="{{asset('/css/sweetalert.css')}}" rel="stylesheet">

    <!-- For your own style -->

    <link href="{{asset('/MainAssets/font-awesome-4.7.0/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('/MainAssets/css/jasny-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"
          rel="stylesheet" type="text/css"/>

    <link href="{{asset('/css/dropzone.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/css/lightbox.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    {{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
    {{--<![endif]-->--}}

    <!-- main core js -->
    <script type="text/javascript" src="{{asset('/MainAssets/js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/MainAssets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/MainAssets/js/jasny-bootstrap.min.js')}}"></script>

    <script src="{{asset('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}"
            type="text/javascript"></script>
    <script src="{{ asset('/assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/dropzone.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/lightbox.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>


    <style>
        #bookingModal {
            margin-top: 100px !important;
        }

        input[type='radio'],
        input[type='checkbox'] {
            opacity: 1;
            display: inline;
            float: left;
            width: 18px
        }

        .margin-top-70 {
            margin-top: 70px
        }
    </style>
</head>


<body class="transparent-header" style="background-color: #F2F2F2">


<!-- start Container Wrapper -->
<div class="container-wrapper">

    <!-- start Header -->
    <header id="header">

        <!-- start Navbar (Header) -->
        <nav class="navbar navbar-primary navbar-fixed-top navbar-sticky-function">

            <div class="container">

                <div class="flex-row ">

                    <div class="flex-shrink flex-columns">

                        <a class="navbar-logo" href="{{ route('home') }}">
                            <img src="{{asset('/MainAssets/unspecified.jpg')}}" alt="Logo"/>
                        </a>

                    </div>

                    <div class="flex-columns">

                        <div class="pull-right">


                            <div class="navbar-mini pull-left">

                                <ul class="clearfix">

                                    <li class="login">
                                        <a href="{{ route('user.main') }}"
                                           class="btn btn-primary btn-inverse btn-sm btn-ajax-login"
                                           data-toggle="modal">My aacount</a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div id="slicknav-mobile"></div>

        </nav>
        <!-- end Navbar (Header) -->

    </header>


    <div class="row margin-top-70 text-center" style="background-color: #F2F2F2">
        {{--{!! Form::open(['method' => 'get', 'action' =>'Main\LandingPageController@index','class' =>'dropzone','id' => 'clinicImagesForm','files'=>true]) !!}--}}

        {{--{!! Form::close() !!}--}}

        {!! Form::open(['id'=>'bookingForm','method'=>'post','files'=>true]) !!}
        <div class="col-sm-6 col-sm-offset-3  booking-box"
             style="border:solid 1px #CCC;height: 500px;background-color: #fff;">
            <div class="row text-center" style="background-color: #dadada">
                <span>{{ $serviceName or ''}}</span><br>
                <div class="col-sm-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                             aria-valuemin="0" aria-valuemax="100" style="width:2%">
                            <span id="bookingPercentage">0%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-left">
                <br>

                <div class="col-sm-12 hidden book" id="book0">
                    <div class="form-group">
                        <strong>Service Name:</strong>
                        <p>{{$serviceName or ''}}</p>
                        <strong>Service Description:</strong>
                        <p>{{ $serviceDesc or 'There is no description' }}</p>

                    </div>
                </div>

                @foreach($booking as  $index=>$book)
                    {!! Form::hidden('iterate',count($booking)) !!}
                    @if($book->i_answer_type == 1)
                        <div class="col-sm-12 hidden book" id="book{{$index+1}}">
                            <div class="form-group">
                                <legend>{{$book->s_question_en}}</legend>
                                {!! Form::hidden("question".($index+1),$book->pk_i_id) !!}

                                @foreach($book->questionOptions as $i=>$d1)
                                    <div class="checkbox">
                                        <label for="option{{$i+1}}"></label>
                                        <input id="option{{$i+1}}" type="checkbox" name="option{{$index+1}}"
                                               value="{{ $d1->pk_i_id }}">
                                        {{ $d1->s_option_en }}
                                    </div>
                                @endforeach
                                <div id="option{{$index+1}}_validate"></div>
                            </div>
                        </div>
                    @elseif($book->i_answer_type == 2)

                        <div class="col-sm-12 hidden book" id="book{{$index+1}}">
                            <div class="form-group">
                                <legend>{{$book->s_question_en}}</legend>
                                {!! Form::hidden("question".($index+1),$book->pk_i_id) !!}
                                @foreach($book->questionOptions as $i=>$d1)
                                    <div class="radio">
                                        <label for="option{{$i}}"> </label>
                                        <input id="option{{$i}}" type="radio" value="{{ $d1->pk_i_id }}"
                                               name="option{{$index+1}}">
                                        {{ $d1->s_option_en }}

                                    </div>
                                @endforeach
                                <div id="option{{$index+1}}_validate"></div>
                            </div>
                        </div>

                    @elseif($book->i_answer_type == 4)
                        <div class="col-sm-12 hidden book" id="book{{$index+1}}">
                            <div class="form-group">
                                <div class="col-sm-6">

                                    {!! Form::label('question',$book->s_question_en) !!}
                                    {!! Form::hidden("question".($index+1),$book->pk_i_id) !!}
                                    {!! Form::hidden("text",'text') !!}
                                    <input type="text" name="option{{$index+1}}" class="form-control">
                                </div>
                                <div id="option{{$index+1}}_validate"></div>
                            </div>
                        </div>
                    @endif

                @endforeach

                <div class="col-sm-12 hidden book" id="book{{ count($booking)+1 }}">
                    <div id="description_validate"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('quotation_number','Quotation Number') !!}
                            {!! Form::text('quotation_number',null,['class'=>'form-control','id'=>'quotation_number']) !!}
                            <div id="quotation_number_validate"></div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('description','Description') !!}
                            {!! Form::textarea('description',null,['class'=>'form-control','id'=>'description']) !!}

                        </div>
                    </div>

                </div>
                <div class="col-sm-12 hidden book" id="book{{ count($booking)+2 }}">
                    {{--<div class="form-group">--}}
                    {{--<h3>Add Attachment</h3>--}}
                    {{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}
                    {{--<div class="fileinput-new thumbnail"--}}
                    {{--style="width: 200px; height: 150px;">--}}
                    {{--<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"--}}
                    {{--alt=""></div>--}}
                    {{--<div class="fileinput-preview fileinput-exists thumbnail"--}}
                    {{--style="max-width: 200px; max-height: 150px;"></div>--}}
                    {{--<div>--}}
                    {{--<span class="btn btn-default btn-file">--}}
                    {{--<span class="fileinput-new"> {{ trans('lang.select_image') }} </span>--}}
                    {{--<span class="fileinput-exists"> {{ trans('lang.change_img') }} </span>--}}
                    {{--<input type="file" name="file[]" multiple> </span>--}}
                    {{--<a href="javascript:;" class="btn btn-default fileinput-exists"--}}

                    {{--data-dismiss="fileinput"> {{trans('lang.remove')}} </a>--}}
                    {{--</div>--}}
                    {{--@if($errors->has('file'))--}}
                    {{--<strong class="font-red">{{ $errors->first('file') }}</strong>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</div>--}}


                    <input type="file" name="file[]" class="filestyle" data-input="false" data-badge="false" multiple id="gallery-photo-add">
                    <div class="row">
                        <div class="gallery" style="width: 100%;height: 200px;  overflow-y: scroll; "></div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            {!! Form::label('from',trans('lang.from')) !!}
                            {!! Form::text('from',isset($f)?$f:'',['class' =>'form-control date-picker','id'=>'fromForm']) !!}
                        </div>
                        <div class="form-group col-sm-4">
                            {!! Form::label('to',trans('lang.to')) !!}
                            {!! Form::text('to',isset($t)?$t:'',['class' =>'form-control date-picker','id'=>'toForm']) !!}
                        </div>

                    </div>
                </div>


                <div class="col-sm-12 hidden book" style="    position: absolute; left: 38%; top: 150px;"
                     id="book{{ count($booking)+3 }}">
                    <div class="form-group">
                        <button class="btn btn-success" id="submitBooking">Submit <span id="spinMe"
                                                                                        class='fa fa-spin fa-spinner fa-2x hidden'></span>
                        </button>

                    </div>
                </div>


            </div>

            <div class="col-sm-12 text-right" style=" position: absolute; bottom: 15px;right: 1px;">
                <button type="button" class="btn btn-primary pull-right bookingNext">
                    Next <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                </button>

                <button type="button" class="btn btn-primary pull-left bookingBack hidden">
                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
                </button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</div>

<script>
    var ratio = parseFloat(100 / parseInt("{{count($booking)+3}}"));
    var stepRatio = 0;

    var step = 0;
    var steps = parseFloat("{{count($booking)+3}}");
    $(function () {
        $('#book0').removeClass('hidden');
    });

    $('body').on('click', '.bookingNext', function () {
        if (parseInt(steps) != 0) {
            $('#book0').addClass('hidden');

            if (step > 0) {
//                alert("" + $("input[name='option" + step + "']").is(":checked"));
                if (!$("input[name='option" + step + "']").is(":checked")) {
                    if (step > parseInt("{{count($booking)}}")) {
                        if (step == parseInt("{{count($booking)+1}}")) {
                            if ($('#description').val().length == 0 || $('#quotation_number').val().length == 0 || isNaN($('#quotation_number').val())) {
                                $("#description_validate").html('you must fill all fields');
                                $("#description_validate").css('color', 'red');

                                if (isNaN($('#quotation_number').val())) {
                                    $("#quotation_number_validate").html('quotation field must contains number only');
                                    $("#quotation_number_validate").css('color', 'red');
                                } else {
                                    $("#quotation_number_validate").html('');
                                }

                            } else {
                                $("#description_validate").html('');
                                $("#quotation_number_validate").html('');
                                $('#book' + step).addClass('hidden');
                                $("#option" + step + "_validate").html('');
                                $('#book' + (step + 1)).removeClass('hidden');
                                $('.bookingBack').removeClass('hidden');
                                step = step + 1;
                                steps = steps - 1;
                                stepRatio = stepRatio + ratio;
                                if (step == parseInt("{{count($booking)+3}}")) {
                                    $('.bookingNext').addClass('hidden');
                                }
                                $('.progress-bar').css('width', (stepRatio).toFixed(2) + '%').attr('aria-valuenow', stepRatio.toFixed(2));
                                $('#bookingPercentage').html(stepRatio.toFixed(2) + '%');
                            }

                        } else {
                            $("#quotation_number_validate").html('');
                            $('#book' + step).addClass('hidden');
                            $("#option" + step + "_validate").html('');
                            $('#book' + (step + 1)).removeClass('hidden');
                            $('.bookingBack').removeClass('hidden');
                            step = step + 1;
                            steps = steps - 1;
                            stepRatio = stepRatio + ratio;
                            if (step == parseInt("{{count($booking)+3}}")) {
                                $('.bookingNext').addClass('hidden');
                            }
                            $('.progress-bar').css('width', (stepRatio).toFixed(2) + '%').attr('aria-valuenow', stepRatio.toFixed(2));
                            $('#bookingPercentage').html(stepRatio.toFixed(2) + '%');
                        }


                    } else {
                        $("#option" + step + "_validate").html('you must select one of the options');
                        $("#option" + step + "_validate").css('color', 'red');
                    }

                } else {
                    $('#book' + step).addClass('hidden');
                    $("#option" + step + "_validate").html('');
                    $('#book' + (step + 1)).removeClass('hidden');
                    $('.bookingBack').removeClass('hidden');
                    step = step + 1;
                    steps = steps - 1;
                    stepRatio = stepRatio + ratio;
                    if (step == parseInt("{{count($booking)+3}}")) {
                        $('.bookingNext').addClass('hidden');
                    }
                    $('.progress-bar').css('width', (stepRatio).toFixed(2) + '%').attr('aria-valuenow', stepRatio.toFixed(2));
                    $('#bookingPercentage').html(stepRatio.toFixed(2) + '%');
                }
            } else {
                $('#book' + step).addClass('hidden');
                $('#book' + (step + 1)).removeClass('hidden');
                $('.bookingBack').removeClass('hidden');
                step = step + 1;
                steps = steps - 1;
                stepRatio = stepRatio + ratio;
                if (step == parseInt("{{count($booking)+3}}")) {
                    $('.bookingNext').addClass('hidden');
                }

                $('.progress-bar').css('width', (stepRatio).toFixed(2) + '%').attr('aria-valuenow', stepRatio.toFixed(2));
                $('#bookingPercentage').html(stepRatio.toFixed(2) + '%');
            }


//            alert('step :' + step + ' steps: ' + steps);
        }

    });

    $('body').on('click', '.bookingBack', function () {
        if (parseInt(step) != 0) {
            $('#book' + (step)).addClass('hidden');
            $('#book' + (step - 1)).removeClass('hidden');
            step = step - 1;
            steps = steps + 1;
            if (step == 0) {
                $('.bookingBack').addClass('hidden');
            }
            if (step != parseInt("{{count($booking)+3}}")) {
                $('.bookingNext').removeClass('hidden');
            }

            stepRatio = stepRatio - ratio;
            $('.progress-bar').css('width', (Math.abs(stepRatio).toFixed(2)) + '%').attr('aria-valuenow', stepRatio.toFixed(2));
            $('#bookingPercentage').html(Math.abs(stepRatio).toFixed(2) + '%');
//            alert('step :' + step + ' steps: ' + steps);
        }

    });


</script>


<script>
    $('body').on('click', '#submitBooking', function () {
        $('#spinMe').removeClass('hidden');

        var formData = new FormData($("#bookingForm")[0]);
        $.ajax({
            url: "{{url('/')}}/request/{{$serviceId}}/getBookingData",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (data, textStatus, jqXHR) {
                if (data.status) {
                    swal("{{trans('lang.success')}}!", "{{ trans('lang.added') }}", "success");
                    setTimeout(function () {
                        window.location.href = "{{ action('Main\LandingPageController@index') }}";

                    }, 3000);
                    $('#spinMe').addClass('hidden');

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#spinMe').addClass('hidden');
            }
        });
        return false;


    });


</script>

<script>
    $(function () {
        $('.date-picker').datepicker({
            format: 'yyyy-m-dd'
        });
    });

</script>

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
    $(function(){
        $(".glyphicon").removeClass('icon-span-filestyle');
    });
    $(".glyphicon").removeClass('icon-span-filestyle');

</script>
</body>

</html>