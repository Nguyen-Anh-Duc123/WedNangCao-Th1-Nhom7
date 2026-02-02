@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <?php
        $order_message = Session::get('order_message');
        if($order_message){
            echo '<div class="alert alert-success" style="margin-bottom:16px;">'.$order_message.'</div>';
            Session::put('order_message',null);
        }
        $message = Session::get('message');
        if($message){
            echo '<div class="alert alert-danger" style="margin-bottom:16px;">'.$message.'</div>';
            Session::put('message',null);
        }
        ?>
        <div class="row checkout-layout">
            <div class="col-md-7">
                <div class="shopper-informations">
                    <div class="bill-to">
                        <p>Thông tin giao hàng</p>
                        <div class="form-one">
                            <form action="{{URL::to('/order-place')}}" method="POST">
                                {{csrf_field()}}
                                <input type="text" name="shipping_name" placeholder="Họ tên" required>
                                <input type="text" name="shipping_address" placeholder="Địa chỉ" required>
                                <input type="text" name="shipping_phone" placeholder="Số điện thoại" required>
                                <textarea name="shipping_notes" placeholder="Ghi chú đơn hàng" rows="6"></textarea>

                                <div class="payment-options payment-radio" style="margin-top:16px;">
                                    <span>
                                        <label><input name="payment_option" value="1" type="radio" required> Chuyển khoản ngân hàng</label>
                                    </span>
                                    <span>
                                        <label><input name="payment_option" value="2" type="radio"> Thanh toán khi nhận hàng (COD)</label>
                                    </span>
                                    <span>
                                        <label><input name="payment_option" value="3" type="radio"> Thanh toán thẻ nội địa</label>
                                    </span>
                                </div>
                                <input type="submit" value="Xác nhận đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="review-payment">
                    <h2>Xem lại giỏ hàng</h2>
                </div>
                <div class="checkout-items">
                    <?php
                    $content = Cart::content();
                    ?>
                    @foreach($content as $v_content)
                    @php
                        $imagePath = $v_content->options->image ?? '';
                        $resolvedPath = '';
                        if ($imagePath) {
                            if (file_exists(public_path($imagePath))) {
                                $resolvedPath = $imagePath;
                            } elseif (file_exists(public_path('uploads/product/'.$imagePath))) {
                                $resolvedPath = 'uploads/product/'.$imagePath;
                            } elseif (file_exists(public_path('uploads/product/stock/'.$imagePath))) {
                                $resolvedPath = 'uploads/product/stock/'.$imagePath;
                            }
                        }
                        if (!$resolvedPath) {
                            $resolvedPath = 'frontend/images/product1.jpg';
                        }
                        $subtotal = $v_content->price * $v_content->qty;
                    @endphp
                    <div class="checkout-item">
                        <div class="checkout-item-thumb">
                            <img src="{{asset($resolvedPath)}}" alt="" />
                        </div>
                        <div class="checkout-item-body">
                            <h4>{{$v_content->name}}</h4>
                            <div class="checkout-item-meta">
                                <div><span>Giá:</span> {{format_price($v_content->price)}}</div>
                                <div><span>Số lượng:</span> {{$v_content->qty}}</div>
                                <div><span>Thành tiền:</span> {{format_price($subtotal)}}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="total_area">
                    <ul>
                        <li>Tạm tính <span>{{format_price(Cart::total())}}</span></li>
                        <li>Thuế <span>{{format_price(Cart::tax())}}</span></li>
                        <li>Vận chuyển <span>Miễn phí</span></li>
                        <li>Tổng cộng <span>{{format_price(Cart::total())}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
