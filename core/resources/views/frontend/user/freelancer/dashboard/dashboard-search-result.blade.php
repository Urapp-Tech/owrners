@if($orders->total() < 1)
    <div class="myOrder-single bg-white padding-20 radius-10">
        <div class="myOrder-single-item">
            <h4 class="text-danger">{{ __('No Order') }}</h4>
        </div>
    </div>
@else
    @foreach($orders as $order)
        @php $rating =  \App\Models\Rating::select('id','order_id','rating')->where('order_id',$order->id)->where('sender_type',1)->first(); @endphp

        <div class="myOrder-single padding-20 rounded-30 section-bg-1 row gap-1">
            <div class="myOrder-single-item col-12 col-md-6">
                <div class="myOrder-single-flex">
                    <div class="myOrder-single-content">
                        <span class="myOrder-single-content-id">#000{{ $order->id }}</span>
                        <h4 class="myOrder-single-content-title mt-2">
                            @if($order->is_project_job == 'project')
                                <a href="{{ route('freelancer.order.details',$order->id) }}"> {{ $order?->project->title ?? '' }} </a>
                            @elseif($order->is_project_job == 'job')
                                <a href="{{ route('freelancer.order.details',$order->id) }}">{{ $order?->job->title ?? '' }}</a>
                            @else
                                {{ __('Custom order')}}
                            @endif
                        </h4>
                        <div class="myOrder-single-content-btn flex-btn mt-3">
                            <x-order.order-status :status="$order->status" />
                            @if (orderIsDelayed($order)) 
                                <span class="job-delayed">Delayed</span>
                            @endif
                            <x-order.is-custom :isCustom="$order->is_project_job" />
                        </div>
                    </div>
                    <span class="myOrder-single-content-time">{{ $order->created_at->diffForHumans() }} </span>
                </div>
            </div>
            <div class="myOrder-single-item col-md-3 col-12">
                <div class="myOrder-single-block">
                    <div class="myOrder-single-block-item">
                        <div class="myOrder-single-block-item-content">
                            <span class="myOrder-single-block-subtitle">{{ __('Order budget') }}</span>
                            <h6 class="myOrder-single-block-title mt-2">{{ float_amount_with_currency_symbol($order->price) }}
                                <x-order.is-funded :isFunded="$order->payment_status" :paymentGateway="$order->payment_gateway" />
                            </h6>
                        </div>
                    </div>
                    @if($order->delivery_time)
                    <div class="myOrder-single-block-item">
                        <div class="myOrder-single-block-item-content">
                            <span class="myOrder-single-block-subtitle">{{ __('Delivery Time') }}</span> <br>
                            <x-order.deadline :deadline="$order->delivery_time ?? '' " />
                        </div>
                    </div>
                    @endif
                    <div class="myOrder-single-block-item">
                        <div class="myOrder-single-block-item-author">
                            <x-order.profile-image :image="$order?->user->image" />
                        </div>
                        <x-order.name-rating :firstName="$order?->user->first_name" :lastName="$order?->user->last_name" :userId="$order?->user->id" :orderRating="$rating->rating ?? '' " :userType="$order?->user?->user_type" :isIdentityVerified="$order?->user?->user_verified_status" />
                    </div>
                </div>
            </div>
            <div class="myOrder-single-item align-content-center d-flex col-lg-2 col-12">
                <div class="myOrder-single-flex ">

                    <div class="btn-wrapper flex-btn">
                            <a href="{{ route('freelancer.order.details',$order->id) }}" class="btn-profile btn-bg-1">{{ __('View Order') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <x-pagination.laravel-paginate :allData="$orders" />
@endif
