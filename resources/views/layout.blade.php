@php
    if (Session::get('lang') !== 'vi') {
        Session::put('lang', 'vi');
    }
@endphp
﻿<!DOCTYPE html>
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
<body class="theme-modern {{ request()->is('login-checkout') ? 'page-auth' : '' }} {{ request()->is('show-cart') ? 'page-cart' : '' }} {{ request()->is('checkout') || request()->is('payment') ? 'page-checkout' : '' }} {{ request()->is('tin-tuc*') ? 'page-news' : '' }} {{ request()->is('contact-us.html') ? 'page-contact' : '' }} {{ request()->is('shop.html') ? 'page-shop' : '' }} {{ request()->is('chi-tiet-san-pham*') ? 'page-product-detail' : '' }}">

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
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{URL::to('/trang-chu')}}"><img src="{{asset('frontend/images/home/logo.png')}}" alt="E-Shopper" /></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{URL::to('/wishlist')}}"><i class="fa fa-star"></i> {{ __('ui.header.wishlist') }} ({{count(Session::get('wishlist', []))}})</a></li>
                            <?php
                               $customer_id = Session::get('customer_id');
                               if($customer_id!=NULL){
                             ?>
                              <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> {{ __('ui.header.checkout') }}</a></li>
                            <?php
                            }else{
                            ?>
                             <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> {{ __('ui.header.checkout') }}</a></li>
                            <?php
                             }
                            ?>
                            <?php $cart_count = Cart::count(); ?>
                            <li>
                                <a href="{{URL::to('/show-cart')}}" class="cart-link">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="cart-text">{{ __('ui.header.cart') }}</span>
                                    <span class="cart-badge" data-count="{{ $cart_count }}">{{ $cart_count }}</span>
                                </a>
                            </li>
                            <?php
                               $customer_id = Session::get('customer_id');
                               $admin_id = Session::get('admin_id');
                               if($admin_id!=NULL){
                             ?>
                              <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
                              <li><a href="{{URL::to('/logout')}}"><i class="fa fa-lock"></i> {{ __('ui.header.logout') }}</a></li>
                            <?php
                            }elseif($customer_id!=NULL){
                             ?>
                              <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> {{ __('ui.header.logout') }}</a></li>
                            <?php
                            }else{
                             ?>
                             <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> {{ __('ui.header.login') }}</a></li>
                             <?php
                         }
                             ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{URL::to('/trang-chu')}}" class="active">{{ __('ui.nav.home') }}</a></li>
                            <li><a href="{{URL::to('/shop.html')}}">{{ __('ui.nav.products') }}</a></li>
                            <li><a href="{{URL::to('/tin-tuc')}}">{{ __('ui.nav.news') }}</a></li>
                            <li><a href="{{URL::to('/show-cart')}}">{{ __('ui.nav.cart') }}</a></li>
                            <li><a href="{{URL::to('/contact-us.html')}}">{{ __('ui.nav.contact') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-5">
                    <form action="{{URL::to('/tim-kiem')}}" method="POST">
                        {{csrf_field()}}
                        <div class="search_box pull-right">
                            <input type="text" name="keywords_submit" placeholder="{{ __('ui.nav.search_placeholder') }}"/>
                            <input type="submit" name="search_items" class="btn btn-primary btn-sm" value="{{ __('ui.nav.search') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

@hasSection('hero')
    <section class="hero">
        <div class="container">
            @yield('hero')
        </div>
    </section>
    @endif

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>{{ __('ui.sidebar.categories') }}</h2>
                    <div class="panel-group category-products" id="accordian">
                      @foreach($category as $key => $cate)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="{{URL::to('/danh-muc-san-pham/'.$cate->slug_category_product)}}">
                                        <span class="category-name">{{$cate->category_name}}</span>
                                        @if(isset($cate->product_count))
                                            <span class="category-count">{{$cate->product_count}}</span>
                                        @endif
                                    </a>
                                </h4>
                            </div>
                        </div>
                      @endforeach
                    </div>

                    <div class="brands_products">
                        <h2>{{ __('ui.sidebar.brands') }}</h2>
                        @php
                            $brandCounts = \DB::table('tbl_product')
                                ->select('brand_id', \DB::raw('count(*) as total'))
                                ->groupBy('brand_id')
                                ->pluck('total','brand_id');
                        @endphp
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($brand as $key => $brand)
                                <li>
                                    <a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_slug)}}">
                                        <span class="pull-right">({{ $brandCounts[$brand->brand_id] ?? 0 }})</span>
                                        {{$brand->brand_name}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                @yield('content')
            </div>
        </div>
    </div>
</section>

<footer id="footer" class="site-footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="companyinfo">
                        <h2><span>e</span>-shopper</h2>
                        <p>{{ __('ui.footer.about_text') }}</p>
                        <ul class="nav nav-pills nav-stacked footer-contact">
                            <li><i class="fa fa-phone"></i> +84 28 555 0100</li>
                            <li><i class="fa fa-envelope"></i> hello@eshopper.test</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="footer-grid">
                        <div class="footer-card">
                            <h2>{{ __('ui.footer.support') }}</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">{{ __('ui.footer.help_center') }}</a></li>
                                <li><a href="{{URL::to('/contact-us.html')}}">{{ __('ui.nav.contact') }}</a></li>
                                <li><a href="#">{{ __('ui.footer.order_status') }}</a></li>
                                <li><a href="#">{{ __('ui.footer.returns') }}</a></li>
                            </ul>
                        </div>
                        <div class="footer-card">
                            <h2>{{ __('ui.footer.store') }}</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="{{URL::to('/shop.html')}}">{{ __('ui.footer.all_products') }}</a></li>
                                <li><a href="{{URL::to('/tin-tuc')}}">{{ __('ui.nav.news') }}</a></li>
                                <li><a href="{{URL::to('/show-cart')}}">{{ __('ui.nav.cart') }}</a></li>
                                <li><a href="{{URL::to('/login-checkout')}}">{{ __('ui.footer.account') }}</a></li>
                            </ul>
                        </div>
                        <div class="footer-card">
                            <h2>{{ __('ui.footer.company') }}</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">{{ __('ui.footer.about') }}</a></li>
                                <li><a href="#">{{ __('ui.footer.careers') }}</a></li>
                                <li><a href="#">{{ __('ui.footer.stores') }}</a></li>
                                <li><a href="#">{{ __('ui.footer.policies') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="single-widget">
                        <h2>{{ __('ui.footer.updates') }}</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="{{ __('ui.footer.newsletter_placeholder') }}" />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <p>{{ __('ui.footer.newsletter_text') }}</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">{{ __('ui.footer.copyright') }}</p>
                <p class="pull-right">{{ __('ui.footer.tagline') }}</p>
            </div>
        </div>
    </div>
</footer>

<script src="{{asset('frontend/js/jquery.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('frontend/js/price-range.js')}}"></script>
<script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('frontend/js/main.js')}}"></script>
<script src="{{asset('frontend/js/cart-fly.js')}}"></script>
<script src="{{asset('frontend/js/cart-qty.js')}}"></script>
</body>
</html>





