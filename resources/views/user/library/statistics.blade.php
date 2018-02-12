<div class="box silver">
    <div class="right_block_title">
        <div class="bg_left_title">
            <p>Thống kê truy nhập</p>
        </div>
    </div>
    <div class="content online">
        <p>
            <span>
                <img src="/images/online/users.png" width="16" height="16" alt="Đang truy cập">
            </span>
            <span>Đang truy cập : {{ Visitor::count() }}
            </span>
        </p>
        <hr>
        <p>
            <span>
                <img src="/images/online/today.png" width="16" height="16" alt="Hôm nay">
                Hôm nay: {{ Visitor::range(Carbon\Carbon::now()->startOfDay(), Carbon\Carbon::now()->endOfDay()) }}
            </span>
        </p>
        <p>
            <span>
                <img src="/images/online/month.png" width="16" height="16" alt="Tháng hiện tại">
                Tháng hiện tại : {{ Visitor::range(Carbon\Carbon::now()->startOfMonth(), Carbon\Carbon::now()->endOfMonth()) }}
            </span>
        </p>
        <p>
            <span>
                <img src="/images/online/hits.png" width="16" height="16" alt="Tổng lượt truy cập">
                Tổng lượt truy cập :
                <strong>{{ Visitor::clicks() }}</strong>
            </span>
        </p>
    </div>
</div>
