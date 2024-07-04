@extends('frontend.layout.master')
@section('site_title',__('Dashboard'))
@section('style')
    <style>
     .total_balance{background-color:var(--section-bg-1) !important;}

     .greeting-sun {
     height: 100px;
     width: 100px;
     display: block;
     background-image:   linear-gradient(rgba(254, 198, 50, 1), rgb(255, 223, 135));
     border-radius: 50%;
    }
    </style>
@endsection

@section('content')
    <main>
        <x-frontend.category.category />
        <x-breadcrumb.user-profile-breadcrumb :title="__('Dashboard')" :innerTitle="__('Dashboard')"/>
        <!-- Profile Settings area Starts -->
        <div class="responsive-overlay"></div>
        <div class="profile-settings-area pat-100 pab-100 section-bg-2">
            <div class="container">
                <div class="row g-4">
                    @include('frontend.user.layout.partials.sidebar')
                    <div class="col-xl-9 col-lg-8">
                        <div class="profile-settings-wrapper row">
                            <div class="col-12 col-xxl-12 ">
                                <div class="d-flex">
                                    <div class="p-3">
                                        <div class="greeting-sun"></div>
                                    </div>
                                    <div class="align-self-center">
                                        <h4 class="fw-bold">  <span id="greetings-heading"></span></h4>
                                        <h3 class="fw-bold">{{auth()->guard('web')->user()->first_name}} {{auth()->guard('web')->user()->last_name}}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="single-profile-settings col-12 col-xxl-12">
                              
                                <div class="single-profile-settings-inner ">
                                    <div class="row">

                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <div class="myJob-wrapper-single-balance total_balance">
                                                <div class="myJob-wrapper-single-balance-contents">
                                                    <p class="myJob-wrapper-single-balance-para">{{ __('Wallet Balance') }}</p>
                                                    <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                        <h4 class="contract_single__balance-price">{{ float_amount_with_currency_symbol($total_wallet_balance) ?? 0.0 }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <div class="myJob-wrapper-single-balance">
                                                <div class="myJob-wrapper-single-balance-contents">
                                                    <p class="myJob-wrapper-single-balance-para">{{ __('Total Orders') }}</p>

                                                    <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                        <h4 class="contract_single__balance-price">{{ $total_orders ?? 0 }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <div class="myJob-wrapper-single-balance">
                                                <div class="myJob-wrapper-single-balance-contents">
                                                    <p class="myJob-wrapper-single-balance-para">{{ __('Complete Order') }}</p>
                                                    <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                        <h4 class="contract_single__balance-price">{{ $complete_order ?? 0 }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <div class="myJob-wrapper-single-balance">
                                                <div class="myJob-wrapper-single-balance-contents">
                                                    <p class="myJob-wrapper-single-balance-para">{{ __('Active Order') }}</p>

                                                    <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                        <h4 class="contract_single__balance-price">{{ $active_order ?? 0 }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{--my projects--}}
                            <div class="single-profile-settings">
                                <div class="single-profile-settings-header">
                                    <div class="single-profile-settings-header-flex pb-2">
                                        <x-form.form-title :title="__('Latest Orders')" :class="'single-profile-settings-header-title'" />
                                        <a href="{{ route('client.order.all') }}" class="btn-profile btn-bg-1"> {{ __('All Orders') }} </a>
                                    </div>
                                    <x-notice.general-notice :description="__('Notice: The admin has the ability to update the payment status for transactions that are pending.')" />
                                </div>
                                <div class="single-profile-settings-inner profile-border-top">
                                    <div class="custom_table style-06">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>{{ __('Budget') }}</th>
                                                <th>{{ __('Delivery Time') }}</th>
                                                <th>{{ __('Payment Status') }}</th>
                                                <th>{{ __('Create Date') }}</th>
                                                <th>{{ __('Order Details') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($latest_orders as $order)
                                                <tr>
                                                    <td>{{ float_amount_with_currency_symbol($order->price) ?? '' }}</td>
                                                    <td>{{ __($order->delivery_time) ?? '' }}</td>
                                                    <td>
                                                        @if($order->payment_gateway != 'manual_payment' && $order->payment_status == 'pending')
                                                            <span class="btn btn-danger btn-sm">{{ __('Payment Failed') }}</span>
                                                        @elseif($order->payment_status == 'pending')
                                                            <span class="btn btn-warning btn-sm">{{ ucfirst(__($order->payment_status)) }}</span>
                                                        @else
                                                            <span class="btn btn-success btn-sm">{{ ucfirst(__($order->payment_status)) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                                    <td><a href="{{ route('client.order.details',$order->id) }}" class="btn-profile btn-bg-1">{{ __('Order Details') }}</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{--my projects--}}
                            @if(get_static_option('job_enable_disable') != 'disable')
                                <div class="single-profile-settings">
                                    <div class="single-profile-settings-header">
                                        <div class="single-profile-settings-header-flex">
                                            <x-form.form-title :title="__('Latest Jobs')" :class="'single-profile-settings-header-title'" />
                                            <a href="{{ route('client.job.all') }}" class="btn-profile btn-bg-1"> {{ __('All Jobs') }} </a>
                                        </div>
                                    </div>
                                    <div class="single-profile-settings-inner profile-border-top">
                                        <div class="custom_table style-06">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>{{ __('Title') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($my_jobs as $job)
                                                    <tr>
                                                        <td>{{ $job->title }}</td>
                                                        <td>
                                                            <a href="{{ route('client.job.edit',$job->id) }}" class="btn-profile btn-bg-1 edit_info_show_hide"> {{ __('Edit Job') }} </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Settings area end -->
    </main>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            
            var today = new Date()
            var curHr = today.getHours()
            var  msg =" "; 
            if (curHr < 12) {
                msg=  "Good Morning";
            } else if (curHr >= 12 && curHr <= 17) {
                msg=  "Good Afternoon";
            } else if (curHr >= 17 && curHr <= 24) {
                msg=  "Good Evening";
            }
            else {
                msg=  "Good Night";  // this block will run if the current hour is between 24:00 and 00:00 (midnight)
            }
            $('#greetings-heading').text(msg);
        });
    </script>
@endsection
