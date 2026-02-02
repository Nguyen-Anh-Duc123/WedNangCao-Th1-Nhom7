@extends('layout')
@section('content')
@foreach($product_details as $key => $value)
<div class="product-details">
    <div class="col-sm-5">
        <div class="view-product">
            @php
                $imagePath = $value->product_image ?? '';
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
            <img src="{{asset($resolvedPath)}}" alt="" />
            <h3>{{ __('ui.product.zoom') }}</h3>
        </div>
        <div id="similar-product" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @if(isset($gallery_images) && count($gallery_images))
                    @php $chunks = $gallery_images->chunk(3); @endphp
                    @foreach($chunks as $index => $chunk)
                        <div class="item {{ $index === 0 ? 'active' : '' }}">
                            @foreach($chunk as $gallery)
                                <a href=""><img src="{{asset('uploads/product/gallery/'.$gallery->gallery_image)}}" alt=""></a>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <div class="item active">
                      <a href=""><img src="{{asset('frontend/images/similar1.jpg')}}" alt=""></a>
                      <a href=""><img src="{{asset('frontend/images/similar2.jpg')}}" alt=""></a>
                      <a href=""><img src="{{asset('frontend/images/similar3.jpg')}}" alt=""></a>
                    </div>
                @endif
            </div>
            <a class="left item-control" href="#similar-product" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right item-control" href="#similar-product" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="product-information">
            <img src="{{asset('frontend/images/new.jpg')}}" class="newarrival" alt="" />
            <h2>{{$value->product_name}}</h2>
            <p>{{ __('ui.product.id') }}: {{$value->product_id}}</p>
            <img src="{{asset('frontend/images/rating.png')}}" alt="" />
            <form action="{{URL::to('/save-cart')}}" method="POST">
                {{ csrf_field() }}
            <span>
                <span>{{format_price($value->product_price)}}</span>
                <label>{{ __('ui.product.qty') }}:</label>
                <input name="qty" type="number" min="1"  value="1" />
                <input name="productid_hidden" type="hidden"  value="{{$value->product_id}}" />
                <button type="submit" class="btn btn-fefault cart">
                    <i class="fa fa-shopping-cart"></i>
                    {{ __('ui.btn.add_to_cart') }}
                </button>
            </span>
            </form>
            <form action="{{URL::to('/wishlist/add')}}" method="POST" style="margin-top:10px;">
                {{ csrf_field() }}
                <input type="hidden" name="product_id" value="{{$value->product_id}}" />
                <button type="submit" class="btn btn-default"><i class="fa fa-star"></i> {{ __('ui.btn.wishlist') }}</button>
            </form>

            <p><b>{{ __('ui.product.status') }}:</b> {{ __('ui.product.in_stock') }}</p>
            <p><b>{{ __('ui.product.condition') }}:</b> {{ __('ui.product.new') }}</p>
            <p><b>{{ __('ui.product.brand') }}:</b> {{$value->brand_name}}</p>
            <p><b>{{ __('ui.product.category') }}:</b> {{$value->category_name}}</p>
            <a href=""><img src="{{asset('frontend/images/share.png')}}" class="share img-responsive"  alt="" /></a>
        </div>
    </div>
</div>

<div class="category-tab shop-details-tab">
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">{{ __('ui.product.description') }}</a></li>
            <li><a href="#companyprofile" data-toggle="tab">{{ __('ui.product.details') }}</a></li>
            <li><a href="#reviews" data-toggle="tab">{{ __('ui.product.reviews') }}</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details" >
            <p>{!!$value->product_desc!!}</p>
        </div>
        <div class="tab-pane fade" id="companyprofile" >
            <p>{!!$value->product_content!!}</p>
        </div>
        <div class="tab-pane fade" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <p>{{ __('ui.product.write_review') }}</p>
                <p><b>{{ __('ui.product.write_review') }}</b></p>
                <form action="#">
                    <span>
                        <input type="text" placeholder="{{ __('ui.contact.name') }}"/>
                        <input type="email" placeholder="Email"/>
                    </span>
                    <textarea name="" ></textarea>
                    <b>{{ __('ui.product.rating') }}: </b> <img src="{{asset('frontend/images/rating.png')}}" alt="" />
                    <button type="button" class="btn btn-default pull-right">
                        {{ __('ui.product.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="recommended_items">
    <h2 class="title text-center">{{ __('ui.product.related') }}</h2>
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
        @foreach($relate as $key => $lienquan)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                         <div class="single-products">
                            <div class="productinfo text-center">
                                @php
                                    $imagePath = $lienquan->product_image ?? '';
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
                                <a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_slug)}}">
                                    <img src="{{asset($resolvedPath)}}" alt="" />
                                </a>
                                <h2>{{format_price($lienquan->product_price)}}</h2>
                                <p>
                                    <a href="{{URL::to('/chi-tiet-san-pham/'.$lienquan->product_slug)}}">
                                        {{$lienquan->product_name}}
                                    </a>
                                </p>
                                <form action="{{URL::to('/save-cart')}}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="productid_hidden" value="{{$lienquan->product_id}}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{ __('ui.btn.add_to_cart') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
            </div>
        </div>
         <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
    </div>
</div>
@endsection
