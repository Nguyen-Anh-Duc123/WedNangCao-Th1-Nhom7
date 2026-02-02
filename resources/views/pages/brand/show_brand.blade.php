@extends('layout')
@section('content')
<div class="features_items">
    @foreach($brand_name as $key => $name)
    <h2 class="title text-center">{{$name->brand_name}}</h2>
    @endforeach
    @foreach($brand_by_id as $key => $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    @php
                        $imagePath = $product->product_image ?? '';
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
                    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
                        <img src="{{asset($resolvedPath)}}" alt="" />
                    </a>
                    <h2>{{format_price($product->product_price)}}</h2>
                    <p><a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">{{$product->product_name}}</a></p>
                    <form action="{{URL::to('/save-cart')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="productid_hidden" value="{{$product->product_id}}">
                        <input type="hidden" name="qty" value="1">
                        <button type="submit" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{ __('ui.btn.add_to_cart') }}</button>
                    </form>
                </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li>
                        <form action="{{URL::to('/wishlist/add')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="product_id" value="{{$product->product_id}}">
                            <button type="submit" class="btn-link"><i class="fa fa-plus-square"></i>{{ __('ui.btn.wishlist') }}</button>
                        </form>
                    </li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>{{ __('ui.compare') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
