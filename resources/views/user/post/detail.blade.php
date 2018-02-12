@extends('user.layout')

@section('userTitle', $data['post']->name)
@section('seoDescription', $data['post']->seo_description)
@section('seoKeyword', $data['post']->seo_keywork)

@section('content')
<div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="span-19">
            <h3 class="breakcolumn">
                <a title="Trang chủ" href="/">
                    <img src="/images/icons/home.png" alt="Trang chủ">
                </a>
                @php
                    $category = $data['post']->category;
                @endphp
                @if ($data['post']->category->parentCategory)
                    <span class="breakcolumn">»</span>
                    <a 
                        href="{{ route('user.category.parent', [$category->parentCategory->slug]) }}" 
                        title="{{ $category->parentCategory->name }}"
                    >
                        {{ $category->parentCategory->name }}
                    </a>
                    <span class="breakcolumn">»</span>
                    <a 
                        href="{{ route('user.category.children', [$category->parentCategory->slug, $category->slug]) }}" 
                        title="{{ $category->name }}"
                    >
                        {{ $category->name }}
                    </a>
                @else
                    <span class="breakcolumn">»</span>
                    <a 
                        href="{{ route('user.category.parent', [$category->slug]) }}" 
                        title="{{ $category->name }}"
                    >
                        {{ $category->name }}
                    </a>
                @endif
                <span class="breakcolumn">»</span>
                {{ $data['post']->name }}
            </h3>

            <div class="news_column" style="padding:0 !important;margin:0 !important;">
                <div id="news_detail">
                    <h1>{{ $data['post']->name }}</h1>
                    <span class="time">{{ $data['post']->created_at->format('d-m-Y H:i') }}</span>
                    
                    <div style="clear: both;"></div>
                    <div id="hometext">
                        <div id="imghome" class="fl" style="width:100px;margin-right:8px;">
                            <a href="#" title="" rel="shadowbox">
                                <img 
                                    alt="{{ $data['post']->name }}" width="100"
                                    src="{{ Croppa::url('/' . $data['post']->image, 100, null, array('resize')) }}"
                                />
                            </a>
                        </div>
                        {!! $data['post']->description !!}
                    </div>
                    <div class="bodytext">  
                        {!! $data['post']->detail !!}
                    </div>
                </div>
                <div class="clear"></div>
                <p style="margin-top: 10px; border-top: 2px solid #DCDCDC; padding-top: 10px">
                    <strong>Những tin mới hơn</strong>
                </p>
                <ul class="related">
                    @foreach($data['newer-news'] as $post)
                        <li>
                            <a title="{{ $post->name }}" href="{{ route('user.post.detail', [$post->slug]) }}">
                                {{ $post->name }}
                            </a>
                            <span class="date">({{ $data['post']->created_at->format('d-m-Y') }})</span>
                        </li>
                    @endforeach
                </ul>
                <div class="clear"></div>
                <p style="margin-top: 10px; border-top: 2px solid #DCDCDC; padding-top: 10px">
                    <strong>Những tin cũ hơn</strong>
                </p>
                <ul class="related">
                    @foreach($data['older-news'] as $post)
                        <li>
                            <a title="{{ $post->name }}" href="{{ route('user.post.detail', [$post->slug]) }}">
                                {{ $post->name }}
                            </a>
                            <span class="date">({{ $data['post']->created_at->format('d-m-Y') }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @php
            $parentCategory = $category;

            if ($category->parentCategory) {
                $parentCategory = $category->parentCategory;
            } 
        @endphp

        <div class="span-5 last">
            <div class="box silver">
                <div class="right_block_title">
                    <div class="bg_left_title">
                        <p>{{ $parentCategory->name }}</p>
                    </div>
                </div>
                <div id="smoothmenu2" class="ddsmoothmenu-v">
                    <ul class="ul_sub_menu">
                        @foreach($parentCategory->childrenCategories as $children)
                            <li class="">
                                <a class="{{ ($children->id == $category->id) ? 'a_sub_menu_select' : ''}}"  
                                    title="{{ $children->name }}" 
                                    href="{{ route('user.category.children', [$parentCategory->slug, $children->slug]) }}"
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
