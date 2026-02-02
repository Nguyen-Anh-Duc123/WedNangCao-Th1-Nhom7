@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Thêm sản phẩm</header>
            <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" placeholder="Tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="product_slug" class="form-control" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <input type="text" name="product_price" class="form-control" placeholder="Giá">
                        </div>
                        <div class="form-group">
                            <label>Ảnh</label>
                            <input type="file" name="product_image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc" placeholder="Mô tả ngắn"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_content" placeholder="Nội dung"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Danh mục</label>
                            <select name="category_id" id="product_category" class="form-control input-sm m-bot15" required>
                                <option value="" selected disabled>-- Chọn danh mục --</option>
                                @foreach($cate_product as $key => $cate)
                                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thương hiệu</label>
                            <select name="brand_id" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-info">Lưu sản phẩm</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
