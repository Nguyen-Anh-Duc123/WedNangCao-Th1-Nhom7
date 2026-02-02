@extends('layout')

@section('content')
<div class="section-header">
    <h2>{{ __('ui.news.latest') }}</h2>
    <p>{{ __('ui.news.latest_desc') }}</p>
</div>

<div class="news-grid">
    @foreach($news as $item)
    <article class="news-card">
        <a class="news-thumb" href="{{URL::to('/tin-tuc/'.$item->news_slug)}}">
            <img src="{{asset('uploads/news/'.$item->news_image)}}" alt="{{$item->news_title}}" />
        </a>
        <div class="news-body">
            <p class="eyebrow">{{$item->news_category}}</p>
            <h3><a href="{{URL::to('/tin-tuc/'.$item->news_slug)}}">{{$item->news_title}}</a></h3>
            <p>{{$item->news_summary}}</p>
        </div>
    </article>
    @endforeach
</div>
@endsection

