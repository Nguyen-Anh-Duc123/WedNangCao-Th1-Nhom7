@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Thêm tin tức</header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-news')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="news_title" class="form-control" placeholder="Tiêu đề">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="news_slug" class="form-control" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label>Danh mục tin tức</label>
                            <input type="text" name="news_category" class="form-control" placeholder="Ví dụ: Công nghệ, Đánh giá">
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <textarea style="resize: none" rows="4" class="form-control" name="news_summary" placeholder="Tóm tắt ngắn"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="news_content" placeholder="Nội dung chi tiết"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Ảnh</label>
                            <input type="file" name="news_image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="news_status" class="form-control input-sm m-bot15">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="add_news" class="btn btn-info">Lưu tin tức</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
