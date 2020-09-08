<!DOCTYPE html>
@if(app()->getLocale() == 'ar')
    <html lang="en" dir="rtl">
    @endif
    @if(app()->getLocale() == 'en')
        <html lang="en">
        @endif
                <!--<![endif]-->
        <!-- BEGIN HEAD -->
        <head>
            <meta charset="utf-8"/>
            <title>@yield('head_title')</title>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="width=device-width, initial-scale=1" name="viewport"/>
            <meta content="Preview page of Metronic Admin Theme #1 for statistics, charts, recent events and reports"
                  name="description"/>
            <meta content="" name="author"/>
            <!-- BEGIN GLOBAL MANDATORY STYLES -->
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
                  />
            <link href="{{asset('/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
            <link href="{{asset('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" />

            @if(app()->getLocale() == 'ar')
                <link href="{{asset('/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet"
                      />
                <link href="{{asset('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css')}}"
                      rel="stylesheet"
                      />
            @endif
            <link href="{{asset('/assets/global/plugins/jstree/dist/themes/default/style.min.css')}}" rel="stylesheet"
                  />
            <link href="{{asset('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"
                  rel="stylesheet"
                  />
            <link href="{{asset('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}"
                  rel="stylesheet"
                  />
            <link href="{{asset('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}"
                  rel="stylesheet" />
            <link href="{{asset('/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet"
                  />
            <link href="{{asset('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}"
                  rel="stylesheet"
                  />
            @if(app()->getLocale() == 'en')
                <link href="{{asset('/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
                      />
                <link href="{{asset('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}"
                      rel="stylesheet"
                      />

            @endif
            <link href="{{asset('/assets/global/plugins/jstree/dist/themes/default/style.min.css')}}" rel="stylesheet"
                  />
            <link href="{{asset('/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}"
                  rel="stylesheet"
                  />

            <link href="{{asset('/assets/global/plugins/jquery-multi-select/css/multi-select.css')}}" rel="stylesheet" />

            <link href="{{asset('/assets/pages/css/jasny-bootstrap.min.css')}}" rel="stylesheet" />
            <link href="{{asset('/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet"
                  />
            <link href="{{asset('/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet"
                  />
            <!-- END GLOBAL MANDATORY STYLES -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <link href="{{asset('/assets/global/plugins/morris/morris.css')}}" rel="stylesheet" />

            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL STYLES -->
            @if(app()->getLocale() == 'ar')
                <link href="{{asset('/assets/global/css/components-rtl.min.css')}}" rel="stylesheet"
                      id="style_components"
                      />
                <link href="{{asset('/assets/global/css/plugins-rtl.min.css')}}" rel="stylesheet" />
                <link href="{{asset('/assets/pages/css/pricing.min.css')}}" rel="stylesheet" />
                <link href="{{asset('/assets/pages/css/profile.min.css')}}" rel="stylesheet" />

                <!-- END THEME GLOBAL STYLES -->
                <!-- BEGIN THEME LAYOUT STYLES -->
                <link href="{{asset('/assets/layouts/layout/css/layout-rtl.min.css')}}" rel="stylesheet"
                      />
                <link href="{{asset('/assets/layouts/layout/css/themes/darkblue-rtl.min.css')}}" rel="stylesheet"
                      
                      id="style_color"/>
            @endif
            @if(app()->getLocale() == 'en')
                <link href="{{asset('/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components"
                      />
                <link href="{{asset('/assets/global/css/plugins.min.css')}}" rel="stylesheet" />
                <link href="{{asset('/assets/pages/css/pricing.min.css')}}" rel="stylesheet" />
                <link href="{{asset('/assets/pages/css/profile.min.css')}}" rel="stylesheet" />


                <!-- END THEME GLOBAL STYLES -->
                <!-- BEGIN THEME LAYOUT STYLES -->
                <link href="{{asset('/assets/layouts/layout/css/layout.min.css')}}" rel="stylesheet" />
                <link href="{{asset('/assets/layouts/layout/css/themes/darkblue.min.css')}}" rel="stylesheet"
                      
                      id="style_color"/>
            @endif
            <link href="{{asset('/assets/layouts/layout/css/custom.css')}}" rel="stylesheet" />
            <link href="{{asset('/css/dropzone.css')}}" rel="stylesheet" />
            <link href="{{asset('/css/sweetalert.css')}}" rel="stylesheet" />
            <link href="{{asset('/css/lightbox.min.css')}}" rel="stylesheet" />
            <link href="{{asset('/css/style.css')}}" rel="stylesheet" />
            <link href="{{asset('/assets/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet"/>
            <link href="{{asset('/assets/global/plugins/fullcalendar/fullcalendar.print.css')}}" rel="stylesheet"
                  media='print'/>
            <script src="{{asset('/assets/global/plugins/jquery.min.js')}}" ></script>
            <link href="{{asset('/assets/global/css/autocomplete.css')}}" rel="stylesheet"/>

            <!-- END THEME LAYOUT STYLES -->
            <link rel="shortcut icon" href="favicon.ico"/>

            <style>
                .margin-right-10 {
                    margin-right: 10px;
                }
            </style>
            <style>

                .select2-dropdown--below, .select {
                    z-index: 100000 !important;
                }

                input.select2-search__field, .select {
                    width: 100% !important;
                }

                ul.select2-selection__rendered, .select {
                    /*padding-right: 8px!important;*/
                }

                li.select2-search--inline, .select {
                    float: right !important;
                }
            </style>
            @yield('styles')

        </head>
        <!-- END HEAD -->

        <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">


        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">

                @yield('msg')

                        <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">

                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="#">
                            <img src="{{asset('/assets/layouts/layout/img/logo.png')}}" alt="logo"
                                 class="logo-default"/> </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">

                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->


                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <input id="last_date" type="hidden" value="{{ $last_date }}">
                                <a href="javascript:;" id="show_notifications" class="dropdown-toggle"
                                   data-toggle="dropdown"
                                   data-hover="dropdown"
                                   data-close-others="true" aria-expanded="true">
                                    <i class="icon-bell"></i>
                                    @if($notifications_count[0]->cou != 0)
                                    <span class="badge badge-default"> {{$notifications_count[0]->cou }} </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>@lang('lang.notifications')</h3>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;"
                                            data-handle-color="#637283">
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
                                                        <a href="{{$not->s_url == '#'?'#':route($not->s_url,$not->s_ids)}}">
                                                            <span class="time">{{$not->dt_created_date}}</span><span
                                                                    class="details"><span
                                                                        class="label label-sm label-icon label-success"><i
                                                                            class="fa fa-plus"></i></span> {{ !empty($not->s_title)?$not->s_title:$not->title}}</span>
                                                        </a>
                                                    @endif

                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- END NOTIFICATION DROPDOWN -->
                            <!-- BEGIN INBOX DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                            {{--BEGIN LANGUAGE DROPDOWN--}}
                            <li class="dropdown dropdown-language">
                                @if(app()->getLocale() == 'en')
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                       data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                        <img alt="" src="{{asset('/assets/global/img/flags/us.png')}}">
                                        <span class="langname"> @lang('lang.us') </span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                @else
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                       data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                        <img alt="" src="{{asset('/assets/global/img/flags/ae.png')}}"> <span
                                                class="langname"> @lang('lang.ar') </span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                @endif
                                <ul class="dropdown-menu dropdown-menu-default">

                                    @if(app()->getLocale() == 'en')
                                        <li>

                                            <a href="{{route('language.change','ar')}}">
                                                <img alt=""
                                                     src="{{asset('/assets/global/img/flags/ae.png')}}"> @lang('lang.arabic')

                                            </a>
                                        </li>
                                    @else
                                        <li>

                                            <a href="{{route('language.change','en')}}">
                                                <img alt=""
                                                     src="{{asset('/assets/global/img/flags/us.png')}}"> @lang('lang.english')
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                   data-hover="dropdown"
                                   data-close-others="true">
                                    <img alt="" class="img-circle"
                                         src="{{ isset($user->s_pic)? asset("/images/users_images/".$user->s_pic):asset('/images/users_images/avatar.png') }}"/>
                                    <span class="username username-hide-on-mobile"> {{ isset($user)?$user->s_first_name.' '.$user->s_last_name:""  }} </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="{{action('ProfileController@index')}}">
                                            <i class="icon-user"></i> @lang('lang.my_profile') </a>
                                    </li>

                                    <li>
                                        <a href="{{route('logout')}}">
                                            <i class="icon-key"></i> @lang('lang.log_out')</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->

                </div>
                <!-- END HEADER INNER -->

            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"></div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false"
                            data-auto-scroll="true"
                            data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->

                            <li class="nav-item">
                                <a href="{{route('user.main')}}" class="nav-link nav-toggle">
                                    <i class="fa fa-tachometer"></i>
                                    <span class="title">@lang('lang.dashboard')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('home')}}" class="nav-link nav-toggle">
                                    <i class="fa fa-home"></i>
                                    <span class="title">@lang('lang.website')</span>
                                </a>
                            </li>
                            @if($user->userRule->s_name_en != 'SuperAdmin')
                            <li class="nav-item">
                                <a href="{{action('MainController@getNotifications')}}" class="nav-link nav-toggle">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="title">@lang('lang.notifications')</span>
                                </a>
                            </li>
                            @endif
                            @if($user->userRule->s_name_en == 'ServiceProviderUser')
                                <li class="nav-item">
                                    <a href="{{route('quotations.show')}}" class="nav-link nav-toggle">
                                        <i class="fa fa-inbox"></i>
                                        <span class="title">@lang('lang.receiveQuotations')</span>
                                    </a>
                                </li>
                            @endif
                            @if($user->userRule->s_name_en == 'SuperAdmin')

                                <li class="nav-item">
                                    <a href="{{action('AdminController@systemSettings')}}" class="nav-link nav-toggle">
                                        <i class="fa fa-cogs"></i>
                                        <span class="title">@lang('lang.systemSettings')</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{route('showCategories')}}" class="nav-link nav-toggle">
                                        <i class="fa fa-tasks"></i>
                                        <span class="title">@lang('lang.categories')</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ action('AdminController@showAllUsers') }}" class="nav-link nav-toggle">
                                        <i class="fa fa-users"></i>
                                        <span class="title">@lang('lang.users')</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="title">@lang('lang.notifications')</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: none;">
                                        <li class="nav-item  ">
                                          {{--<a href="{{route('admin.notifications.send')}}" class="nav-link ">--}}
                                          <a href="#" class="nav-link ">
                                               <i class="fa fa-television"></i>
                                                <span class="title">@lang('lang.show')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  ">
                                            <a href="#" class="nav-link ">
                                                <i class="fa fa-paper-plane-o"></i>
                                                <span class="title">@lang('lang.send_notification')</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>



                                <li class="nav-item">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-notebook"></i>
                                        <span class="title">@lang('lang.serviceProvider')</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: none;">
                                        <li class="nav-item  ">
                                            <a href="{{ action('AdminController@serviceProvider') }}" class="nav-link ">
                                                <span class="title">@lang('lang.show')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  ">
                                            <a href="{{route('admin.service')}}" class="nav-link ">
                                                <span class="title">@lang('lang.updates')</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ action('AdminController@subscribePlan') }}" class="nav-link nav-toggle">
                                        <i class="icon-drawer"></i>
                                        <span class="title">@lang('lang.subscribePlan')</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ action('AdminController@showConstant') }}" class="nav-link nav-toggle">
                                        <i class="icon-grid"></i>
                                        <span class="title">@lang('lang.locations')</span>
                                    </a>
                                </li>
                            @endif
                            @if($user->userRule->s_name_en == 'ServiceProviderAdmin')

                                <li class="nav-item">
                                    <a href="{{action('ServiceProviderController@serviceProviderProfile')}}"
                                       class="nav-link nav-toggle">
                                        <i class="icon-docs"></i>
                                        <span class="title">@lang('lang.serviceProviderProfile')</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ action('AdminController@showAllUsers') }}" class="nav-link nav-toggle">
                                        <i class="fa fa-users"></i>
                                        <span class="title">@lang('lang.users')</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ route('requests.show') }}" class="nav-link nav-toggle">
                                        <i class="icon-basket"></i>
                                        <span class="title">@lang('lang.requests')</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ action('ServiceProviderController@messageIndex') }}" class="nav-link nav-toggle">
                                        <i class="fa fa-bullhorn"></i>
                                        <span class="title">@lang('lang.conversations')</span>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="{{ action('ServiceProviderController@showServices') }}" class="nav-link nav-toggle">
                                        <i class="fa fa-plus-square"></i>
                                        <span class="title">@lang('lang.addServices')</span>
                                    </a>
                                </li>

                            @endif


                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE TITLE-->
                        <h2 class="page-title">
                            @yield('title')
                        </h2>


                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                @yield('content')


                            </div>

                        </div>

                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> {{date('Y')}} &copy; Tabebk
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>

        <div class="quick-nav-overlay"></div>
        <!-- END QUICK NAV -->
        <!--[if lt IE 9]>
        <script src="{{asset('/assets/global/plugins/respond.min.js')}}"></script>
        <script src="{{asset('/assets/global/plugins/excanvas.min.js')}}"></script>
        <script src="{{asset('/assets/global/plugins/ie8.fix.min.js')}}"></script>
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{asset('/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" ></script>
        <script src="{{asset('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"
                ></script>
        <script src="{{asset('/assets/global/plugins/jstree/dist/jstree.min.js')}}" ></script>
        <script src="{{asset('/assets/global/scripts/datatable.js')}}" ></script>
        <script src="{{asset('/assets/global/plugins/datatables/datatables.min.js')}}" ></script>
        <script src="{{asset('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"
                ></script>
        <script src="{{asset('/assets/global/plugins/datatables/plugins/bootstrap/table-datatables-ajax.min.js')}}"
                ></script>
        <script src="{{asset('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}"
                ></script>
        <script src="{{asset('/assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}"
                ></script>
        <script src="{{asset('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"
                ></script>

        <script src="{{asset('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}"
                ></script>
        <script src="{{asset('/')}}/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"
                ></script>
        <script src="{{asset('/assets/global/plugins/select2/js/select2.full.min.js')}}"
                ></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset('/assets/global/plugins/jquery.sparkline.min.js')}}" ></script>

        <script src="{{asset('/assets/global/plugins/moment.min.js')}}" ></script>
        <script src="{{asset('/assets/global/plugins/morris/morris.min.js')}}" ></script>
        <script src="{{asset('/assets/global/plugins/morris/raphael-min.js')}}" ></script>
        <script src="{{asset('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"
                ></script>
        <script src="{{asset('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"
                ></script>

        <script src="{{asset('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"
                ></script>

        <script src="{{asset('/assets/global/plugins/counterup/jquery.waypoints.min.js')}}"
                ></script>
        <script src="{{asset('/assets/global/plugins/counterup/jquery.counterup.min.js')}}"
                ></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{asset('/assets/global/scripts/app.min.js')}}" ></script>
        <script src="{{asset('/assets/pages/scripts/profile.min.js')}}" ></script>
        <script src="{{asset('/assets/pages/scripts/jasny-bootstrap.min.js')}}" ></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        {{--<script src="/assets/pages/scripts/dashboard.min.js" ></script>--}}
                <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{asset('/assets/pages/scripts/table-datatables-responsive.min.js')}}"
                ></script>
        <script src="{{asset('/assets/layouts/layout/scripts/layout.min.js')}}" ></script>
        <script src="{{asset('/assets/pages/scripts/table-datatables-ajax.min.js')}}" ></script>
        <script src="{{asset('/js/dropzone.js')}}" ></script>
        <script src="{{asset('/js/sweetalert.min.js')}}" ></script>
        <script src="{{asset('/js/moment-timezone-with-data.min.js')}}" ></script>
        <script src="{{asset('/js/lightbox.min.js')}}" ></script>


        <script src="{{asset('/assets/pages/scripts/components-multi-select.min.js')}}" ></script>
        <script src="{{asset('/assets/global/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>
        <script src="{{asset('/assets/global/scripts/autocomplete.js')}}" ></script>
        <script src="{{asset('/js/bootstrap-filestyle.min.js')}}" ></script>


        <!-- END THEME LAYOUT SCRIPTS -->

            <script>

            $('body').on('click', '#show_notifications', function () {
                var token = "{{ csrf_token() }}";
                var last_date = $('#last_date').val();
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: '{{url('/')}}/admin/notifications/updateNotifications',
                    data: {
                        "_token": token,
                        "last_date": last_date
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.status) {
                            $('#header_notification_bar').html(data.view);
                            $('#last_date').val(data.last_date);
                        } else {
                            $('#header_notification_bar').html(data.view);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    }
                });
            });


        </script>
        <script>
            $(function () {
                $('.select').select2();
            });
            $('.select').select2();
        </script>

        <script>
            $(function () {
                setInterval(function () {
                    var last_date = $('#last_date').val();
                    $.ajax({
                        method: "POST",
                        url: "{{ action('AdminController@getAllNotifications') }}",
                        dataType: "json",
                        data: {"last_date": last_date, "_token": "{{ csrf_token() }}"},
                        success: function (data, textStatus, jqXHR) {
                            if (data.status) {
                                $('#header_notification_bar').html(data.view);
                                $('#last_date').val(data.last_date);
                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });

                }, 5000);
            });
        </script>
        @yield('scripts')
        </body>

        </html>