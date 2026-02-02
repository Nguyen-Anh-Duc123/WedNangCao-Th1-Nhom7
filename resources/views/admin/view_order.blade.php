@extends('admin_layout')
@section('admin_content')
@php
  $status_map = [
    0 => 'Đang xử lý',
    1 => 'Đang giao hàng',
    2 => 'Đã giao',
    3 => 'Đã hủy',
    'Dang xu ly' => 'Đang xử lý',
    'Dang giao hang' => 'Đang giao hàng',
    'Da giao' => 'Đã giao',
    'Da huy' => 'Đã hủy',
    'Đang xử lý' => 'Đang xử lý',
    'Đang giao hàng' => 'Đang giao hàng',
    'Đã giao' => 'Đã giao',
    'Đã hủy' => 'Đã hủy',
  ];
  $payment_map = [
    0 => 'Chưa thanh toán',
    1 => 'Đã thanh toán',
    'Chua thanh toan' => 'Chưa thanh toán',
    'Da thanh toan' => 'Đã thanh toán',
    'Chưa thanh toán' => 'Chưa thanh toán',
    'Đã thanh toán' => 'Đã thanh toán',
  ];
  $method_map = [
    '1' => 'Chuyển khoản ngân hàng',
    '2' => 'Thanh toán khi nhận hàng (COD)',
    '3' => 'Thanh toán thẻ nội địa',
  ];
  $display_status = $status_map[$order_by_id->order_status] ?? $order_by_id->order_status;
  $display_payment = $payment_map[$order_by_id->payment_status] ?? $order_by_id->payment_status;
  $display_method = $method_map[(string) $order_by_id->payment_method] ?? $order_by_id->payment_method;
  $order_date = $order_by_id->created_at ? date('d/m/Y', strtotime($order_by_id->created_at)) : date('d/m/Y');
@endphp

<style>
.order-detail-wrap { max-width: 1200px; margin: 0 auto; }
.order-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.order-title { font-size: 18px; font-weight: 600; }
.order-badges { display: flex; gap: 8px; flex-wrap: wrap; }
.order-pill { background: #eef2ff; color: #233; border-radius: 999px; padding: 4px 10px; font-size: 12px; }
.order-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 18px; }
.order-card { background: #fff; border: 1px solid #eef0f3; border-radius: 10px; padding: 14px; box-shadow: 0 2px 6px rgba(10,10,10,0.04); }
.order-card h4 { margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #657; letter-spacing: .6px; }
.order-card p { margin: 0; font-weight: 600; font-size: 15px; color: #222; }
.info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 18px; }
.info-row { display: flex; gap: 10px; margin-bottom: 6px; font-size: 14px; }
.info-label { min-width: 110px; color: #667; }
.order-table .table { margin-bottom: 0; }
.order-table th { background: #f6f7fb; }
.order-total { display: flex; justify-content: flex-end; gap: 18px; margin-top: 12px; }
.order-total strong { font-size: 16px; }
@media (max-width: 992px) {
  .order-grid { grid-template-columns: 1fr; }
  .info-grid { grid-template-columns: 1fr; }
  .order-header { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>

<div class="order-detail-wrap">
  <div class="order-header">
    <div class="order-title">Chi tiết đơn hàng #{{ $order_by_id->order_id }}</div>
    <div class="order-badges">
      <span class="order-pill">{{ $display_status }}</span>
      <span class="order-pill">{{ $display_payment }}</span>
    </div>
  </div>

  <div class="order-grid">
    <div class="order-card">
      <h4>Ngày đặt</h4>
      <p>{{ $order_date }}</p>
    </div>
    <div class="order-card">
      <h4>Phương thức thanh toán</h4>
      <p>{{ $display_method ?: 'Không rõ' }}</p>
    </div>
    <div class="order-card">
      <h4>Tổng tiền</h4>
      <p>{{ format_price($order_by_id->order_total) }}</p>
    </div>
  </div>

  <div class="info-grid">
    <div class="order-card">
      <h4>Khách hàng</h4>
      <div class="info-row"><span class="info-label">Họ tên:</span><span>{{ $order_by_id->customer_name }}</span></div>
      <div class="info-row"><span class="info-label">Điện thoại:</span><span>{{ $order_by_id->customer_phone }}</span></div>
      <div class="info-row"><span class="info-label">Email:</span><span>{{ $order_by_id->customer_email ?: 'Không có' }}</span></div>
    </div>
    <div class="order-card">
      <h4>Giao hàng</h4>
      <div class="info-row"><span class="info-label">Họ tên:</span><span>{{ $order_by_id->shipping_name }}</span></div>
      <div class="info-row"><span class="info-label">Địa chỉ:</span><span>{{ $order_by_id->shipping_address }}</span></div>
      <div class="info-row"><span class="info-label">Điện thoại:</span><span>{{ $order_by_id->shipping_phone }}</span></div>
    </div>
  </div>

  <div class="order-card order-table">
    <h4>Danh sách sản phẩm</h4>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          @php $subtotal = 0; @endphp
          @forelse($order_details as $detail)
          @php
            $line_total = $detail->product_price * $detail->product_sales_quantity;
            $subtotal += $line_total;
          @endphp
          <tr>
            <td>{{ $detail->product_name }}</td>
            <td>{{ $detail->product_sales_quantity }}</td>
            <td>{{ format_price($detail->product_price) }}</td>
            <td>{{ format_price($line_total) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="4">Không có sản phẩm.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="order-total">
      <div><strong>Tạm tính:</strong> {{ format_price($subtotal) }}</div>
      <div><strong>Tổng cộng:</strong> {{ format_price($order_by_id->order_total) }}</div>
    </div>
  </div>
</div>
@endsection
