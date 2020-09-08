<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<?php

$style = [
    /* Layout ------------------------------ */

    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
    'pull-right' => 'float:right;',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',

    /* Masthead ----------------------- */

    'email-masthead' => 'padding: 25px 0; text-align: center;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
    'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 35px;',

    'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
    'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

    /* Type ------------------------------ */

    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #3869D4;',
];
?>

<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

<body style="{{ $style['body'] }}">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="{{ $style['email-wrapper'] }}" align="center">
            <table width="100%" cellpadding="0" cellspacing="0">
                <!-- Logo -->
                <tr>

                    <td style=" {{ $style['email-masthead'] }}">
                        <img style="float: left;margin: -20px" src="{{url('/')}}/images/maqased-logo.png" alt="Website Logo">
                        <a style="{{ $fontFamily }} {{ $style['email-masthead_name'] }}" href="{{ url('/') }}"
                           target="_blank">
                            {{ $data->get('website_title')->s_value }}
                        </a>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td style="{{ $style['email-body'] }}" width="100%">
                        <table style="{{ $style['email-body_inner'] }}" align="center" width="570"
                               cellpadding="0"
                               cellspacing="0">
                            <tr>
                                @if($send == 'sendAdminData')
                                    <td style="{{ $fontFamily }}  {{ $style['email-body_cell'] }}">
                                        <!-- Greeting -->
                                        <h1 style="{{ $style['header-1'] }}">
                                            @if($default_lang == 'en')
                                                Mr\Ms :{!! $name !!}
                                            @else
                                                {!! $name !!} السيد/ة
                                            @endif

                                        </h1>

                                        <!-- Intro -->
                                        <p style="{{ $style['paragraph'] }}">
                                            {!! $msg !!}
                                        </p>


                                        <!-- Salutation -->
                                        <p style="{{ $style['paragraph'] }}">
                                            @if($default_lang == 'en') Regards @else  تحيات فريق العمل @endif
                                            ,<br>{{ $data->get('website_title')->s_value }}
                                        </p>

                                        <!-- Sub Copy -->
                                        <table style="{{ $style['body_sub'] }}">
                                            <tr>
                                                <td style="{{ $fontFamily }}">
                                                    <p style="{{ $style['paragraph-sub'] }}">
                                                    <table align="center" width="570"
                                                           cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            @if( isset($data->get('website_url')->s_value))
                                                                <td>
                                                                    <a href="{{ $data->get('website_url')->s_value}}">Website
                                                                        Url</a></td>
                                                            @endif
                                                            @if( isset($data->get('twitter_url')->s_value))
                                                                <td>
                                                                    <a href="{{ $data->get('twitter_url')->s_value}}"><img
                                                                                width="24" height="24"
                                                                                src="{{url('/')}}/images/tw.png"
                                                                                alt="twitter"></a></td>
                                                            @endif
                                                            @if( isset($data->get('facebook_url')->s_value))
                                                                <td>
                                                                    <a href="{{ $data->get('facebook_url')->s_value}}"><img
                                                                                width="24" height="24"
                                                                                src="{{url('/')}}/images/fb.png"
                                                                                alt="Facebook"></a></td>
                                                            @endif
                                                        </tr>
                                                    </table>
                                                    </p>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                @endif
                                @if($send == 'sendUserData')
                                    <td style="{{ $fontFamily }}  {{ $style['email-body_cell'] }}">
                                        <!-- Greeting -->
                                        <h1 style="{{ $style['header-1'] }}">
                                            @if($default_lang == 'en')
                                                Mr\Ms :{!! $name !!}
                                            @else
                                                {!! $name !!} السيد/ة
                                            @endif

                                        </h1>

                                        <!-- Intro -->
                                        <p style="{{ $style['paragraph'] }}">
                                        @if($default_lang == 'en')
                                            <h2>Your account has been activated</h2>
                                            <h3>Your Email :{{$email}}</h3>
                                            <h3>Your password :{{$password}}</h3>
                                            <a href="{{ $data->get('website_url')->s_value }}">Website Url</a>
                                        @else
                                            <h2>تم تفعيل حسابك بنجاح</h2>
                                            <h3>{{$email}} الايميل :</h3>
                                            <h3>{{$password}} كلمة المرور:</h3>
                                            <a href="{{ $data->get('website_url')->s_value }}">رابط الموقع</a>
                                            @endif
                                            </p>


                                            <!-- Salutation -->
                                            <p style="{{ $style['paragraph'] }}">
                                                @if($default_lang == 'en') Regards @else  تحيات فريق العمل @endif
                                                <br>{{ $data->get('website_title')->s_value }}
                                            </p>

                                            <!-- Sub Copy -->
                                            <table style="{{ $style['body_sub'] }}">
                                                <tr>
                                                    <td style="{{ $fontFamily }}">
                                                        <p style="{{ $style['paragraph-sub'] }}">
                                                        <table align="center" width="570"
                                                               cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                @if( isset($data->get('website_url')->s_value))
                                                                    <td>
                                                                        <a href="{{ $data->get('website_url')->s_value}}">Website
                                                                            Url</a></td>
                                                                @endif
                                                                @if( isset($data->get('facebook_url ')->s_value))
                                                                    <td>
                                                                        <a href="{{ $data->get('facebook_url ')->s_value}}"><img
                                                                                    width="24" height="24"
                                                                                    src="{{url('/')}}/images/tw.png"
                                                                                    alt="twitter"></a></td>
                                                                @endif
                                                                @if(isset($data->get('twitter_url')->s_value))
                                                                    <td>
                                                                        <a href="{{ $data->get('twitter_url')->s_value}}"><img
                                                                                    width="24" height="24"
                                                                                    src="{{url('/')}}/images/fb.png"
                                                                                    alt="Facebook"></a></td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                                        </p>

                                                    </td>
                                                </tr>
                                            </table>
                                    </td>
                                @endif

                                @if($send == 'sendVerificationCode')
                                    <td style="{{ $fontFamily }}  {{ $style['email-body_cell'] }}">
                                        <!-- Greeting -->
                                        <h1 style="{{ $style['header-1'] }}">
                                            @if($default_lang == 'en')
                                                Mr\Ms :{!! $name !!}
                                            @else
                                                {!! $name !!} السيد/ة
                                            @endif

                                        </h1>

                                        <!-- Intro -->
                                        <p style="{{ $style['paragraph'] }}">
                                            <a href="{{route('login.create',['pass_code' => $pass_code,'user_id' => $user_id])}}">
                                                @if($default_lang == 'en')
                                                    <h3>follow this link to activate your account</h3>
                                                @else
                                                    <h3>الرجاء الضغط على هذا الرابط لتفعيل حسابك</h3>
                                                @endif
                                            </a>
                                        </p>


                                        <!-- Salutation -->
                                        <p style="{{ $style['paragraph'] }}">
                                            @if($default_lang == 'en') Regards @else  تحيات فريق العمل @endif
                                            ,<br>{{ $data->get('website_title')->s_value }}
                                        </p>

                                        <!-- Sub Copy -->
                                        <table style="{{ $style['body_sub'] }}">
                                            <tr>
                                                <td style="{{ $fontFamily }}">
                                                    <p style="{{ $style['paragraph-sub'] }}">
                                                    <table align="center" width="570"
                                                           cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            @if( isset($data->get('website_url')->s_value))
                                                                <td>
                                                                    <a href="{{ $data->get('website_url')->s_value}}">Website
                                                                        Url</a></td>
                                                            @endif
                                                            @if( isset($data->get('facebook_url ')->s_value))
                                                                <td>
                                                                    <a href="{{ $data->get('facebook_url ')->s_value}}"><img
                                                                                width="24" height="24"
                                                                                src="{{url('/')}}/images/tw.png"
                                                                                alt="twitter"></a></td>
                                                            @endif
                                                            @if( isset($data->get('twitter_url')->s_value))
                                                                <td>
                                                                    <a href="{{ $data->get('twitter_url')->s_value}}"><img
                                                                                width="24" height="24"
                                                                                src="{{url('/')}}/images/fb.png"
                                                                                alt="Facebook"></a></td>
                                                            @endif
                                                        </tr>
                                                    </table>
                                                    </p>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                @endif

                                @if($send == 'restorePassword')
                                    <td style="{{ $fontFamily }}  {{ $style['email-body_cell'] }}">
                                        <!-- Greeting -->
                                        <h1 style="{{ $style['header-1'] }}">
                                            @if($default_lang == 'en')
                                                Mr\Ms :{!! $name !!}
                                            @else
                                                {!! $name !!} السيد/ة
                                            @endif

                                        </h1>

                                        <!-- Intro -->
                                        <p style="{{ $style['paragraph'] }}">
                                        @if($default_lang == 'en')
                                            <h4> Your Password : {{$password}} </h4>

                                            <h3><a href="{{route('login.index')}}">Go to Website</a></h3>
                                        @else
                                            <h4> كلمة المرور : {{$password}} </h4>
                                            <h3><a href="{{route('login.index')}}">اذهب للموقع</a></h3>

                                            @endif
                                            </p>


                                            <!-- Salutation -->
                                            <p style="{{ $style['paragraph'] }}">
                                                @if($default_lang == 'en') Regards @else  تحيات فريق العمل @endif
                                                ,<br>{{ $data->get('website_title')->s_value }}
                                            </p>

                                            <!-- Sub Copy -->
                                            <table style="{{ $style['body_sub'] }}">
                                                <tr>
                                                    <td style="{{ $fontFamily }}">
                                                        <p style="{{ $style['paragraph-sub'] }}">
                                                        <table align="center" width="570"
                                                               cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                @if(isset($data->get('website_url')->s_value))
                                                                    <td>
                                                                        <a href="{{ $data->get('website_url')->s_value}}">Website
                                                                            Url</a></td>
                                                                @endif
                                                                @if( isset($data->get('facebook_url ')->s_value))
                                                                    <td>
                                                                        <a href="{{ $data->get('facebook_url ')->s_value}}"><img
                                                                                    width="24" height="24"
                                                                                    src="{{url('/')}}/images/tw.png"
                                                                                    alt="twitter"></a></td>
                                                                @endif
                                                                @if( isset($data->get('twitter_url')->s_value))
                                                                    <td>
                                                                        <a href="{{ $data->get('twitter_url')->s_value}}"><img
                                                                                    width="24" height="24"
                                                                                    src="{{url('/')}}/images/fb.png"
                                                                                    alt="Facebook"></a></td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                                        </p>

                                                    </td>
                                                </tr>
                                            </table>
                                    </td>
                                @endif
                                @if($send == "providerMSG")
                                    <td><h3>{{ $msg }}</h3></td>
                                    <br>
                                    <td><a href="{{ $data->get('website_url')->s_value}}">Website Url</a></td>
                                @endif
                            </tr>
                        </table>
                    </td>

                </tr>
                <!-- Footer -->
                <tr>
                    <td>
                        <table style="{{ $style['email-footer'] }}" align="center" width="570" cellpadding="0"
                               cellspacing="0">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}">
                                    <p style="{{ $style['paragraph-sub'] }}">
                                        &copy; {{ date('Y') }}
                                        <a style="{{ $style['anchor'] }}" href="{{ url('/') }}"
                                           target="_blank">{{ $data->get('website_title')->s_value }}</a>.
                                        All rights reserved.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
