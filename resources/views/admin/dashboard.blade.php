@extends('admin_layout')
@section('admin_content')
<div class="dashboard-overview">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default stat-card">
                <div class="panel-body">
                    <div class="stat-label">Doanh thu trong tháng</div>
                    <div class="stat-value">{{ number_format($monthly_revenue, 0, ',', '.') }} VND</div>
                    <div class="stat-sub">Tính khi đơn đã giao & đã thanh toán</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default stat-card">
                <div class="panel-body">
                    <div class="stat-label">Tổng người dùng</div>
                    <div class="stat-value">{{ number_format($total_users) }}</div>
                    <div class="stat-sub">Tất cả khách hàng đã đăng ký</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default stat-card">
                <div class="panel-body">
                    <div class="stat-label">Đơn hàng trong tháng</div>
                    <div class="stat-value">{{ number_format($monthly_orders) }}</div>
                    <div class="stat-sub">Số đơn tạo trong tháng</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default stat-card">
                <div class="panel-body">
                    <div class="stat-label">Tổng thương hiệu</div>
                    <div class="stat-value">{{ number_format($brand_count) }}</div>
                    <div class="stat-sub">Số thương hiệu trong hệ thống</div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default chart-card">
        <div class="panel-heading">Thống kê doanh thu &amp; đơn hàng (6 tháng gần nhất)</div>
        <div class="panel-body">
            <div id="orders-revenue-chart" class="chart-canvas"></div>
            <p class="chart-note">Doanh thu chỉ tính khi đơn đã giao và đã thanh toán. Hiển thị theo đơn vị triệu VND.</p>
        </div>
    </div>
</div>

<script>
    window.dashboardChartData = {!! json_encode($chart_data, JSON_UNESCAPED_UNICODE) !!};
</script>
@endsection
