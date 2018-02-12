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
                <a href="{{ route('user.category.parent', [$categoryParent->slug]) }}" 
                    title="{{ $categoryParent->name }}"
                >
                    {{ $categoryParent->name }}
                </a>
                <span class="breakcolumn">»</span>
                <a href="{{ route('user.category.children', [$categoryParent->slug,$category->slug]) }}"
                    title="{{ $category->name }}"
                >
                    {{ $category->name }}
                </a>
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
            <div class="box silver">
                <div class="right_block_title">
                    <div class="bg_left_title">
                        <p>{{ $categoryParent->name }}</p>
                    </div>
                </div>
                <div id="smoothmenu2" class="ddsmoothmenu-v">
                    <ul class="ul_sub_menu">
                        @foreach($categoryParent->childrenCategories as $children)
                            <li class="">
                                <a class="{{ ($children->id == $category->id) ? 'a_sub_menu_select' : ''}}" 
                                    title="{{ $children->name }}" 
                                    href="{{ route('user.category.children', [$categoryParent->slug, $children->slug]) }}"
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
