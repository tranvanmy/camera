@extends('user.layout')

@section('userTitle', $data['product']->name)
@section('seoDescription', $data['product']->seo_description)
@section('seoKeyword', $data['product']->seo_keywork)

@section('content')
<div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="span-19">
            <h3 class="breakcolumn">
                <a title="Trang chủ" href="/">
                    <img src="/images/icons/home.png" alt="Trang chủ">
                </a>
                @php
                    $category = $data['product']->category;
                @endphp
                @if ($data['product']->category->parentCategory)
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
                    {{ $data['product']->name }}
            </h3>

            <div id="detail">
                <div>
                    <span style="float:left; text-align:center">
                        <a href="{{ route('user.product.detail', [$data['product']->slug]) }}" 
                            title="{{ $data['product']->name }}"
                        >
                            <img src="{{ Croppa::url('/' . $data['product']->image, 140, null, array('resize')) }}" 
                                alt="{{ $data['product']->name }}" width="140px" 
                                style="border:1px solid #eeeeee; padding:2px"
                            />
                        </a>
                    </span>
                    <div class="info_product fl">
                        <h2>{{ $data['product']->name }}</h2>
                        <span class="date_up">
                            Đăng ngày {{ $data['product']->created_at->format('d-m-Y H:i') }}
                             - {{ $data['product']->total_views }} lượt xem
                        </span>
                        <p>
                            Giá :
                            <span class="money">{{ $data['product']->price }}</span>
                        </p>
                        @if ($data['product']->guarantee)
                            <span class="time_up" style="font-weight:bold">
                                Bảo hành: {{ $data['product']->guarantee }}
                            </span>
                        @endif
                        <br>
                        
                        <div class="clearfix fl">
                            {{ $data['product']->description }}
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div style="clear:both"></div>
                    <script>
                        function changeProductTab(event) {
                            let parents = document.getElementsByClassName('user-product-tab');
                            for(let i = 0; i < parents.length; i++) {
                                parents[i].classList.remove('Active');
                            }
                            event.classList.add('Active')
                            
                            let children = document.getElementsByClassName('user-product-tab-view');
                            for(let i = 0; i < children.length; i++) {
                                children[i].style.display = 'none';
                            }

                            let id = event.getAttribute('data-target')
                            let element = document.getElementById(id)
                            if (element) {
                                element.style.display = 'block';
                            }
                        }
                    </script>
                    <div class="TabView" id="TabView">
                        <div class="Tabs">
                            <a href="#" class="Active user-product-tab" data-target="user-product-detail"
                                onclick="changeProductTab(this)"
                            >
                                Chi tiết sản phẩm
                            </a>
                            <a href="#" class="user-product-tab" data-target="user-product-guide"
                                onclick="changeProductTab(this)"
                            >
                                Hướng dẫn sử dụng
                            </a>
                        </div>
                        <div class="Pages">
                            <div class="Page user-product-tab-view" id="user-product-detail" style="display: block;">
                               {!! $data['product']->detail !!}
                            </div>
                            <div class="Page user-product-tab-view" id="user-product-guide" style="display: none;">
                                {!! $data['product']->guide !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block_title">
                    <div class="bg_left_title">
                        <p>Sản phẩm cùng loại</p>
                    </div>
                </div>
                <div id="products" class="clearfix">
                    @foreach($data['productRelation'] as $product)
                        <div class="items" style="width:33.333333333333%">
                            <div class="items_content">
                                <div class="content_top">
                                    <a href="{{ route('user.product.detail', [$product->slug]) }}" 
                                        title="{{ $product->name }}"
                                    >
                                        <img src="{{ Croppa::url('/' . $product->image, 80, null, array('resize')) }}" 
                                            alt="{{ $product->name }}"
                                            style="max-height:80px;max-width:80px;"
                                        />
                                    </a>
                                </div>
                                <div class="item_brief">
                                    <span>
                                        <a href="{{ route('user.product.detail', [$product->slug]) }}"
                                            title="{{ $product->name }}"
                                        >
                                            {{ $product->name }}
                                        </a>
                                    </span>
                                    <p class="content_price">
                                        <span class="money">{{ $product->price }}</span>
                                        <br>
                                    </p>
                                        @if ($product->guarantee)
                                            <span class="time_up">
                                                Bảo hành: {{ $product->guarantee }}
                                            </span>
                                        @endif
                                    <p>
                                </div>
                            </div>
                        </div>
                        @if ($loop->index % 3 === 2)
                            <div style="clear:both"></div>
                        @endif
                    @endforeach
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
                        @foreach($data['parentCategory']->childrenCategories as $children)
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
