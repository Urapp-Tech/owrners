@extends('frontend.layout.master')
@section('site_title',__('Dashboard'))
@section('style')
<style>
    .banner-content {
        position: absolute;
        top: 0;
        height: 100%;
        width: 100%;
    }

    .banner-shapes-bg-2 {
        position: relative;
    }

    .banner-section {
        height: 100%;
        display: flex;
        align-items: flex-end;
        padding: 20px
    }

    .banner-recom {
        background: rgba(255, 255, 255, 0.486);
        backdrop-filter: blur(8px);
        border-radius: 15px
    }

    @media (max-width: 768px) {
        .banner-content {
            display: none;
        }
    }

    .nav-link {
        color: black !important;
    }

    .nav-link:hover {
        color: var(--main-color-one) !important;
    }

    .nav-link.active {
        color: var(--main-color-one) !important;
        background: unset !important;
        border: 1px solid var(--main-color-one) ;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<main>
    {{--
    <x-frontend.category.category /> --}}
    {{--
    <x-breadcrumb.user-profile-breadcrumb :title="__('Dashboard')" :innerTitle="__('Dashboard')" /> --}}
    <!-- Profile Settings area Starts -->
    <div class="responsive-overlay"></div>
    <div class="profile-settings-area pab-100 section-bg-2">
        <div class="container">
            <div class="container banner-area banner-area-three " data-padding-top="16" data-padding-bottom="16">
                <div class="banner-shapes-bg-2">
                    <img src="{{ asset('assets/static/img/dashboard-banner.png') }}" alt="">

                    <div class="banner-content">
                        <div class="row h-100 p-4">
                            <div class="banner-section banner-content-left col-md-6">
                                <div class="w-100 p-3 banner-recom">
                                    <h6 class="fw-bold">Need a Support?</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Place your ticket</h6>
                                        <a class="btn-profile btn-bg-1" href="{{ route('client.ticket') }}">
                                            Place Ticket
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="banner-section banner-content-left col-md-6">
                                <div class="w-100 p-3 banner-recom">
                                    <h6 class="fw-bold">Recommendation</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Complete your Profile</h6>
                                        <a class="btn-profile btn-outline-gray" href="{{ route('client.order.all') }}">
                                            View Orders
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="pat-50">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title text-left append-flex">
                            <h2 class="title"> Explore Our Popular Categories </h2>
                        </div>
                    </div>

                    <div class="col-12 pat-25">

                        <div class="row">
                            <div class="col-md-3 col-lg-2">

                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($popularCategories as $cat)
                                        <button class="nav-link popularCatTabBtn text-start {{ $loop->first ? " active": "" }} " id=" v-pills-{{$cat->id}}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{$cat->id}}" type="button" role="tab" aria-controls="v-pills-{{$cat->id}}" aria-selected="true">{{$cat->category}}</button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-9 col-lg-10">

                                <div class="tab-content" id="v-pills-tabContent">

                                    @foreach ($popularCategories as $cat)
                                    <div class="tab-pane fade {{ $loop->first ? "active show ": "" }}" id="v-pills-{{$cat->id}}" role="tabpanel" aria-labelledby="v-pills-{{$cat->id}}-tab">
                                        <div class="col-12 d-flex justify-content-end my-3">
                                            <div class="append-project-{{$cat->id}} append-project"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="global-slick-init projects-slider-{{$cat->id}} nav-style-one slider-inner-margin" data-rtl="{{get_user_lang_direction() == 'rtl' ? 'true' : 'false'}}" data-appendArrows=".append-project-{{$cat->id}}" data-arrows="true" data-infinite="true" data-dots="false" data-slidesToShow="4" data-swipeToSlide="true" data-autoplaySpeed="2500" data-prevArrow='<div class="prev-icon"><i class="fa-solid fa-arrow-left"></i></div>' data-nextArrow='<div class="next-icon"><i class="fa-solid fa-arrow-right"></i></div>' data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 4}},{"breakpoint": 1200,"settings": {"slidesToShow": 2}},{"breakpoint": 992,"settings": {"slidesToShow": 2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576, "settings": {"slidesToShow": 1} }]'>
                                                @foreach ($cat->projects as $project)
                                                    <x-project.card :project="$project" />
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
            $(document).on('click','.popularCatTabBtn', function() {
                setTimeout(() => {
                    
                    $($(this).attr('data-bs-target')).find('.global-slick-init').slick('refresh');
                });
            })
        
        });
</script>
@endsection