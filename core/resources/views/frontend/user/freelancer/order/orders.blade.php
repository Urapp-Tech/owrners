@extends('frontend.layout.master')
@section('site_title', __('My Orders'))
@section('style')
 <style>
    .tab-content-item.active, .tab-content-item-two.active, .tab-content-item-three.active, .tab-content-item-four.active {
        background-color: var(--section-bg-2)
    }

    #sorting-heading {
        font-size: 20px;
        font-weight: 600;
    }
    .complete-profile-searchbar-icon {
        top: 5px !important;
    }
 </style>
@endsection
@section('content')
    <main>
        {{-- <x-frontend.category.category /> --}}
        <x-breadcrumb.user-profile-breadcrumb :title="__('My Orders')" :innerTitle="__('My Orders')" />
        <!-- Profile Details area Starts --> 
        <div class="profile-area pat-50 pab-100 section-bg-2">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="@if(get_static_option('job_enable_disable') != 'disable') col-xl-8 col-lg-8 @else col-12 @endif">
                        <div class="shop-contents-wrapper-right">
                            <div class="myOrder-wrapper">
                                <div class="myOrder-wrapper-tabs">
                                    <div class="tabs">
                                        @include('frontend.user.freelancer.order.order-count')
                                    </div>
                                    <div class="myOrder-tab-content">
                                        <div class="tab-content-item active">
                                            {{-- FILTERS CONTAINER --}}
                                            <div class="orders-action-container my-3 d-flex justify-content-between ">
                                                <div class="align-self-start">
                                                    <h3 id="sorting-heading"> Priority Orders </h3>
                                                </div>
                                                <div class=" filters-select">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle px-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                          Sort By
                                                          <i class="fas fa-chevron-down ms-2"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                          <li><a class="dropdown-item" onclick="setSortBy('priority')" href="#">Priority Orders</a></li>
                                                          <li><a class="dropdown-item" onclick="setSortBy('latest')" href="#">Latest Orders</a></li>
                                                          <li><a class="dropdown-item" onclick="setSortBy('budget')" href="#">High Budget</a></li>
                                                        </ul>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="search_result">
                                                @include('frontend.user.freelancer.order.search-result')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(get_static_option('job_enable_disable') != 'disable')
                    <div class="col-xl-4 col-lg-4">
                        <div class="profile-details-widget sticky_top">
                            <div class="file-wrapper-item-flex flex-between align-items-center profile-border-bottom">
                                <h4 class="profile-wrapper-item-title"> {{__('Available Jobs')}} </h4>
                                <a href="{{route('jobs.all')}}" class="profile-wrapper-item-browse-btn"> {{__('Browse All')}} </a>
                            </div>
                            @if($jobs->count()>0)
                            @foreach ($jobs as $job)
                                <div class="single-jobs border-0 radius-10 bg-white mt-4">
                                        <h4 class="single-jobs-title"> <a
                                                    href="{{ route('job.details', ['username' => $job->job_creator?->username, 'slug' => $job->slug]) }}">
                                                {{ $job->title }} </a> </h4>
                                        <p class="single-jobs-date">
                                            {{ $job->created_at->toFormattedDateString() ?? '' }} -
                                            <span>{{ ucfirst($job->level) ?? '' }}</span>
                                        </p>

                                        <h3 class="single-jobs-price">
                                            {{ float_amount_with_currency_symbol($job->budget) }}
                                            <span class="single-jobs-price-fixed">{{ ucfirst($job->type) }}</span>
                                        </h3>
                                        <div class="single-jobs-tag mt-4">
                                            @foreach ($job->job_skills as $skill)
                                                <a href="{{ route('skill.jobs', $skill->skill) }}" class="single-jobs-tag-link">
                                                    {{ $skill->skill ?? '' }} </a>
                                            @endforeach
                                        </div>
                                    </div>
                            @endforeach
                            @else
                                <h6 class="profile-wrapper-item-title">{{__('No Jobs Found')}}</h6>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Profile Details area end -->

    </main>
@endsection

@section('script')
    <x-sweet-alert.sweet-alert2-js />
    @include('frontend.user.freelancer.order.order-js')
@endsection
