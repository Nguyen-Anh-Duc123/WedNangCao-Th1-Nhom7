<!DOCTYPE html>
<html lang="{{ Session::get('lang', 'vi') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ __('ui.site.title') }}</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="{{asset('frontend/css/modern.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{('frontend/images/favicon.ico')}}">
</head>
<body class="theme-modern page-auth">
<header id="header" class="site-header">
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="header-preferences">
                        <form action="{{URL::to('/preferences')}}" method="POST" class="preference-form">
                            {{csrf_field()}}
                            <select name="currency" onchange="this.form.submit()">
                                <option value="VND" {{ Session::get('currency', 'VND') === 'VND' ? 'selected' : '' }}>VND</option>
                                <option value="USD" {{ Session::get('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                            </select>
                            <button type="submit" name="lang" value="vi" class="flag-button {{ Session::get('lang', 'vi') === 'vi' ? 'is-active' : '' }}" aria-label="{{ __('ui.lang.vi') }}">
                                <img src="{{asset('frontend/images/flags/vn.svg')}}" alt="VN">
                            </button>
                            <button type="submit" name="lang" value="en" class="flag-button {{ Session::get('lang') === 'en' ? 'is-active' : '' }}" aria-label="{{ __('ui.lang.en') }}">
                                <img src="{{asset('frontend/images/flags/us.svg')}}" alt="EN">
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo pull-left">
                        <a href="{{URL::to('/trang-chu')}}"><img src="{{('frontend/images/home/logo.png')}}" alt="E-Shopper" /></a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{URL::to('/trang-chu')}}"><i class="fa fa-home"></i> {{ __('ui.nav.home') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="auth-page">
    @yield('content')
</main>

<script src="{{asset('frontend/js/jquery.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('frontend/js/price-range.js')}}"></script>
<script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('frontend/js/main.js')}}"></script>
</body>
</html>
