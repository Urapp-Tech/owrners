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
    .dashboard-banner {
      border-radius: 30px  
    }

    .dashboard-banner-title {
        font-size: 35px;
        font-weight: 700;
    }

    .myJob-wrapper-single-balance {
        min-height: 190px;
        margin-top: 10px;
    }
    .contract_single__balance-price {
        font-size: 30px !important;
        font-weight: 700 !important;
    }

    .myJob-wrapper-single-balance {
        border-radius: 30px;
    }
    </style>
@endsection

@section('content')
    <main>
        <x-breadcrumb.user-profile-breadcrumb :title="__('Dashboard')" :innerTitle="__('Dashboard')"/>
        <!-- Profile Settings area Starts -->
        <div class="responsive-overlay"></div>
        <div class="profile-settings-area pat-100 pab-100 section-bg-2">
            <div class="container">
                <div class="row g-4">
                    {{-- @include('frontend.user.layout.partials.sidebar') --}}
                    <div class="col-xl-12 col-lg-12">
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
                            <div class="col-11 col-xxl-12 section-bg-1 p-4 dashboard-banner mx-auto mx-sm-0" >
                                <div class="row">
                                    <div class="col-12 col-xxl-6">
                                        <img src="{{ asset('assets/static/img/freelancer/dashboard-banner.png') }}" alt="" height="215">
                                    </div>
                                    <div class="col-12 col-xxl-6 align-content-center pt-5 pt-md-0">
                                        <h1 class="dashboard-banner-title">Boost Your Sales with Exclusive Discounts!</h1>
                                        <a href="{{ route('freelancer.project.create') }}" class="btn-outline-owrners mt-3">
                                            Create a Gig
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="single-profile-settings col-12">
                                <div class="single-profile-settings-inner">
                                    <div class="row">

                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <div class="myJob-wrapper-single-balance total_balance">
                                                <div class="myJob-wrapper-single-balance-contents">
                                                    <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                        <h4 class="contract_single__balance-price">{{ float_amount_with_currency_symbol($total_wallet_balance) ?? 0.0 }}</h4>
                                                    </div>
                                                    <p class="myJob-wrapper-single-balance-para">{{ __('Wallet Balance') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        @if(get_static_option('project_enable_disable') != 'disable')
                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <a href="{{ route('freelancer.projects.all', Auth::guard('web')->user()->username) }}">
                                                <div class="myJob-wrapper-single-balance">
                                                    <div class="myJob-wrapper-single-balance-contents">
                                                        <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                            <h4 class="contract_single__balance-price">{{ $total_project ?? 0 }}</h4>
                                                        </div>
                                                        <p class="myJob-wrapper-single-balance-para">{{ __('Total Projects') }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                       @endif
                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <div class="myJob-wrapper-single-balance">
                                                <div class="myJob-wrapper-single-balance-contents">
                                                    <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                        <h4 class="contract_single__balance-price">{{ $complete_order ?? 0 }}</h4>
                                                    </div>
                                                    <p class="myJob-wrapper-single-balance-para">{{ __('Complete Order') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-lg-6 col-sm-6 col-md-4">
                                            <div class="myJob-wrapper-single-balance">
                                                <div class="myJob-wrapper-single-balance-contents">
                                                    <div class="myJob-wrapper-single-balance-price d-flex gap-2 justify-content-between">
                                                        <h4 class="contract_single__balance-price">{{ $active_order ?? 0 }}</h4>
                                                    </div>
                                                    <p class="myJob-wrapper-single-balance-para">{{ __('Active Order') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{--my projects--}}
                            @if(get_static_option('project_enable_disable') != 'disable')
                                <div class="single-profile-settings col-xxl-5">
                                    <div class="section-bg-1 rounded-30 pt-3">
                                        <div class="single-profile-settings-header px-3 mt-2">
                                            <div class="single-profile-settings-header-flex">
                                                <x-form.form-title :title="__('Latest Projects')" :class="'single-profile-settings-header-title'" />
                                                <a href="{{ route('freelancer.profile.details', Auth::guard('web')->user()->username) }}" class="btn-profile btn-bg-1"> {{ __('All Projects') }} </a>
                                            </div>
                                        </div>
                                        <div class="single-profile-settings-inner ">
                                            <div class="custom_table style-06">
                                                <table>
                                                    <thead>
                                                    <tr>
                                                        <th>{{ __('Title') }}</th>
                                                        <th>{{ __('Action') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($my_projects as $project)
                                                        <tr>
                                                            <td>{{ $project->title }}</td>
                                                            <td>
                                                                <a href="{{ route('freelancer.project.edit',$project->id) }}" class="btn-profile btn-bg-1 edit_info_show_hide"> {{ __('Edit Project') }} </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{--//latest orders--}}
                            <div class="single-profile-settings col section-bg-1">
                                <div class="section-bg-1 rounded-30 pt-3">
                                    <div class="single-profile-settings-header px-3 mt-2">
                                        <div class="single-profile-settings-header-flex">
                                            <x-form.form-title :title="__('Latest Orders')" :class="'single-profile-settings-header-title'" />
                                            <a href="{{ route('freelancer.order.all') }}" class="btn-profile btn-bg-1"> {{ __('All Orders') }} </a>
                                        </div>
                                    </div>
                                    <div class="single-profile-settings-inner">
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
                                                        <td>{{ __($order->payment_status) ?? '' }}</td>
                                                        <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                                        <td><a href="{{ route('freelancer.order.details',$order->id) }}" class="btn-profile btn-bg-1">{{ __('Order Details') }}</a></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
