@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Thêm danh mục</header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tên danh mục</label>
                            <input type="text" name="category_product_name" class="form-control" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug_category_product" class="form-control" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_product_desc" placeholder="Mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="category_product_status" class="form-control input-sm m-bot15">
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="add_category_product" class="btn btn-info">Lưu danh mục</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
