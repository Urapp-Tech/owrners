<button class="order_sort btn-profile btn-bg-1" data-val="all">
    {{ __('All') }} <span> ({{ $orders->total() ?? '' }}) </span>
</button>
<button class="order_sort" data-val="active">
    {{ __('Active') }} <span>({{ $active_orders }}) </span>
</button>
<button class="order_sort" data-val="queue">
    {{ __('Queue') }} <span> ({{ $queue_orders }}) </span>
</button>
<button class="order_sort" data-val="cancel">
    {{ __('Cancelled') }} <span>({{ $cancel_orders }}) </span>
</button>
<button class="order_sort" data-val="complete">
    {{ __('Completed') }} <span>({{ $complete_orders }}) </span>
</button>

<div class="col d-flex justify-content-end">
    <div class="col-md-6 position-relative">
        <input type="text" class="form-control order-tab-search-input" id="search-order-input" placeholder="search history">
        <div class="complete-profile-searchbar-icon">
            <img src="{{ asset('assets/static/icons/search-magnifying.svg') }}" alt="">
        </div>
    </div>
</div>

<input type="hidden" id="set_order_type_value" value="all">
<input type="hidden" id="sort_by_value" value="priority">

