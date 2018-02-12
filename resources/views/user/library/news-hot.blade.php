<div class="box silver">
    <div class="right_block_title">
        <div class="bg_left_title">
            <p>
                <a href="{{ route('user.post.list') }}">Tin nổi bật</a>
            </p>
        </div>
    </div>
    <div class="other_blocknews">
        <ul>
            @foreach($userHotPosts as $post)
                <li class="clearfix ">
                    <a href="{{ route('user.post.detail', [$post->slug]) }}" title="{{ $post->name }}">
                        <img src="{{ Croppa::url('/' . $post->image, 60, null, array('resize')) }}" 
                            alt="{{ $post->name }}"
                        />
                    </a>
                    <a href="{{ route('user.post.detail', [$post->slug]) }}" title="{{ $post->name }}">
                        {{ $post->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
