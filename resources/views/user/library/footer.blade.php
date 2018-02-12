<div id="footer" class="clearfix">
    <div class="footer_top">
        <div class="footer_location">
            <span style="font-size:12px;">
                <span style="font-size:14px;">
                    <strong>Địa chỉ : </strong>
                    Số 5, ngõ 289 Hoàng Mai, Hà Nội
                    <br/>
                    <strong>Điện thoại : </strong>
                    0943.044.115 - 0975.801.420
                </span>
            </span>
            <h3 style="margin-top:10px">
                <span style="color: rgb(255, 0, 0); ">
                    <strong style="color: rgb(255, 140, 0); font-size: 15px; ">
                        Copyright © {{ date('Y') }} - All right reserved by Camera289
                    </strong>
                </span>
            </h3>
        </div>

        <div class="footer_menu" >
            <div class="nav_foot">
                @foreach($userPostCategories as $postCategory)
                    @php
                        if (!$postCategory->childrenCategories->count()) continue;
                    @endphp
                    <ul class="nav_foot_ul">
                        <li>
                            <h3>
                                <a title="{{ $postCategory->name }}"
                                    href="{{ route('user.category.parent', [$postCategory->slug]) }}"
                                >
                                    {{ $postCategory->name }}
                                </a>
                            </h3>
                            <ul class="subnav_foot">
                                @foreach($postCategory->childrenCategories as $children)
                                    <li>
                                        <a title="{{ $children->name }}" 
                                            href="{{ route('user.category.children', [$postCategory->slug, $children->slug]) }}"
                                        >
                                            {{ $children->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                @endforeach                
            </div>
         </div>
    </div>
    <div class="clear"></div>
</div>
