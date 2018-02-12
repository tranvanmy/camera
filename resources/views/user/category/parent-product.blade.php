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
            <div id="category" style="padding:3px;">
                <div class="page_title">
                    <div class="fl">
                        <span class="cat_title">{{ $category->name }}</span>
                        <span class="cat_filter"></span>
                    </div>
                </div>
                @foreach ($products as $product)
                    <div class="list_rows clearfix">
                        <div class="img clearfix">
                            <a title="{{ $product->name }}" href="{{ route('user.product.detail', [$product->slug]) }}">
                                <img 
                                    width="80" class="reflect" 
                                    src="{{ Croppa::url('/' . $product->image, 80, null, array('resize')) }}" alt="{{ $product->name }}" 
                                >
                            </a>
                        </div>
                        <div class="content_title">
                            <h2>
                                <a title="{{ $product->name }}" 
                                    href="{{ route('user.product.detail', [$product->slug]) }}"
                                >
                                    {{ $product->name }}
                                </a>
                            </h2>
                            <br>
                            <span>
                                {!! $product->description !!}
                            </span>
                            <br/><br/>
                            @if ($product->guarantee)
                                <span class="time_up">Bảo hành: {{ $product->guarantee }}</span>
                            @endif
                        </div>
                        <div class="fr money_order">
                            <div class="money_order_margin">
                                Giá:
                                <strong class="money">{{ $product->price }}</strong>
                                <br>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="pages">
                    {{ $products->links() }}
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
