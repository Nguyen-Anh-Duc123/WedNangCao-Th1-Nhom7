@extends('layout')

@section('content')
@if(!$news_item)
    <div class="alert alert-warning">{{ __('ui.news.not_found') }}</div>
@else
    <article class="news-detail">
        <img src="{{asset('uploads/news/'.$news_item->news_image)}}" alt="{{$news_item->news_title}}" />
        <div class="news-body">
            <p class="eyebrow">{{$news_item->news_category}}</p>
            <h2>{{$news_item->news_title}}</h2>
            <div class="news-content">{!! nl2br(e($news_item->news_content)) !!}</div>
        </div>
    </article>
@endif
@endsection

