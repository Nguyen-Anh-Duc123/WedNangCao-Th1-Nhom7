@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Cập nhật tin tức</header>
            <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message',null);
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    @foreach($edit_news as $key => $news)
                    <form role="form" action="{{URL::to('/update-news/'.$news->news_id)}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="news_title" class="form-control" value="{{$news->news_title}}">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="news_slug" class="form-control" value="{{$news->news_slug}}">
                        </div>
                        <div class="form-group">
                            <label>Danh mục tin tức</label>
                            <input type="text" name="news_category" class="form-control" value="{{$news->news_category}}">
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <textarea style="resize: none" rows="4" class="form-control" name="news_summary">{{$news->news_summary}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="news_content">{{$news->news_content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Ảnh</label>
                            <input type="file" name="news_image" class="form-control">
                            @if(!empty($news->news_image))
                                <img src="{{asset('uploads/news/'.$news->news_image)}}" height="100" width="100">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="news_status" class="form-control input-sm m-bot15">
                                <option value="1" {{$news->news_status == 1 ? 'selected' : ''}}>Hiển thị</option>
                                <option value="0" {{$news->news_status == 0 ? 'selected' : ''}}>Ẩn</option>
                            </select>
                        </div>
                        <button type="submit" name="update_news" class="btn btn-info">Cập nhật tin tức</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
