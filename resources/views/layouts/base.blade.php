
<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head>
    <meta name="google-site-verification" content=""/>
        <title>{{$settings->site_name}}</title>
    <meta name="description" content="{{$settings->site_name}} | We are here to serve you better and help save your money without charges.." />
    <meta property="og:locale" content="en_EN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$settings->site_name}} - We are here to serve you better and help save your money without charges.." />
            <meta property="og:description" content="{{$settings->site_name}} | We are here to serve you better and help save your money without charges" />
        <meta property="og:image" content="{{ asset('storage/app/public/'.$settings->favicon)}}" />
        <meta property="og:url" content="{{$settings->site_address}}" />
    <meta property="og:site_name" content="{{$settings->site_name}}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Welcome to a new era of banking at {{$settings->site_name}}, where traditional boundaries fade away and possibilities expand.." />
    <meta name="twitter:title" content="{{$settings->site_name}} - We are here to serve you better and help save your money without charges.." />
    <meta name="twitter:image" content="{{ asset('storage/app/public/'.$settings->favicon)}}" />

    <!--favicon icon-->
    <link rel="icon" href="{{ asset('storage/app/public/'.$settings->favicon)}}" type="image/png" sizes="16x16">

    <!--google fonts-->
    <link href="fonts.googleapis.co/css164416441644.html?family=Montserrat:400,500,600,700%7COpen+Sans:400,600&amp;display=swap" rel="stylesheet">

    <!--Bootstrap css-->
    <link rel="stylesheet" href="temp/custom/base/css/bootstrap.min.css">
    <!--Magnific popup css-->
    <link rel="stylesheet" href="temp/custom/base/css/magnific-popup.css">
    <!--Themify icon css-->
    <link rel="stylesheet" href="temp/custom/base/css/themify-icons.css">
    <!--Fontawesome icon css-->
    <link rel="stylesheet" href="temp/custom/base/css/all.min.css">
    <!--animated css-->
    <link rel="stylesheet" href="temp/custom/base/css/animate.min.css">
    <!--ytplayer css-->
    <link rel="stylesheet" href="temp/custom/base/css/jquery.mb.YTPlayer.min.css">
    <!--Owl carousel css-->
    <link rel="stylesheet" href="temp/custom/base/css/owl.carousel.min.css">
    <link rel="stylesheet" href="temp/custom/base/css/owl.theme.default.min.css">
    <!--custom css-->
    <link rel="stylesheet" href="temp/custom/base/css/style.css">
    <!--responsive css-->
    <link rel="stylesheet" href="temp/custom/base/css/responsive.css">

    <link rel="stylesheet" href="base/cdnjs.cloudflare.co/ajax/libs/normalize/5.0.0/normalize.min.html">
    <link rel='stylesheet' href='fonts.googleapis.co/icone91fe91fe91f.html?family=Material+Icons'>
    <link rel="stylesheet" href="temp/custom/base/css/customstyle.css">
    <style>
        .info {
            color: rgba(2, 2, 211, 0.753);
        }
        .success {
            color: rgba(5, 187, 5, 0.801);
        }
        .error {
            color: rgba(255, 0, 0, 0.801);
        }
    </style></head>

    <div class="loader1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<header class="header">
    <!--start navbar-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('storage/app/public/'.$settings->logo)}}" style="height: 60px; width: 150px;" alt="{{$settings->site_name}}" class="img-fluid"/>
            </a>






            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse h-auto" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto menu">

                    <li><a  href="/">Home</a></li>
                    <li><a  href="about">About Us</a></li>
                    <li><a href="services"> Services</a></li>
                    <li><a href="faq">FAQs</a></li>
                    <li><a href="contact">Get Support</a></li>
                    <li><a style="opacity: 1;" href="" class="btn btn-sm btn-primary p-2 mb-2">Open Account</a></li>
                    <li><a style="opacity: 1;" href="{{route('login')}}" class="btn outline-white-btn p-2 text-white">Online Banking</a></li>

                </ul>
            </div>
        </div>
    </nav>
</header>




@yield('content')

<footer class="footer-section">
    <!--footer top start-->
    <div class="footer-top gradient-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row footer-top-wrap">
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">QUICK LINKS</h4>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('register')}}">Open Account</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href=" {{route('login')}}">Online Banking</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">COMPANY</h4>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="about">About Us</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="about">Our Services</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="faq">FAQs</a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">LEGAL</h4>
                                <ul class="nav flex-column">
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0);">Legal Information</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="privacy-policy">Privacy Policy</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="contact">Report Abuse</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="terms">Terms of Service</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">SUPPORT</h4>
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact">Contact</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="faq">FAQs</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row footer-top-wrap">
                        <div class="col-12">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">GET IN TOUCH</h4>
                                <ul class="get-in-touch-list">
                                    <li class="d-flex align-items-center py-2"><span class="fas fa-map-marker-alt mr-2"></span> {{$settings->address}} </li>
                                    <li class="d-flex align-items-center py-2"><span class="fas fa-envelope mr-2"></span> <a href="cdn-cgi/l/email-protection-2.html" class="__cf_email__" data-cfemail="3e6d4b4e4e514c4a7e595b535750575952515c5f525857505f505d5b105d51">[email&#160;protected]</a></a></li>
                                   <li class="d-flex align-items-center py-2"><i class="fas fa-comments"></i>&nbsp;&nbsp;<a href='#'> {{$settings->contact_email}} </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer top end-->

    <!--footer copyright start-->
    <div class="footer-bottom py-4" style="background: black;">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-5 col-lg-5">
                    <p class="copyright-text pb-0 mb-0">Copyrights © 2023. All
                        rights reserved
                        <a href="/" target="_blank" class='text-white'>{{$settings->site_name}}</a></p>
                </div>
                <div class="col-md-7 col-lg-6 d-none d-md-block d-lg-block">
                    <div class="social-nav text-right">
                        <ul class="list-unstyled social-list mb-0">
                            <li class="list-inline-item tooltip-hover">
                                <a href="https://facebook.com/" target="_blank" class="rounded text-white"><span class="ti-facebook"></span></a>
                                <div class="tooltip-item">Facebook</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="https://twitter.com/" target="_blank" class="rounded text-white"><span class="ti-twitter"></span></a>
                                <div class="tooltip-item">Twitter</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="http://linkedin.com/" target="_blank" class="rounded text-white"><span class="ti-linkedin"></span></a>
                                <div class="tooltip-item">Linkedin</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="https://instagram.com/" target="_blank" class="rounded text-white"><span class="ti-instagram"></span></a>
                                <div class="tooltip-item">Instagram</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer copyright end-->
</footer>
<!--footer section end-->

<!--bottom to top button start-->
<button class="scroll-top scroll-to-target" data-target="html">
    <span class="ti-angle-up"></span>
</button>

<div class="telegram-popup" align="center">

        </div>



        @include('layouts.lang')

<!--jQuery-->
<script data-cfasync="false" src="https://cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="temp/custom/base/js/jquery-3.4.1.min.js"></script>
<!--Popper js-->
<script src="temp/custom/base/js/popper.min.js"></script>
<!--Bootstrap js-->
<script src="temp/custom/base/js/bootstrap.min.js"></script>
<!--Magnific popup js-->
<script src="temp/custom/base/js/jquery.magnific-popup.min.js"></script>
<!--jquery easing js-->
<script src="temp/custom/base/js/jquery.easing.min.js"></script>
<!--jquery ytplayer js-->
<script src="temp/custom/base/js/jquery.mb.YTPlayer.min.js"></script>
<!--Isotope filter js-->
<script src="temp/custom/base/js/mixitup.min.js"></script>
<!--wow js-->
<script src="temp/custom/base/js/wow.min.js"></script>
<!--owl carousel js-->
<script src="temp/custom/base/js/owl.carousel.min.js"></script>
<!--countdown js-->
<script src="temp/custom/base/js/jquery.countdown.min.js"></script>
<!--custom js-->
<script src="temp/custom/base/js/all.min.js"></script>
<!--custom js-->
<script src="temp/custom/base/js/scripts.js"></script>
<!-- inpage script -->
<script>
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if(h === 0){
        h = 12;
    }

    if(h > 12){
        h = h - 12;
        session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;

    setTimeout(showTime, 1000);

}

showTime();
</script>


<script>
    $(document).ready(function(){
        $(".telegram-popup").delay(3000).show(0);
    });
</script>

<script>
    if (window.history.replaceState){
    window.history.replaceState(null, null, window.location.href);
    }
    // ensure to add onunload='' to the body tag and autocomplete="off" on form tags
</script>

<!-- Script for getting user timezone -->
<script>
    // Timezone settings
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone; // e.g. "America/New_York"
    document.getElementById('location').value = timezone;
    console.log(document.getElementById('location').value);
</script>


@include('layouts.livechat')
@if($settings->tido)
    <script src="//code.tidio.co/{{$settings->tido}}" async></script>
    @endif

</body>



</html>
