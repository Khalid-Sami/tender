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

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{asset('/MainAssets/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{asset('/MainAssets/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{asset('/MainAssets/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed"
          href="{{asset('/MainAssets/images/ico/apple-touch-icon-57-precomposed.png')}}">
    <link rel="shortcut icon" href="{{asset('/MainAssets/images/ico/favicon.png')}}">

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
    <!-- For your own style -->
    <link href="{{asset('/MainAssets/css/your-style.css')}}" rel="stylesheet">
    <link href="{{asset('/MainAssets/main.css')}}" rel="stylesheet"/>
    <link href="{{asset('/MainAssets/css/media.css')}}" rel="stylesheet">
    <link href="{{asset('/MainAssets/font-awesome-4.7.0/css/font-awesome.css')}}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- main core js -->
    <script type="text/javascript" src="{{asset('/MainAssets/js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/MainAssets/js/jquery-migrate-1.4.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/MainAssets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/MainAssets/js/jquery.waypoints.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/MainAssets/js/jquery.easing.1.3.js')}}"></script>
    <script type="text/javascript" src="{{asset('/MainAssets/js/SmoothScroll.min.js')}}"></script>


    <!-- plugins js -->
    <script type="text/javascript" src="{{asset('/MainAssets/js/plugins.js')}}"></script>

    <!-- custom js -->
    <script type="text/javascript" src="{{asset('/MainAssets/js/customs.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{asset('/MainAssets/js/typed.js')}}" type="text/javascript"></script>

    <script>
        $(function () {

            $("#typed").typed({
                // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
                stringsElement: $('#typed-strings'),
                typeSpeed: 30,
                backDelay: 500,
                loop: true,
                contentType: 'html', // or text
                // defaults to false for infinite loop
                loopCount: false,
                callback: function () {
                    foo();
                },
                resetCallback: function () {
                    newTyped();
                }
            });

            $(".reset").click(function () {
                $("#typed").typed('reset');
            });

        });

        function newTyped() { /* A new typed object */
        }

        function foo() {
        }

    </script>

</head>


<body class="transparent-header">


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
                            <img src="{{ asset('/MainAssets/unspecified.jpg') }}" alt="Logo"/>
                        </a>

                    </div>

                    <div class="flex-columns">

                        <div class="pull-right">


                            <div class="navbar-mini pull-left">

                                <ul class="clearfix">

                                    <li class="add-list">
                                        <a href="{{action('RegisterController@createServiceProvider')}}">Become A Professional <i class="fa fa-plus-circle"></i></a>
                                    </li>
                                    <li class="login">
                                        <a href="{{ action('LoginController@login') }}" class="btn btn-primary btn-inverse btn-sm">Sign up/in</a>
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

    <script>

        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            if (scroll >= 3200) {
                $("#img-absolute").addClass("he-head");
            } else {
                $("#img-absolute").removeClass("he-head");

            }
        });

    </script>

    <!-- start Main Wrapper -->
    <div class="all row" style="min-height: 600px !important;">

        <!-- start Hero Header -->
        <section id="img-absolute" class="hero-header  col-md-6 col-xs-12 ">

            <section class="hero-header-texting hidden-xs">

                <div class="container">
                    <div class="wrap">x
                        <div id="typed-strings">
                            <p><span class="type-text">Find The <span class="color-text">Best Services</span> In Your City</span>
                            </p>
                            <p><span class="type-text">The Best way to Hire <span class="color-text">Photographer</span></span>
                            </p>
                            <p><span class="type-text">The Best way to Hire <span
                                            class="color-text">Plumbers</span></span></p></span>
                            <p><span class="type-text">The Best way to Hire <span class="color-text">Beauticians</span></span>
                            </p></span>

                        </div>
                        <span id="typed"></span>

                    </div>

                    <p>Find great services to beauty, learn, wedding , or interests from local experts.</p>
                </div>

            </section>

            <div class="main-search-form-wrapper-01">

                <div class="">

                    <div class="main-search-form-inner bg-change-focus-addclass-wrapper">

                        <form>

                            <div class="form-holder">

                                <div class="row gap-1">

                                    <div class="col-xss-12 col-xs-12 col-sm-4 col-md-4">

                                        <div class="row gap-1">

                                            <div class="col-xss-12 col-xs-12 col-sm-12">

                                                <div class="form-group bg-change-focus-addclass">
                                                    <label>Location</label>
                                                    <select class="form-control selectpicker address"
                                                            data-none-selected-text="Location"
                                                            data-data-done-button="true" data-done-button-text="OK">
                                                        @foreach($addresses as $address)
                                                            @if(strcmp($address->s_address , 'Dubai') == 0 )
                                                                <option class="b-top"
                                                                        value="{{$address->s_address}}"
                                                                        selected="selected">{{$address->s_address}}</option>
                                                            @else
                                                                <option value="{{$address->s_address}}">{{$address->s_address}}</option>
                                                            @endif
                                                        @endforeach

                                                    </select>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-xss-12 col-xs-12 col-sm-8 col-md-8">

                                        <div class="form-group bg-change-focus-addclass mb-1-xs">
                                            <label>Keyword</label>
                                            <input id="EasyAutocompleteCategories" type="text" class="form-control"
                                                   placeholder="Search for a service"/>
                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="btn-holder">

                                <a href="#" class="btn btn-block btn-primary">Search</a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
            <div class="under-search hidden-xs">
                <div class="first-row">
                    <span class="first-number">64</span>
                    <br>
                    <span class="first-word">Live Servicess</span>
                </div>
                <div class="first-row">
                    <span class="first-number">1.5 million</span>
                    <br>
                    <span class="first-word">Customers Served</span>
                </div>
                <div class="first-row">
                    <span class="first-number">65,000</span>
                    <br>
                    <span class="first-word">Verified Experts</span>
                </div>
                <div class="first-row">
                    <span class="first-number">4.2</span>
                    <br>
                    <span class="first-word">Average Rating</span>
                </div>
            </div><!--under-search end-->

            <div class="contact hidden-xs">
                <ul>
                    <li><a href="{{ asset('/MainAssets/about-us.html') }}">About</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="{{ asset('/MainAssets/blog.html') }}">Blog</a></li>
                    <li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="{{ asset('/MainAssets/contact.html') }}">Contact Us</a></li>
                    <li><a  href="#">Join As Professional</a></li>
                </ul>
            </div><!--contact end-->
        </section><!-- end Hero Header -->


        <section id="show-height" class="show col-md-6 col-xs-12">

            <div class="second-box col-lg-12 col-md-6 col-xs-12">
                <div class="higlyServiceTitle">
                    <h2>
                        <span>Trending Services in</span>
                        <span class="blue">Dubai</span>
                    </h2>
                </div>
                <div class="second-icon ">
                    <h2 class="errorWithHiglyTrending hidden"></h2>
                    <a class="second-a hidden  clone">

                        <div class="icon-a">
                            <span class="serviceIcon"><i class=""></i></span>
                        </div>
                        <p class="serviceName">Get Services</p>
                    </a>
                    <div class="box-view hidden">
                        <div class="line-box col-sm-4 col-xs-12 ">
                            <a class="box-inner" href="">
                                <div class="box-pic"><img src="" class="serviceImage"/></div>
                                <h3>Salon At Home</h3>
                                <div class="box-info">
                                    <div class="info-txt">
                                        <span>no. of pros:</span>
                                        <span class="sp-plus">288</span>
                                    </div>
                                    <div class="content-bottom">

                                        <div class="rating-item">
												<span>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground fore">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                </span>
                                        </div>


                                    </div>
                                    <button class="box-bton bookMe">Book Now</button>

                                </div>
                            </a>
                        </div>
                    </div>

                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-bath"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<div class="line-box col-sm-4 col-xs-12  hidden clone">--}}
                    {{--<a class="box-inner" href="">--}}
                    {{--<div class="box-pic-noUrl"><img src="" class="serviceImage"/></div>--}}
                    {{--<h3 >Salon At Home</h3>--}}
                    {{--<div class="box-info">--}}
                    {{--<div class="info-txt">--}}
                    {{--<span>no. of pros:</span>--}}
                    {{--<span class="sp-plus">288</span>--}}
                    {{--</div>--}}
                    {{----}}
                    {{--<div class="content-bottom">--}}

                    {{--<div class="rating-item">--}}
                    {{--<span>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground fore">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</span>--}}
                    {{--</div>--}}


                    {{--</div>--}}
                    {{--<button class="box-bton bookMe">Book Now</button>--}}
                    {{--</div>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="line-box col-sm-4 col-xs-12">--}}
                    {{--<a class="box-inner" href="">--}}
                    {{--<div class="box-pic-3"></div>--}}
                    {{--<h3>Salon At Home</h3>--}}
                    {{--<div class="box-info">--}}
                    {{--<div class="info-txt">--}}
                    {{--<span>no. of pros:</span>--}}
                    {{--<span class="sp-plus">288</span>--}}
                    {{--</div>--}}
                    {{--<div class="content-bottom">--}}

                    {{--<div class="rating-item">--}}
                    {{--<span>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground fore">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</span>--}}
                    {{--</div>--}}


                    {{--</div>--}}
                    {{--<button class="box-bton bookMe">Book Now</button>--}}
                    {{--</div>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="line-box col-sm-4 col-xs-12">--}}
                    {{--<a class="box-inner" href="">--}}
                    {{--<div class="box-pic-3"></div>--}}
                    {{--<h3>Salon At Home</h3>--}}
                    {{--<div class="box-info">--}}
                    {{--<div class="info-txt">--}}
                    {{--<span>no. of pros:</span>--}}
                    {{--<span class="sp-plus">288</span>--}}
                    {{--</div>--}}
                    {{--<div class="content-bottom">--}}

                    {{--<div class="rating-item">--}}
                    {{--<span>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground fore">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</span>--}}
                    {{--</div>--}}


                    {{--</div>--}}
                    {{--<button class="box-bton bookMe">Book Now</button>--}}
                    {{--</div>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-car"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-laptop"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-paint-brush"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-cutlery"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-tint"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-camera"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-map-marker"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-apple"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                    {{--<a class="second-a">--}}
                    {{--<div class="icon-a">--}}
                    {{--<span><i class="fa fa-home"></i></span>--}}
                    {{--</div>--}}
                    {{--<p>Get Services</p>--}}
                    {{--</a>--}}
                </div>
            </div>
            <!-- second-box -->


            <!------------------------------------------->


            <div class="first-box categoryClone hidden">


                <div class="">
                    <div class="">
                        <h2 class="categoryName"></h2>
                        <button type="button " class="box-button btn btn-info btn-lg putCategoryName"
                                data-toggle="modal"
                                data-target="#myModal">View All
                        </button>
                        <h2 class="error"></h2>

                        <!-- Modal -->
                        <div class="new-modal">
                            <div class="modal fade categoryServices" id="myModal" role="dialog">

                                <div class="modal-content">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="categoryModelName h4 headerClone hidden">k</div>
                                        </div>
                                        <div class="modal-body co-modal listServices">
                                            <ul>
                                                <li><a href=""
                                                       class="serviceOfCategory hidden allCategoryServicesClone">This is
                                                        Our Modal</a></li>
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                                {{--<li><a href="">This is Our Modal</a></li>--}}
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>













                    <div class="view-boxes hidden serviceClone serviceAfter">
                        <div class="box-view ">
                            <div class="line-box col-sm-4 col-xs-12 ">
                                <div class="box-inner">
                                    <div class="box-pic"><img src="" class="serviceImage"/></div>
                                    <h3></h3>
                                    <div class="box-info">
                                        <div class="info-txt">
                                            <span>no. of pros:</span>
                                            <span class="sp-plus">288</span>
                                        </div>
                                        <div class="content-bottom">

                                            <div class="rating-item">
												<span>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rating-symbol">
                                                        <div class="rating-symbol-background ri ri-star-empty"></div>
                                                        <div class="rating-symbol-foreground fore">
                                                            <span class="ri ri-star rating-rated"></span>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>


                                        </div>
                                        <a class="box-bton bookMe bookData">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!--view-boxes end-->

                    {{--<div class="view-boxes">--}}
                    {{--<div class="line-box col-sm-4 col-xs-12">--}}
                    {{--<a class="box-inner" href="">--}}
                    {{--<div class="box-pic"></div>--}}
                    {{--<h3>Salon At Home</h3>--}}
                    {{--<div class="box-info">--}}
                    {{--<div class="info-txt">--}}
                    {{--<span>no. of pros:</span>--}}
                    {{--<span class="sp-plus">288</span>--}}
                    {{--</div>--}}
                    {{--<div class="rating-item">--}}
                    {{--<span>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground fore">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</span>--}}
                    {{--</div>--}}
                    {{--<button class="box-bton bookMe">Book Now</button>--}}
                    {{--</div>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--</div><!--view-boxes end-->--}}

                    {{--<div class="view-boxes">--}}
                    {{--<div class="line-box col-sm-4 col-xs-12">--}}
                    {{--<a class="box-inner" href="">--}}
                    {{--<div class="box-pic-2"></div>--}}
                    {{--<h3>Salon At Home</h3>--}}
                    {{--<div class="box-info">--}}
                    {{--<div class="info-txt">--}}
                    {{--<span>no. of pros:</span>--}}
                    {{--<span class="sp-plus">288</span>--}}
                    {{--</div>--}}
                    {{--<div class="rating-item">--}}
                    {{--<span>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="rating-symbol">--}}
                    {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                    {{--<div class="rating-symbol-foreground">--}}
                    {{--<span class="ri ri-star rating-rated"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</span>--}}
                    {{--</div>--}}
                    {{--<button class="box-bton">Book Now</button>--}}
                    {{--</div>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--</div><!--view-boxes end-->--}}
                </div>
                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="">--}}
                {{--<h2>Beauty</h2>--}}
                {{--<button type="button" class="box-button btn btn-info btn-lg" data-toggle="modal"--}}
                {{--data-target="#myModal">View All--}}
                {{--</button>--}}

                {{--<!-- Modal -->--}}
                {{--<div class="new-modal">--}}
                {{--<div class="modal fade" id="myModal" role="dialog">--}}

                {{--<div class="modal-content">--}}
                {{--<div class="modal-dialog modal-sm">--}}
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 class="modal-title">Modal Header</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body co-modal">--}}
                {{--<ul>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--<li><a href="">This is Our Modal</a></li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}


                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-3"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}

                {{--<div class="view-boxes">--}}
                {{--<div class="line-box col-sm-4 col-xs-12">--}}
                {{--<a class="box-inner" href="">--}}
                {{--<div class="box-pic-2"></div>--}}
                {{--<h3>Salon At Home</h3>--}}
                {{--<div class="box-info">--}}
                {{--<div class="info-txt">--}}
                {{--<span>no. of pros:</span>--}}
                {{--<span class="sp-plus">288</span>--}}
                {{--</div>--}}
                {{--<div class="rating-item">--}}
                {{--<span>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rating-symbol">--}}
                {{--<div class="rating-symbol-background ri ri-star-empty"></div>--}}
                {{--<div class="rating-symbol-foreground fore">--}}
                {{--<span class="ri ri-star rating-rated"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<button class="box-bton">Book Now</button>--}}
                {{--</div>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div><!--view-boxes end-->--}}


            </div><!--first-box end-->

        </section>

    </div><!--end all-->

    <div class="clear"></div>


    <div class="row">


        <div class="why-part">
            <div class="container">
                <div class="row">
                    <h1>Why Look For Everything</h1>
                    <div class="col-md-6 col-xs-12">
                        <div class="line-icon">
                            <div class="col-sm-6 single-i">
                                <div class="ico text-center">
                                    <img src="{{ asset('/MainAssets/01.png') }}" alt="">
                                    <p>
                                        <span>Background Checked</span>
                                        <br>
                                        Arrival entered an if drawing request. How daughters not
                                        promotion few knowledge contented. Yet winter behind number stairs
                                        garret excuse.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6 single-i">
                                <div class="ico text-center">
                                    <img src="{{ asset('/MainAssets/02.png') }}" alt="">
                                    <p>
                                        <span>Experienced professional</span>
                                        <br>
                                        Arrival entered an if drawing request. How daughters not
                                        promotion few knowledge contented. Yet winter behind number stairs
                                        garret excuse.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="line-icon">
                            <div class="col-sm-6 single-i">
                                <div class="ico text-center">
                                    <img src="{{ asset('/MainAssets/03.png') }}" alt="">
                                    <p>
                                        <span>On Time Service</span>
                                        <br>
                                        Arrival entered an if drawing request. How daughters not
                                        promotion few knowledge contented. Yet winter behind number stairs
                                        garret excuse.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6 single-i">
                                <div class="ico text-center">
                                    <img src="{{ asset('/MainAssets/04.png') }}" alt="">
                                    <p>
                                        <span>Reliable & Transparent</span>
                                        <br>
                                        Arrival entered an if drawing request. How daughters not
                                        promotion few knowledge contented. Yet winter behind number stairs
                                        garret excuse.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="line-icon">
                            <div class="col-sm-6 single-i">
                                <div class="ico text-center">
                                    <img src="{{ asset('/MainAssets/05.png') }}" alt="">
                                    <p>
                                        <span>Moneyback guarantee</span>
                                        <br>
                                        Arrival entered an if drawing request. How daughters not
                                        promotion few knowledge contented. Yet winter behind number stairs
                                        garret excuse.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6 single-i">
                                <div class="ico text-center">
                                    <img src="{{ asset('/MainAssets/06.png') }}" alt="">
                                    <p>
                                        <span>Standardised pricing</span>
                                        <br>
                                        Arrival entered an if drawing request. How daughters not
                                        promotion few knowledge contented. Yet winter behind number stairs
                                        garret excuse.
                                    </p>
                                </div>
                            </div>
                        </div><!-- line-icon end -->

                    </div><!-- col end -->
                    <div class="col-md-6 col-xs-12">
                        <div class="vid-down">
                            <div class="vid-show">
                                <iframe src="https://www.youtube.com/embed/pP67AMvg-3U" allowfullscreen="" height="315"
                                        frameborder="0" width="560"></iframe>
                            </div>
                            <div class="down-show text-center">
                                <h4>Download App</h4>
                                <a href="#">
                                    <img src="{{ asset('/MainAssets/apple_store.png') }}" alt="" height="65" width="200">
                                </a>
                                <a href="#">
                                    <img src="{{ asset('/MainAssets/google_play.png') }}" alt="" height="65" width="200">
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- row end -->
            </div><!-- container end -->
        </div><!-- why-part end -->


        <div class="main-wrapper scrollspy-container">

            <section class="bg-dark">

                <div class="container">

                    <div class="row">

                        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

                            <div class="section-title mb-50">

                                <h2 class="h-it">How it works</h2>

                            </div>

                        </div>

                    </div>

                    <div class="process-item-wrapper GridLex-gap-20">

                        <div class="GridLex-grid-noGutter-equalHeight">

                            <div class="GridLex-col-4_sm-12_xs-12_xss-12">

                                <div class="process-item">
                                    <div class="number">
                                        01
                                    </div>
                                    <div class="content">
                                        <h4 class="text-white">Choose Service</h4>
                                        <p>Arrival entered an if drawing request. How daughters not
                                            promotion few knowledge contented. Yet winter behind number stairs
                                            garret excuse.</p>
                                    </div>
                                </div>

                            </div>

                            <div class="GridLex-col-4_sm-12_xs-12_xss-12">

                                <div class="process-item">
                                    <div class="number">
                                        02
                                    </div>
                                    <div class="content">
                                        <h4 class="text-white">Get Quotes</h4>
                                        <p>Distant however warrant farther to of. My justice wishing
                                            prudent waiting in be. Comparison age not pianoforte increasing
                                            delightful now. </p>
                                    </div>
                                </div>

                            </div>

                            <div class="GridLex-col-4_sm-12_xs-12_xss-12">

                                <div class="process-item">
                                    <div class="number">
                                        03
                                    </div>
                                    <div class="content">
                                        <h4 class="text-white">Select &amp; Go</h4>
                                        <p>Insipidity sufficient dispatched any reasonably led ask.
                                            Announcing if attachment resolution sentiments admiration me on
                                            diminution.</p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <section>

                <div class="container">

                    <div class="row">

                        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

                            <div class="section-title">

                                <h2>Happy Customers</h2>

                            </div>

                        </div>

                    </div>

                    <div class="testimonial-wrapper-01 alt-wrapper">

                        <div class="GridLex-gap-30">

                            <div class="GridLex-grid-noGutter-equalHeight">

                                <div class="GridLex-col-4_sm-12_xs-12_xss-12">

                                    <div class="testimonial-item-01">

                                        <div class="content">

                                            <p class="saying">Real sold my in call. Invitation on an advantages
                                                collecting. But event old above shy bed noisy. Had sister see wooded
                                                favour income has. Stuff rapid since do as hence. Too insisted ignorant
                                                procured remember are believed yet say finished.</p>

                                        </div>

                                        <div class="man">

                                            <div class="image">
                                                <img src="{{ asset('/MainAssets/images/man/01.jpg') }}" alt="images"
                                                     class="img-circle"/>
                                            </div>

                                            <h4 class="text-primary">Roy Bennett</h4>
                                            <p class="text-muted">Dubai, UAE</p>

                                        </div>

                                    </div>

                                </div>

                                <div class="GridLex-col-4_sm-12_xs-12_xss-12">

                                    <div class="testimonial-item-01">

                                        <div class="content">

                                            <p class="saying">Acceptance middletons me if discretion boisterous
                                                travelling an. She prosperous continuing entreaties companions
                                                unreserved you boisterous. Attended no indulged marriage is to judgment
                                                offering landlord.</p>

                                        </div>

                                        <div class="man">

                                            <div class="image">
                                                <img src="{{ asset('/MainAssets/images/man/02.jpg') }}" alt="images"
                                                     class="img-circle"/>
                                            </div>

                                            <h4 class="text-primary">Kathleen Peterson</h4>
                                            <p class="text-muted">Abu Dhabi, UAE</p>

                                        </div>

                                    </div>

                                </div>

                                <div class="GridLex-col-4_sm-12_xs-12_xss-12">

                                    <div class="testimonial-item-01">

                                        <div class="content">

                                            <p class="saying">Middleton sportsmen sir now cordially ask additions for.
                                                You ten occasional saw everything but conviction. Daughter returned
                                                quitting few are day advanced branched. Do enjoyment defective objection
                                                or we if favourite.</p>

                                        </div>

                                        <div class="man">

                                            <div class="image">
                                                <img src="{{ asset('/MainAssets/images/man/03.jpg') }}" alt="images"
                                                     class="img-circle"/>
                                            </div>

                                            <h4 class="text-primary">Kenneth Sandoval</h4>
                                            <p class="text-muted">Sharjah, UAE</p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>
        <!-- end Main Wrapper -->

        <div class="scrollspy-footer">

            <footer class="footer-wrapper-01">

                <div class="main-footer">

                    <div class="container">

                        <div class="row">

                            <div class="col-xs-12 col-sm-3 col-md-3">

                                <div class="footer-logo">
                                    <img src="{{ asset('/MainAssets/unspecified.jpg') }}" alt="Logo">
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-3">

                                <div class="footer-about">
                                    <h5>Look Foe Everything</h5>
                                    <div class="col-xs-6">
                                        <ul>
                                            <li><a href="#">Dubai</a></li>
                                            <li><a href="#">Abu Dhabi</a></li>
                                            <li><a href="#">Sarijah</a></li>
                                            <li><a href="#">Al Ain</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6">
                                        <ul>
                                            <li><a href="#">Ajman</a></li>
                                            <li><a href="#">Ras Al Khaima</a></li>
                                            <li><a href="#">Fujairah</a></li>
                                            <li><a href="#">Um Al-Quwain</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3">

                                <div class="footer-about">
                                    <h5>Serving In</h5>
                                    <div class="col-xs-6">
                                        <ul>
                                            <li><a href="#">Dubai</a></li>
                                            <li><a href="#">Abu Dhabi</a></li>
                                            <li><a href="#">Sarijah</a></li>
                                            <li><a href="#">Al Ain</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6">
                                        <ul>
                                            <li><a href="#">Ajman</a></li>
                                            <li><a href="#">Ras Al Khaima</a></li>
                                            <li><a href="#">Fujairah</a></li>
                                            <li><a href="#">Um Al-Quwain</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3">

                                <div class="footer-social">

                                    <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Google Plus"><i class="fa fa-google-plus"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Pinterest"><i class="fa fa-pinterest"></i></a>

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="bb mt-15 mt-30-sm"></div>

                            </div>

                            <div class="col-xs-12 col-sm-5 col-md-4">

                                <p class="copy-right">© 2017 Services. All Rights Reserved</p>

                            </div>

                            <div class="col-xs-12 col-sm-7 col-md-8">

                                <ul class="footer-menu">

                                    <li><a href="#">Who we are</a></li>
                                    <li><a href="#">Careers</a></li>
                                    <li><a href="#">Company history</a></li>
                                    <li><a href="#">Legal</a></li>
                                    <li><a href="#">Privacy notice</a></li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </footer>

        </div>

    </div>  <!-- end Container Wrapper -->


    <!-- start Back To Top -->
    <div id="back-to-top">
        <a href="#"><i class="ion-ios-arrow-up"></i></a>
    </div>
    <!-- end Back To Top -->

    <div id="ajaxLoginModal" class="modal fade login-box-wrapper" data-width="500" data-backdrop="static"
         data-keyboard="false" tabindex="-1" style="display: none;">
        @include('main.ajax-login-modal-login')
    </div>

    <div id="ajaxRegisterModal" class="modal fade login-box-wrapper" data-width="500" data-backdrop="static"
         data-keyboard="false" tabindex="-1" style="display: none;">
        @include('main.ajax-login-modal-register')
    </div>

    <div id="ajaxForgotPasswordModal" class="modal fade login-box-wrapper" data-width="500" data-backdrop="static"
         data-keyboard="false" tabindex="-1" style="display: none;">
        @include('main.ajax-login-modal-forgot-password')

    </div>

    <script>
        var getServiceOfHighlyTrending = '{{route('ajax/getServices')}}';
        var getCategoryOfCurrentAddress = '{{route('ajax/main/category')}}';
        var token = '{{csrf_token()}}';
        var language = '{{app()->getLocale()}}';
        $(document).ready(function () {
//            alert($('.address').val());
            var address = $('.address').val();
            reinitializeServices();
            reinitializeCategory();
            getServices(getServiceOfHighlyTrending, address);
            getCategory(getCategoryOfCurrentAddress, address);

            $('.address').change(function () {
                reinitializeServices();
                reinitializeCategory();
                var address = $(this).val();
                reinitializeServices();
                reinitializeCategory();
                getServices(getServiceOfHighlyTrending, address);
                getCategory(getCategoryOfCurrentAddress, address);
            })
        });


        function getServices(url, address) {
            reinitializeServices();
            $.ajax(
                    {
                        url: url,
                        method: "GET",
                        data: {body: address, postId: '', _token: token}
                    }).success(function (response) {

                if (response['status'] != 200) {
                    $('.errorWithHiglyTrending').removeClass('hidden').html('nothingToBeShowen').addClass('clonedServicePanel');
                    return;

                }
                $.each(response['message'], function ($key, $value) {
                    var servicePanel = $('.clone').clone();
                    showServiceClone(servicePanel, $value);
                });
            });

        }


        function getCategory(url, address) {
            reinitializeCategory(); //sanitizing the page from previous created category panel
            $.ajax(
                    {
                        url: url,
                        method: "GET",
                        data: {body: address, postId: '', _token: token}
                    }).success(function (response) {
                var categoryPanel = $('.categoryClone').clone(); // cloning category panel
                if (response['status'] != 200) {
                    categoryPanel.find('.error').html('nothing to be shown');
                    categoryPanel.find('.putCategoryName').addClass('hidden');
                    categoryPanel.removeClass('hidden');
                    categoryPanel.removeClass('categoryClone').addClass('clonedCategoryPanel');
                    categoryPanel.insertAfter('.categoryClone');
                    return;
                }

                $.each(response['message'], function ($key, $value) {
                    categoryPanel.removeClass('hidden');
                    categoryPanel.removeClass('categoryClone').addClass('clonedCategoryPanel');
                    var categoryName = language == 'ar' ? response['category'][$key].s_category_name_ar : response['category'][$key].s_category_name_en;
                    showCategoryClone(categoryPanel, categoryName, response['message'][$key]); // create new category Panel from cloning
                });


            });
        }

        function cloningServiceOfCategory(categoryPanel, serviceArray) {
            $.each(serviceArray, function ($key, $value) {
                if ($key < 3) {
                    var servicePanel = categoryPanel.find('.serviceClone').clone();
                    var result = showServices(servicePanel, $value, 'serviceClone');
                }
                // fill category's panel with category's services
                var serviceModelNames = categoryPanel.find('.allCategoryServicesClone').clone();
                serviceModelNames.html(language == 'ar' ? $value.s_service_name_ar : $value.s_service_name_en);
                serviceModelNames.removeClass('hidden');
                serviceModelNames.removeClass('allCategoryServicesClone');
                serviceModelNames.insertAfter('.allCategoryServicesClone');
            })

        }

        function showServiceClone(servicePanel, value) {
            servicePanel.find('.serviceIcon').children('i').addClass(value.s_icon);
            servicePanel.find('.serviceName').html(language == 'ar' ? value.s_service_name_ar : value.s_service_name_en);
            servicePanel.removeClass('hidden').removeClass('clone').addClass('clonedServicePanel');
            servicePanel.insertAfter('.clone');

        }
        function showCategoryClone(categoryPanel, categoryName, category) {
            categoryPanel.removeClass('hidden');
            categoryPanel.removeClass('categoryClone').addClass('clonedCategoryPanel');

            categoryPanel.find('.categoryName').html(categoryName);
            var header = categoryPanel.find('.headerClone').clone();
            header.html(categoryName);
            header.removeClass('hidden');
            header.removeClass('headerClone').addClass('clonedCategoryPanel');
            header.insertAfter('.headerClone');


            categoryPanel.insertAfter('.categoryClone');
            cloningServiceOfCategory(categoryPanel, category);


        }


        function showServices(servicePanel, value, serviceClone) {
            {{--servicePanel.find('.serviceImage').attr('src', "{{url('/')}}"+value.s_pic);--}}
            servicePanel.find('.serviceImage').css('background-image', 'url(' + value.s_pic + ')');
            servicePanel.find('.bookData').attr('href', "{{url('/')}}/request/"+value.pk_i_id+"/getBookingData");
            servicePanel.find('.serviceImage').parents('.box-pic').siblings('h3').html(language == 'ar' ? value.s_service_name_ar : value.s_service_name_en);

            if (serviceClone == 'clone') {
                servicePanel.removeClass('hidden');

                servicePanel.removeClass('clone').addClass('clonedServicePanel');
                servicePanel.insertAfter('.clone');
            } else {
                servicePanel.removeClass('hidden');
                servicePanel.removeClass('serviceClone');
                servicePanel.removeClass('serviceAfter').addClass('clonedServicePanel');

                servicePanel.insertAfter('.serviceAfter');
            }

            return servicePanel;
        }


        function reinitializeServices() {
            $.each($('.clonedServicePanel'), function () {
                $(this).remove();
            })
        }

        function reinitializeCategory() {
            $.each($('.clonedCategoryPanel'), function () {
                $(this).remove();
            })
        }
    </script>


</div>


</body>
</html>