@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">Quản lý đơn hàng</div>
    <div class="table-responsive">
      <?php
        $message = Session::get('message');
        if($message){
          echo '<span class="text-alert">'.$message.'</span>';
          Session::put('message',null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;"><label class="i-checks m-b-none"><input type="checkbox"><i></i></label></th>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th>Cập nhật trạng thái</th>
            <th>Cập nhật thanh toán</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_order as $key => $order)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>#{{ $order->order_id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>
              @php
                $order_date = $order->created_at ? date('d/m/Y', strtotime($order->created_at)) : date('d/m/Y');
              @endphp
              {{ $order_date }}
            </td>
            <td>{{ format_price($order->order_total) }}</td>
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
              $display_status = $status_map[$order->order_status] ?? $order->order_status;
              $payment_map = [
                0 => 'Chưa thanh toán',
                1 => 'Đã thanh toán',
                'Chua thanh toan' => 'Chưa thanh toán',
                'Da thanh toan' => 'Đã thanh toán',
                'Chưa thanh toán' => 'Chưa thanh toán',
                'Đã thanh toán' => 'Đã thanh toán',
              ];
              $display_payment = $payment_map[$order->payment_status] ?? $order->payment_status;
              $is_paid = $display_payment === 'Đã thanh toán';
            @endphp
            <td><span class="status-pill">{{ $display_status }}</span></td>
            <td><span class="status-pill">{{ $display_payment }}</span></td>
            <td>
              <form method="POST" action="{{URL::to('/update-order-status/'.$order->order_id)}}" class="order-status-form">
                @csrf
                <select name="order_status" class="form-control input-sm" {{ $is_paid ? 'disabled' : '' }}>
                  @php
                    $known_statuses = ['Đang xử lý', 'Đang giao hàng', 'Đã giao', 'Đã hủy'];
                  @endphp
                  @if(!in_array($display_status, $known_statuses))
                    <option value="{{ $order->order_status }}" selected>{{ $display_status }}</option>
                  @endif
                  <option value="Đang xử lý" {{ $display_status == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                  <option value="Đang giao hàng" {{ $display_status == 'Đang giao hàng' ? 'selected' : '' }}>Đang giao hàng</option>
                  <option value="Đã giao" {{ $display_status == 'Đã giao' ? 'selected' : '' }}>Đã giao</option>
                  <option value="Đã hủy" {{ $display_status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                </select>
                <button type="submit" class="btn btn-xs btn-primary" {{ $is_paid ? 'disabled' : '' }}>Cập nhật</button>
              </form>
            </td>
            <td>
              <form method="POST" action="{{URL::to('/update-payment-status/'.$order->order_id)}}" class="order-status-form">
                @csrf
                <select name="payment_status" class="form-control input-sm" {{ $is_paid ? 'disabled' : '' }}>
                  @php
                    $known_payment = ['Chưa thanh toán', 'Đã thanh toán'];
                  @endphp
                  @if(!in_array($display_payment, $known_payment))
                    <option value="{{ $order->payment_status }}" selected>{{ $display_payment }}</option>
                  @endif
                  <option value="Chưa thanh toán" {{ $display_payment == 'Chưa thanh toán' ? 'selected' : '' }}>Chưa thanh toán</option>
                  <option value="Đã thanh toán" {{ $display_payment == 'Đã thanh toán' ? 'selected' : '' }}>Đã thanh toán</option>
                </select>
                <button type="submit" class="btn btn-xs btn-primary" {{ $is_paid ? 'disabled' : '' }}>Xác nhận</button>
              </form>
            </td>
            <td>
              <a href="{{URL::to('/view-order/'.$order->order_id)}}" class="btn btn-xs btn-default" title="Xem"><i class="fa fa-eye text-success text-active"></i></a>
              <a href="{{URL::to('/delete-order/'.$order->order_id)}}" class="btn btn-xs btn-danger" title="Xóa" onclick="return confirm('Xóa đơn hàng này?');"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">Đang hiển thị danh sách đơn hàng</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection
