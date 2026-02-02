@extends('layout')
@section('content')
<section id="wishlist_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">{{ __('ui.nav.home') }}</a></li>
              <li class="active">{{ __('ui.wishlist.title') }}</li>
            </ol>
        </div>

        <?php
        $message = Session::get('message');
        if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message',null);
        }
        ?>

        <div class="table-responsive cart_info">
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
                    @forelse($wishlist as $item)
                    @php
                        $imagePath = $item['image'] ?? '';
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
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$item['slug'])}}">
                                <img src="{{asset($resolvedPath)}}" width="90" alt="{{$item['name']}}" />
                            </a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="{{URL::to('/chi-tiet-san-pham/'.$item['slug'])}}">{{$item['name']}}</a></h4>
                        </td>
                        <td class="cart_price">
                            <p>{{format_price($item['price'])}}</p>
                        </td>
                        <td class="cart_quantity">
                            <form action="{{URL::to('/save-cart')}}" method="POST" style="display:inline-block;">
                                {{csrf_field()}}
                                <input type="hidden" name="productid_hidden" value="{{$item['id']}}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> {{ __('ui.btn.add_to_cart') }}</button>
                            </form>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/wishlist/remove/'.$item['id'])}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">{{ __('ui.wishlist.empty') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
