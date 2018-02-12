@php
    $options = '';
    if($userSetups) {
        $options = json_decode($userSetups->option, true);
    }
@endphp

<div id="header">
    <div id="logo">
        <a title="" href="/">
            @if ($options && $options['logo'])
                <img src="{{ Croppa::url('/' . $options['logo'], null, 76, array('resize')) }}" alt="Camera289">
            @else
                <img src="/images/icons/logo.png" alt="Camera289">
            @endif
        </a>
    </div>
    <div class="searchfield">
        <form action="{{ route('user.search') }}" method="get" id="skypeSearchForm">
            <div class="typesearch">
                <input class="typeKey" title="Tìm kiếm" type="text" name="key"
                    maxlength="60" placeholder="Nhập tên sản phẩm hoặc từ khóa tìm kiếm..."
                >
            </div>
            <input type="submit" value="" class="btnSearch">
        </form>
    </div>
    <div class="content_right" style="padding-right:25px;position: relative">
        <div style="width: 200px; float:left; padding-top:10px">
            <em style="font-size: 14px; color: rgb(0, 0, 0);">
                <strong style="color: red;">
                    TRUNG THỰC
                </strong>
            </em><br/>
            <em style="font-size: 14px; color: rgb(0, 0, 0);">
                <strong style="color: red;">
                    CHUYÊN NGHIỆP                        
                </strong>
            </em><br/>
            <em style="font-size: 14px; color: rgb(0, 0, 0);">
                <strong style="color: red;">
                    TẬN TÂM
                </strong>
            </em>
        </div>
        <div style="width: 340px; text-align: right; float:left; font-size:14px; padding-top:10px">
                <strong>Địa chỉ : </strong>
                Số 5, ngõ 289 Hoàng Mai, Hà Nội
                <br/>
                <strong>Điện thoại : </strong>
                0943.044.115 - 0975.801.420
        </div>
    </div>
    <div id="header_nav">
        <div class="fl" style="float:right; margin-right: 10px" id="navid">
            @foreach($userMenu['right'] as $menu)
                <div style="margin-top: {{ $menu->icon ? '-22px;' : '3px' }};  float: left; margin-right: 9px;">
                    <a title="{{ $menu->name }}" href="{{ $menu->path }}">
                        {{ $menu->name }}
                        @if ($menu->icon)
                            <img alt="" src="{{ Croppa::url('/' . $menu->icon, null, 37, array('resize')) }}" style="height:37px">
                        @endif
                        <img alt="" src="/uploads/khuyen-mai.png" style="height:37px">
                    </a>
                </div>
            @endforeach
        </div>
        <div class="fl" id="navid">
            @foreach($userMenu['left'] as $menu)
                <div style="margin-top: {{ $menu->icon ? '-22px;' : '3px' }}; float: left; margin-right: 9px;">
                    <a title="{{ $menu->name }}" href="{{ $menu->path }}">
                        {{ $menu->name }}
                        @if ($menu->icon)
                            <img alt="" src="{{ Croppa::url('/' . $menu->icon, null, 37, array('resize')) }}" style="height:37px">
                        @endif
                        <img alt="" src="/uploads/khuyen-mai.png" style="height:37px">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div style="clear:both"></div>
</div>