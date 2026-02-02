@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="row cart-layout">
            <div class="col-md-8">
                <div class="table-responsive cart_info">
                    <?php
                    $content = Cart::content();
                    ?>
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">{{ __('ui.cart.image') }}</td>
                                <td class="description">{{ __('ui.cart.product') }}</td>
                        <td class="price">{{ __('ui.cart.price') }}</td>
                        <td class="quantity">{{ __('ui.cart.quantity') }}</td>
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
                                    <p>{{ __('ui.cart.code') }}: 1089772</p>
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
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="total_area">
                    <ul>
                        <li>{{ __('ui.cart.subtotal') }} <span>{{format_price(Cart::total())}}</span></li>
                        <li>{{ __('ui.cart.tax') }} <span>{{format_price(Cart::tax())}}</span></li>
                        <li>{{ __('ui.cart.shipping') }} <span>{{ __('ui.cart.free') }}</span></li>
                        <li>{{ __('ui.cart.grand_total') }} <span>{{format_price(Cart::total())}}</span></li>
                    </ul>
                    <?php
                       $customer_id = Session::get('customer_id');
                       if($customer_id!=NULL){
                     ?>
                      <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">{{ __('ui.cart.checkout') }}</a>
                    <?php
                    }else{
                     ?>
                      <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">{{ __('ui.cart.checkout') }}</a>
                     <?php
                     }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
