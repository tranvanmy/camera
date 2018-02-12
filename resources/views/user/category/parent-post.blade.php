@extends('user.layout')

@section('userTitle', $category->name)
@section('seoDescription', $category->seo_description)
@section('seoKeyword', $category->seo_keywork)

@section('content')
<div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="span-19">
            <h3 class="breakcolumn">
                <a title="Trang chủ" href="/">
                    <img src="/images/icons/home.png" alt="Trang chủ">
                </a>
                <span class="breakcolumn">»</span>
                <a href="{{ route('user.category.parent', [$category->slug]) }}" title="{{ $category->name }}">
                    {{ $category->name }}
                </a>
            </h3>
    
            @foreach ($categories as $childrenCategory)
                @php
                    if (!$childrenCategory->posts->count()) { continue; }
                @endphp
                <div class="news_column">
                    <div class="news-content bordersilver white clearfix">
                        <div class="header clearfix">
                            @if ($childrenCategory->parentCategory)
                                <a 
                                    title="{{ $category->name }}" 
                                    class="current" 
                                    href="{{ route('user.category.children', [$category->slug, $childrenCategory->slug]) }}"
                                >
                            @else
                                <a 
                                    title="{{ $childrenCategory->name }}" 
                                    class="current" 
                                    href="{{ route('user.category.parent', [$childrenCategory->slug]) }}"
                                >
                            @endif
                                <span>
                                    <span>{{ $childrenCategory->name }}</span>
                                </span>
                            </a>
                        </div>
                        <div class="clear"></div>
                        @php
                            $firstPost = $childrenCategory->posts->first();
                        @endphp
                        <div class="fixedwidth border_r items clearfix">
                            <h3>
                                <a title="{{ $firstPost->name }}" href="{{ route('user.post.detail', [$firstPost->slug]) }}">
                                    {{ $firstPost->name }}
                                </a>
                            </h3>
                            <a title="{{ $firstPost->name }}" href="{{ route('user.post.detail', [$firstPost->slug]) }}">
                                <img src="{{ Croppa::url('/' . $firstPost->image, 100, null, array('resize')) }}" 
                                    alt="{{ $firstPost->name }}" width="100"
                                />
                            </a>
                            <p>
                                {!! $firstPost->description !!}
                            </p>
                        </div>
                        @php
                            $posts = $childrenCategory->posts->where('id', '<>', $firstPost->id);
                        @endphp

                        @if ($posts->count())
                            <ul class="related fixedwidth">
                                @foreach ($posts as $post)
                                    <li>
                                        <a title="{{ $post->name }}" href="{{ route('user.post.detail', [$post->slug]) }}">
                                            {{ $post->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif                        
                    </div>
                </div>
            @endforeach

        </div>
        <div class="span-5 last">
            <div class="box silver">
                <div class="right_block_title">
                    <div class="bg_left_title">
                        <p>{{ $category->name }}</p>
                    </div>
                </div>
                <div id="smoothmenu2" class="ddsmoothmenu-v">
                    <ul class="ul_sub_menu">
                        @foreach($category->childrenCategories as $children)
                            <li class="">
                                <a class="" 
                                    title="{{ $children->name }}" 
                                    href="{{ route('user.category.children', [$category->slug, $children->slug]) }}"
                                >
                                    {{ $children->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <br style="clear: left">
                </div>
            </div>

            @include('user.library.news-hot')

            @include('user.library.statistics')
            
        </div>
        <div class="clear"></div>
    </div>
@endsection
