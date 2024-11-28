@extends('frontend.layout.master')
@section('site_title') {{ $subcategory->sub_category ?? __('Subcategory Gig') }} @endsection
@section('style')
    <x-select2.select2-css />
    <style>
        .pro-profile-badge {
            position: absolute;
            right: -10px;
            top: -10px;
            border-radius:20px;
            background: #FAF5FF;
            color: #9e4cf4;
            font-weight: 600;
        }
        .pro-icon-background {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #9e4cf4;
            padding: 3px;
            border-radius: 50%;
            color: #fff;
            font-size: 12px;
        }
        .project-category-item .single-project {
            position: relative;
        }
        .disabled-link {
            background-color: #ccc !important;
            pointer-events: none;
            cursor: default;
            border:none;
        }

        .bottom-right-img {
            background-position: 80% 20% !important;=
        }

        @media (max-width:768px) {
            .bottom-right-img {
                opacity: 0.5;
                background-size: 100% !important
            }
        }
    </style>
@endsection
@section('content')
    <main>
        <x-frontend.category.category/>
        <x-breadcrumb.user-profile-breadcrumb :title="$subcategory->sub_category ?? __('Gig Category')" :innerTitle="$subcategory->sub_category ?? '' "/>
        {{-- Sub Category Banner Starts --}}
        <div class="pat-25">
            <div class="container">
                <div class="col-12">
                    <div class="w-100 sub-category-title-container back-right-image-container d-flex" >
                        @php $sub_cat_img = get_attachment_image_by_id($subcategory->image,null,true); @endphp
                        <div class="h-100 w-100 bottom-right-img" @if (!empty($sub_cat_img)) style="background: url('{{  $sub_cat_img['img_url'] }}')" @endif >
                        </div>

                        <div class="d-flex h-100 align-self-center">
    
                            <div class="col-12 align-content-center h-100 gap-4  py-5">
                                <div class="sub-category-title-heading-container">
                                    <h1 class="fw-bold py-2 back-right-image-title">{{ $subcategory->sub_category  }}</h1>
                                </div>
                                <div class="sub-category-content back-right-image-para">
                                    {{$subcategory->short_description}}
                                </div>
                            </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Sub Category Banner Ends --}}
        <!-- Project preview area Starts -->
        <div class="preview-area section-bg-2 pat-50 pab-100">
            <div class="container">
                <div class="row g-4">
                    @if(moduleExists('PromoteFreelancer'))
                        <div class="profile-wrapper-right-flex flex-btn text-right">
                            <span class="profile-wrapper-switch-title">{{ __('Pro Gigs') }}</span>
                            <div class="profile-wrapper-switch-custom display_work_availability">
                                <label class="custom_switch">
                                    <input type="checkbox" id="get_pro_projects" value="0">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <div class="col-12">
                            <div class="shop-icon">
                                <div class="shop-icon-sidebar">
                                    <i class="fas fa-bars"></i>
                                </div>
                            </div>
                            @include('frontend.pages.subcategory-projects.filters')
                            <input type="hidden" id="subcategory_id" value="{{$subcategory->id ?? ''}}">

                        </div>
                        <div class="col-12 mt-5">
                            <div class="shop-contents-wrapper-right search_subcategory_result">
                                @include('frontend.pages.subcategory-projects.search-subcategory-result')
                            </div>
                        </div>
                        {{-- <div class="categoryWrap-wrapper">
                            <div class="shop-contents-wrapper responsive-lg">
                                <div class="shop-icon">
                                    <div class="shop-icon-sidebar">
                                        <i class="fas fa-bars"></i>
                                    </div>
                                </div>

                                @include('frontend.pages.subcategory-projects.sidebar')
                                <div class="shop-contents-wrapper-right search_subcategory_result">
                                    @include('frontend.pages.subcategory-projects.search-subcategory-result')
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Project preview area end -->
    </main>

@endsection

@section('script')
    @include('frontend.pages.subcategory-projects.subcategory-project-filter-js')
    <x-select2.select2-js />
@endsection
