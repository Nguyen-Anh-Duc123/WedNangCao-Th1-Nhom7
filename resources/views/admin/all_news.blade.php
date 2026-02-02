@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">Danh sách tin tức</div>
    <div class="table-responsive">
      <?php
        $message = Session::get('message');
        if($message){
          echo '<span class="text-alert">'.$message.'</span>';
          Session::put('message',null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;"><label class="i-checks m-b-none"><input type="checkbox"><i></i></label></th>
            <th>Tiêu đề</th>
            <th>Slug</th>
            <th>Danh mục</th>
            <th>Ảnh</th>
            <th>Trạng thái</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_news as $key => $news)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $news->news_title }}</td>
            <td>{{ $news->news_slug }}</td>
            <td>{{ $news->news_category }}</td>
            <td>
              @if(!empty($news->news_image))
                <img src="{{asset('uploads/news/'.$news->news_image)}}" height="80" width="80">
              @endif
            </td>
            <td><span class="text-ellipsis">
              <?php
               if($news->news_status==1){
                ?>
                <a href="{{URL::to('/unactive-news/'.$news->news_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>  
                 <a href="{{URL::to('/active-news/'.$news->news_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
               }
              ?>
            </span></td>
            <td>
              <a href="{{URL::to('/edit-news/'.$news->news_id)}}" class="active styling-edit"><i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Xóa tin tức này?')" href="{{URL::to('/delete-news/'.$news->news_id)}}" class="active styling-edit">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
