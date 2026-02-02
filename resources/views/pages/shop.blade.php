@extends('layout')

@section('content')
<div class="section-header">
    <h2>{{ __('ui.shop.all_products') }}</h2>
    <p>{{ __('ui.shop.all_products_desc') }}</p>
</div>

<div class="product-grid">
    @foreach($all_product as $key => $product)
    <div class="product-card">
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
        <a class="product-thumb" href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
            <img src="{{asset($resolvedPath)}}" alt="{{$product->product_name}}" />
        </a>
        <div class="product-body">
            <h3><a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">{{$product->product_name}}</a></h3>
            <p class="price">{{format_price($product->product_price)}}</p>
            <div class="product-actions">
                <form action="{{URL::to('/save-cart')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="productid_hidden" value="{{$product->product_id}}">
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> {{ __('ui.btn.add_to_cart') }}</button>
                </form>
                <form action="{{URL::to('/wishlist/add')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="product_id" value="{{$product->product_id}}">
                    <button type="submit" class="btn btn-ghost btn-sm"><i class="fa fa-star"></i> {{ __('ui.btn.wishlist') }}</button>
                </form>
                <a class="btn btn-ghost btn-sm" href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">{{ __('ui.btn.view') }}</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

