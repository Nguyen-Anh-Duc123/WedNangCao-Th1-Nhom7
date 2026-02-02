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

        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="table-responsive cart_info">
            <?php
            $content = Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
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
                    @endphp
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{asset($resolvedPath)}}" width="90" alt="" /></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>Mã sản phẩm: 1089772</p>
                        </td>
                        <td class="cart_price">
                            <p>{{format_price($v_content->price)}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" data-action="minus" aria-label="Giảm">-</button>
                                    <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" data-max="99">
                                    <button type="button" class="qty-btn" data-action="plus" aria-label="Tăng">+</button>
                                </div>
                                <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                $subtotal = $v_content->price * $v_content->qty;
                                echo format_price($subtotal);
                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <h4 style="margin:40px 0;font-size: 20px;">Chọn phương thức thanh toán</h4>
        <form method="POST" action="{{URL::to('/order-place')}}">
            {{ csrf_field() }}
        <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="radio" required> Chuyển khoản ngân hàng</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="radio"> Thanh toán khi nhận hàng (COD)</label>
                </span>
                <span>
                    <label><input name="payment_option" value="3" type="radio"> Thanh toán thẻ nội địa</label>
                </span>
                <input type="submit" value="Xác nhận đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
        </div>
        </form>
    </div>
</section>
@endsection
