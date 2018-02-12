@extends('user.layout')

@section('userTitle', 'Tìm kiếm')
@section('seoDescription', 'Tìm kiếm')
@section('seoKeyword', 'Tìm kiếm')

@section('content')
<div class="contentwrapper background">
        <div style="clear:both"></div>
        <div class="span-19">
            <h3 class="breakcolumn">
                <a title="Trang chủ" href="/">
                    <img src="/images/icons/home.png" alt="Trang chủ">
                </a>
                <span class="breakcolumn">»</span>
                Tìm kiếm
            </h3>
            <div id="category" style="padding:3px;">
                <div class="page_title">
                    <div class="fl">
                        <span class="cat_title">Tìm kiếm </span>
                        <span> cho từ khóa "{{ url()->getRequest()->key }}"</span>
                    </div>
                </div>

                @if(!$products->count())
                    <div class="list_rows clearfix" 
                        style="font-size: 15px; padding: 20px; margin: 10px 10px 25px;text-align:center"
                    >
                        Không có sản phẩm nào với từ khóa bạn vừa nhập vào
                    </div>
                @endif

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
                    {{ $products->appends(['key' => url()->getRequest()->key])->links() }}
                </div>
            </div>
        </div>
        <div class="span-5 last">

            @include('user.library.news-hot')

            @include('user.library.statistics')
            
        </div>
        <div class="clear"></div>
    </div>
@endsection
