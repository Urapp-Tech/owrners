@extends('frontend.layout.master')
@section('site_title',__('Dashboard'))
@section('style')
<x-select2.select2-css/>

    <style>
        .profile-image-container {
            max-width: 60px;
            max-height: 60px;
            overflow: hidden;
            margin: 0;
        }

        .tab-content-item.active {
            background-color: unset
        }

        .myOrder-single-block-title {
            font-size: 14px;
        }
        .myOrder-single-block-subtitle {
            font-size: 12px
        }

        .myOrder_single__block__title {
            font-size: 12px;
        }

        .myOrder-single-block-item:not(:last-child) {
            margin-right: 0px;
        }

        .profile-wrapper-item {
            background-color: var(--section-bg-1);
            padding: 0px;
        }

        .setup-wrapper-experience-details {
            border: 0 !important;
            border-radius: 0px !important;
        }

        .setup-wrapper-experience-details-edit {
            border: 1px solid var(--main-color-one) !important;
        }

        [data-star] {
            text-align:left;
            font-style:normal;
            display:inline-block;
            position: relative;
            unicode-bidi: bidi-override;
        }
        [data-star]::before {
            display:block;
            content: "\f005" "\f005" "\f005" "\f005" "\f005";
            width: 100%;
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 15px;;
            color: var(--body-color);
        }
        [data-star]::after {
            white-space:nowrap;
            position:absolute;
            top:0;
            left:0;
            content: "\f005" "\f005" "\f005" "\f005" "\f005";
            width: 100%;
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 15px;;
            width: 0;
            color: var(--secondary-color);
            overflow:hidden;
            height:100%;
        }

        [data-star^="0.1"]::after{width:2%}
        [data-star^="0.2"]::after{width:4%}
        [data-star^="0.3"]::after{width:6%}
        [data-star^="0.4"]::after{width:8%}
        [data-star^="0.5"]::after{width:10%}
        [data-star^="0.6"]::after{width:12%}
        [data-star^="0.7"]::after{width:14%}
        [data-star^="0.8"]::after{width:16%}
        [data-star^="0.9"]::after{width:18%}
        [data-star^="1"]::after{width:20%}
        [data-star^="1.1"]::after{width:22%}
        [data-star^="1.2"]::after{width:24%}
        [data-star^="1.3"]::after{width:26%}
        [data-star^="1.4"]::after{width:28%}
        [data-star^="1.5"]::after{width:30%}
        [data-star^="1.6"]::after{width:32%}
        [data-star^="1.7"]::after{width:34%}
        [data-star^="1.8"]::after{width:36%}
        [data-star^="1.9"]::after{width:38%}
        [data-star^="2"]::after{width:40%}
        [data-star^="2.1"]::after{width:42%}
        [data-star^="2.2"]::after{width:44%}
        [data-star^="2.3"]::after{width:46%}
        [data-star^="2.4"]::after{width:48%}
        [data-star^="2.5"]::after{width:50%}
        [data-star^="2.6"]::after{width:52%}
        [data-star^="2.7"]::after{width:54%}
        [data-star^="2.8"]::after{width:56%}
        [data-star^="2.9"]::after{width:58%}
        [data-star^="3"]::after{width:60%}
        [data-star^="3.1"]::after{width:62%}
        [data-star^="3.2"]::after{width:64%}
        [data-star^="3.3"]::after{width:66%}
        [data-star^="3.4"]::after{width:68%}
        [data-star^="3.5"]::after{width:70%}
        [data-star^="3.6"]::after{width:72%}
        [data-star^="3.7"]::after{width:74%}
        [data-star^="3.8"]::after{width:76%}
        [data-star^="3.9"]::after{width:78%}
        [data-star^="4"]::after{width:80%}
        [data-star^="4.1"]::after{width:82%}
        [data-star^="4.2"]::after{width:84%}
        [data-star^="4.3"]::after{width:86%}
        [data-star^="4.4"]::after{width:88%}
        [data-star^="4.5"]::after{width:90%}
        [data-star^="4.6"]::after{width:92%}
        [data-star^="4.7"]::after{width:94%}
        [data-star^="4.8"]::after{width:96%}
        [data-star^="4.9"]::after{width:98%}
        [data-star^="5"]::after{width:100%}

    </style>
@endsection

@section('content')
    <main>
        <x-breadcrumb.user-profile-breadcrumb :title="__('Dashboard')" :innerTitle="__('Dashboard')"/>
        <!-- Profile Settings area Starts -->
        <div class="responsive-overlay"></div>
        <div class="profile-settings-area pat-25 pab-100 section-bg-2">
            <div class="container-lg p-sm-4">
                <div class="row g-4">
                    {{-- @include('frontend.user.layout.partials.sidebar') --}}
                    <div class="col-xl-12 col-lg-12">
                        <div class="profile-settings-wrapper row g-4">
                            {{-- Right Side --}}
                            <div class="col-lg-3 col-md-4 p-2">
                                <div class="section-bg-1 radius-10">
                                    {{-- Profile Image Header --}}
                                    <div class="d-flex align-items-center p-3">
                                        <div class="profile-image-container">
                                            @if($user->image)
                                             <img src="{{ asset('assets/uploads/profile/'.$user->image)}}" alt="User Image" class="img-fluid rounded-circle">
                                            @else 
                                             <img src="{{ asset('assets/static/img/author/author.jpg')}}" alt="User Image" class="img-fluid rounded-circle">
                                            @endif
                                        </div>
                                        <div class="align-content-center">
                                            <h6 class="px-2">
                                                {{ $user->first_name.' '.$user->last_name }}
                                            </h6>
                                            <small class="px-2"> {{ $user->username}} </small>
                                        </div>

                                    </div>
                                    {{-- Ratings and details --}}
                                    <hr>
                                    <div class="col-12 px-4 py-4">
                                        <div class="row g-3">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h6 class="text-muted">{{ __('Rating') }}</h6>
                                                <span class="text-success">{!! freelancer_rating_for_profile_details_page($user->id) == ''? 0 : freelancer_rating_for_profile_details_page($user->id)  !!}</span>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <h6 class="text-muted">{{ __('Active Gigs') }}</h6>
                                                <span class="text-primary">{{ $active_projects_count ?? 0 }}</span>
                                            </div>
                                            <div class="col-12  d-flex justify-content-between">
                                                <h6 class="text-muted">{{ __('Active Orders') }}</h6>
                                                <span class="text-info">{{ $active_orders_count ?? __('No Active Orders') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 section-bg-1 radius-10">
                                    <div class="col-12 px-4 py-3">
                                        <div class="row g-3">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h6 class="text-muted">{{ __('Total Earned') }}</h6>
                                                <span class="text-success"> {{ float_amount_with_currency_symbol($total_earning->total_earning ?? 0) }} </span>
                                            </div>
                                           
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-5 section-bg-1 radius-10">
                                    <div class="col-12 px-4 py-3">
                                        <div class="row g-3">
                                            <div class="col-12 d-flex justify-content-between">
                                                <h6 class="text-muted">{{ __('Inbox') }}</h6>
                                                <span class="text-primary"> <a href="{{route('freelancer.live.chat')}}"> View All</a></span>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>

                                {{-- Work Experince --}}
                                <div class="mt-5 section-bg-1 radius-10">
                                    <div class="col-12 px-4 py-3">
                                        @include('frontend.profile-details.experience')
                                    </div>
                                </div>

                                {{-- Education --}}
                                <div class="mt-5 section-bg-1 radius-10">
                                    <div class="col-12 px-4 py-3">
                                        @include('frontend.profile-details.education')
                                    </div>
                                </div>

                                {{-- Education --}}
                                <div class="mt-5 section-bg-1 radius-10">
                                    <div class="col-12 px-4 py-3">
                                        @include('frontend.profile-details.skill')
                                    </div>
                                </div>
                            </div>
                            {{-- left Side --}}
                            <div class="col-lg-9 col-md-8">
                                <div class="">
                                    <div class="orders-listing">
                                        <div class="myOrder-wrapper-tabs">
                                            <div class="tabs section-bg-1 pt-3 radius-10">
                                                <button class="order_sort  btn-profile btn-bg-1" data-val="active">
                                                    {{ __('Active') }} <span>({{ $active_orders }}) </span>
                                                </button>
                                                <button class="order_sort" data-val="cancel">
                                                    {{ __('Cancelled') }} <span>({{ $cancel_orders }}) </span>
                                                </button>
                                                <button class="order_sort" data-val="queue">
                                                    {{ __('In Queue') }} <span> ({{ $queue_orders }}) </span>
                                                </button>
                                                <button class="order_sort" data-val="complete">
                                                    {{ __('Completed') }} <span>({{ $complete_orders }}) </span>
                                                </button>
                                                <button class="order_sort" data-val="all">
                                                    {{ __('All') }} <span> ({{ $all_orders }}) </span>
                                                </button>
                                                
                                            </div>
                                            <div class="myOrder-tab-content">
                                                <div class="tab-content-item active">
                                                    <div class="search_result">
                                                        @include('frontend.user.freelancer.dashboard.dashboard-search-result')
                                                    </div>
                                                </div>
                                            </div>
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
    <x-sweet-alert.sweet-alert2-js />
    <x-select2.select2-js />

    @include('frontend.user.freelancer.dashboard.dashboard-js')

@endsection
