@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Cập nhật sản phẩm</header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                @foreach($edit_product as $key => $pro)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" value="{{$pro->product_name}}" name="product_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" value="{{$pro->product_slug}}" name="product_slug" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <input type="text" value="{{$pro->product_price}}" name="product_price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Ảnh</label>
                            <input type="file" name="product_image" class="form-control">
                            <img src="{{URL::to('uploads/product/'.$pro->product_image)}}" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label>Ảnh chi tiết (tải nhiều ảnh)</label>
                            <input type="file" name="product_gallery[]" class="form-control" multiple>
                            <p class="help-block">Có thể chọn nhiều ảnh để hiển thị chi tiết sản phẩm.</p>
                            <button type="submit" formaction="{{URL::to('/add-product-gallery/'.$pro->product_id)}}" class="btn btn-default">Tải ảnh chi tiết</button>
                        </div>
                        @if(isset($product_gallery) && count($product_gallery))
                        <div class="form-group">
                            <label>Ảnh chi tiết hiện có</label>
                            <div style="display:flex; flex-wrap:wrap; gap:10px;">
                                @foreach($product_gallery as $gallery)
                                    <div style="text-align:center;">
                                        <img src="{{asset('uploads/product/gallery/'.$gallery->gallery_image)}}" height="80" width="80">
                                        <div style="margin-top:6px;">
                                            <a class="btn btn-xs btn-danger" href="{{URL::to('/delete-product-gallery/'.$gallery->gallery_id)}}" onclick="return confirm('Xóa ảnh này?')">Xóa</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc">{{$pro->product_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_content">{{$pro->product_content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Danh mục</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                    @if($cate->category_id==$pro->category_id)
                                        <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @else
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thương hiệu</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                    @if($brand->brand_id==$pro->brand_id)
                                        <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @else
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                @if($pro->product_status==0)
                                    <option selected value="0">Hiển thị</option>
                                    <option value="1">Ẩn</option>
                                @else
                                    <option value="0">Hiển thị</option>
                                    <option selected value="1">Ẩn</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit" name="update_product" class="btn btn-info">Cập nhật sản phẩm</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection
