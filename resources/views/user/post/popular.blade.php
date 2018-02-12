@extends('user.layout')

@section('userTitle', 'Tin nổi bật')
@section('seoDescription', 'Tin nổi bật')
@section('seoKeyword', 'Tin nổi bật')

@section('content')
<div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="span-19">
            <h3 class="breakcolumn">
                <a title="Trang chủ" href="/">
                    <img src="/images/icons/home.png" alt="Trang chủ">
                </a>
                <span class="breakcolumn">»</span>
                Tin nổi bật
            </h3>
            @foreach ($posts as $post)
                <div class="news_column">
                    <div class="items clearfix">
                        <a href="{{ route('user.post.detail', [$post->slug]) }}" title="{{ $post->name }}">
                            <img alt="{{ $post->name }}" src="{{ Croppa::url('/' . $post->image, 100, null, array('resize')) }}" width="100">
                        </a>
                    <h3>
                        <a href="{{ route('user.post.detail', [$post->slug]) }}" title="{{ $post->name }}">
                            {{ $post->name }}
                        </a>
                    </h3>
                    <p>
                        {!! $post->description !!}
                    </p>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="span-5 last">
            
            @include('user.library.news-hot')

            @include('user.library.statistics')
            
        </div>
        <div class="clear"></div>
    </div>
@endsection
