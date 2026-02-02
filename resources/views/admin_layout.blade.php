<!DOCTYPE html>
<head>
<title>Bảng điều khiển quản trị</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template" />
<script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
    function hideURLbar(){ window.scrollTo(0,1); }
</script>
<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" >
<link href="{{asset('backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet"/>
<link href="{{asset('backend/css/admin-tweaks.css')}}" rel="stylesheet"/>
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="{{asset('backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css"/>
<link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
<script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('backend/js/raphael-min.js')}}"></script>
<script src="{{asset('backend/js/morris.js')}}"></script>
</head>
<body>
<section id="container">
<header class="header fixed-top clearfix">
<div class="brand">
    <a href="index.html" class="logo">
        QUẢN TRỊ
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>

<div class="top-nav clearfix">
    <ul class="nav pull-right top-menu">
        <li>
             <form class="navbar-form" role="search">
            <input type="text" class="form-control search" placeholder="Tìm kiếm">
             </form>
        </li>
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{('backend/images/2.png')}}">
                <span class="username">
                    <?php
                    $name = Session::get('admin_name');
                    if($name){
                        echo $name;
                    }
                    ?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class="fa fa-suitcase"></i>Tài khoản</a></li>
                <li><a href="#"><i class="fa fa-cog"></i>Cài đặt</a></li>
                <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
            </ul>
        </li>
    </ul>
</div>
</header>

<aside>
    <div id="sidebar" class="nav-collapse">
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                 <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý đơn hàng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/manage-order')}}">Danh sách đơn hàng</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý danh mục</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục</a></li>
                        <li><a href="{{URL::to('/all-category-product')}}">Danh sách danh mục</a></li>
                    </ul>
                </li>
                 <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý thương hiệu</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-brand-product')}}">Thêm thương hiệu</a></li>
                        <li><a href="{{URL::to('/all-brand-product')}}">Danh sách thương hiệu</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý sản phẩm</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
                        <li><a href="{{URL::to('/all-product')}}">Danh sách sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-newspaper-o"></i>
                        <span>Quản lý tin tức</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-news')}}">Thêm tin tức</a></li>
                        <li><a href="{{URL::to('/all-news')}}">Danh sách tin tức</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</aside>

<section id="main-content">
    <section class="wrapper">
        @yield('admin_content')
    </section>
</section>
</section>
<script src="{{asset('backend/js/bootstrap.js')}}"></script>
<script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('backend/js/scripts.js')}}"></script>
<script src="{{asset('backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('backend/js/jquery.scrollTo.js')}}"></script>
<script>
    $(document).ready(function() {
        jQuery('.small-graph-box').hover(function() {
            jQuery(this).find('.box-button').fadeIn('fast');
        }, function() {
            jQuery(this).find('.box-button').fadeOut('fast');
        });
        jQuery('.small-graph-box .box-close').click(function() {
            jQuery(this).closest('.small-graph-box').fadeOut(200);
            return false;
        });

        if (window.dashboardChartData && document.getElementById('orders-revenue-chart')) {
            Morris.Area({
                element: 'orders-revenue-chart',
                padding: 10,
                behaveLikeLine: true,
                gridEnabled: false,
                gridLineColor: '#e2e8f0',
                axes: true,
                resize: true,
                smooth: true,
                pointSize: 3,
                lineWidth: 2,
                fillOpacity: 0.2,
                data: window.dashboardChartData,
                lineColors: ['#f97316', '#2563eb'],
                xkey: 'period',
                redraw: true,
                ykeys: ['revenue', 'orders'],
                labels: ['Doanh thu (triệu VND)', 'Đơn hàng'],
                hideHover: 'auto',
                parseTime: true,
                xLabels: 'month',
                xLabelAngle: 0,
                dateFormat: function (x) {
                    var d = new Date(x);
                    var month = String(d.getMonth() + 1).padStart(2, '0');
                    return month + '/' + d.getFullYear();
                },
                xLabelFormat: function (x) {
                    var month = String(x.getMonth() + 1).padStart(2, '0');
                    return month + '/' + x.getFullYear();
                }
            });
        }
    });
</script>
<script type="text/javascript" src="{{asset('backend/js/monthly.js')}}"></script>
<script type="text/javascript">
    $(window).load( function() {
        if ($('#mycalendar').length) {
            $('#mycalendar').monthly({
                mode: 'event',
            });
        }
        if ($('#mycalendar2').length) {
            $('#mycalendar2').monthly({
                mode: 'picker',
                target: '#mytarget',
                setWidth: '250px',
                startHidden: true,
                showTrigger: '#mytarget',
                stylePast: true,
                disablePast: true
            });
        }

        switch(window.location.protocol) {
        case 'http:':
        case 'https:':
        break;
        case 'file:':
        alert('Just a heads-up, events will not work when run locally.');
        }
    });
</script>
</body>
</html>
