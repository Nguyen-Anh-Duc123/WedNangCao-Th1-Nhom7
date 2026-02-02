<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>
    <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet">
</head>
<body>
    <div class="w3layouts-main">
        <h2>Đăng nhập quản trị</h2>
        <?php
        $message = Session::get('message');
        if($message){
            echo '<p style="color:#b91c1c;font-weight:600;">'.$message.'</p>';
            Session::put('message', null);
        }
        ?>
        <form action="{{URL::to('/admin-dashboard')}}" method="POST">
            {{ csrf_field() }}
            <input type="email" class="ggg" name="admin_email" placeholder="Email" required>
            <input type="password" class="ggg" name="admin_password" placeholder="Mật khẩu" required>
            <h4><input type="checkbox" value="remember-me">Ghi nhớ đăng nhập</h4>
            <h6><a href="#">Quên mật khẩu?</a></h6>
            <div class="clearfix"></div>
            <input type="submit" value="Đăng nhập" name="login">
        </form>
        <div style="margin-top:12px;">
            <a href="{{URL::to('/dashboard')}}" class="btn btn-default btn-sm">Bảng điều khiển</a>
            <a href="{{URL::to('/logout')}}" class="btn btn-default btn-sm">Đăng xuất</a>
        </div>
    </div>
</body>
</html>
