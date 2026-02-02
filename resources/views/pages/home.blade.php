@extends('layout')

@section('hero')
<div class="hero-card">
    <div class="hero-copy">
        <p class="eyebrow">{{ __('ui.home.eyebrow') }}</p>
        <h1>{{ __('ui.home.title') }}</h1>
        <p class="lead">{{ __('ui.home.lead') }}</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="{{URL::to('/shop.html')}}">{{ __('ui.home.primary') }}</a>
            <a class="btn btn-ghost" href="{{URL::to('/tin-tuc')}}">{{ __('ui.home.secondary') }}</a>
        </div>
    </div>
    <div class="hero-visual">
        <img src="{{('frontend/images/girl2.jpg')}}" alt="Featured collection" />
    </div>
</div>
@endsection

@section('content')
<div class="section-header">
    <h2>{{ __('ui.home.latest_products') }}</h2>
    <p>{{ __('ui.home.latest_products_desc') }}</p>
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

@if(isset($latest_news) && count($latest_news))
<div class="section-header section-news">
    <h2>{{ __('ui.home.latest_news') }}</h2>
    <p>{{ __('ui.home.latest_news_desc') }}</p>
</div>

<div class="news-grid">
    @foreach($latest_news as $news)
    <article class="news-card">
        <a class="news-thumb" href="{{URL::to('/tin-tuc/'.$news->news_slug)}}">
            <img src="{{asset('uploads/news/'.$news->news_image)}}" alt="{{$news->news_title}}" />
        </a>
        <div class="news-body">
            <p class="eyebrow">{{$news->news_category}}</p>
            <h3><a href="{{URL::to('/tin-tuc/'.$news->news_slug)}}">{{$news->news_title}}</a></h3>
            <p>{{$news->news_summary}}</p>
        </div>
    </article>
    @endforeach
</div>
@endif
@endsection
