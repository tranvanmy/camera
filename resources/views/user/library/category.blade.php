<div class="nav">
    <ul class="nav fl" id="navid">
        <li 
            {{--  class="current"  --}}
        >
            <a title="Trang chủ" href="/">
                <span class="span_home">
                    Trang chủ
                </span>
            </a>
        </li>
        @foreach($userCategories as $category)
            <li>
                <a title="{{ $category->name }}" href="{{ route('user.category.parent', [$category->slug]) }}">
                    <span>{{ $category->name }}</span>
                </a>
                @if ($category->childrenCategories)
                    <ul class="subnav">
                        @foreach($category->childrenCategories as $children)
                            <li class="li_subnav">
                                <a title="{{ $children->name }}" href="{{ route('user.category.children', [$category->slug, $children->slug]) }}">
                                    {{ $children->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>