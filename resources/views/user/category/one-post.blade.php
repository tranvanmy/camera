@extends('user.layout')

@section('userTitle', $post->name)
@section('seoDescription', $post->seo_description)
@section('seoKeyword', $post->seo_keywork)

@section('content')
<div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="span-19">
            <h3 class="breakcolumn">
                <a title="Trang chủ" href="/">
                    <img src="/images/icons/home.png" alt="Trang chủ">
                </a>
                <span class="breakcolumn">»</span>
                <a 
                    href="{{ route('user.category.parent', [$category->slug]) }}" 
                    title="{{ $category->name }}"
                >
                    {{ $category->name }}
                </a>
            </h3>

            <div class="news_column" style="padding:0 !important;margin:0 !important;">
                <div id="news_detail" style="padding: 20px">
                    {!! $post->detail !!}
                </div>
            </div>
            
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
