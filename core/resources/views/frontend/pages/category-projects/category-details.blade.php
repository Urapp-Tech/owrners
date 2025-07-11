@extends('frontend.layout.master')
@section('site_title')
{{ $category->category ?? __('Category Gigs') }}
@endsection
@section('style')
<x-select2.select2-css />
<style>
    .pro-profile-badge {
        position: absolute;
        right: -10px;
        top: -10px;
        border-radius: 20px;
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
        border: none;
    }

    @media (min-width: 300px) and (max-width:768px) {
        .owrners-categories-tabs {
            max-height:400px;
            overflow-y:auto;
            width: 100%;
            flex-direction:row !important
        }

        .project-category-description {
            width: 66.66666667%;
        }

        .categories-list-aside {
            border-right: none !important;
            padding-bottom: 10px;
        } 
    }
    .category-background-img {
            height: 100%;
            position: absolute;
            top: 0;
            right: 0;
            z-index: -1;
        }
        .categories-list-aside {
            border-right: 1px solid var(--border-color-2)
        } 
</style>
@endsection
@section('content')
<main>
    <x-frontend.category.category />
    <x-breadcrumb.user-profile-breadcrumb :title="$category->category ?? __('Gig Category')" :innerTitle="$category->category ?? ''" />
    <!-- Project preview area Starts -->

    <div class="pat-25">
        <div class="container">
            <div class="col-12">
                <div class="w-100 category-title-container back-right-image-container" >
                    @php $cat_img = get_attachment_image_by_id($category->image,null,true); @endphp
                    <div class="h-100 w-100 bottom-right-img" @if (!empty($cat_img)) style="background: url('{{  $cat_img['img_url'] }}')" @endif ></div>

                    <div class="d-flex h-100">

                        <div class="col-xxl-6 col-12 align-content-center h-100 gap-4  py-5">
                            <div class="category-title-heading-container">
                                <h1 class="fw-bold py-2 back-right-image-title">{{ $category->category  }}</h1>
                            </div>
                            <div class="category-content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="preview-area section-bg-2 pat-50 pab-100">
        <div class="container">
            <div class="">
                @if (moduleExists('PromoteFreelancer'))
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
                
                <div class="row">
                    <div class="col-md-4 col-lg-3 categories-list-aside" >
                        <div class="col-md-12 mb-4">
                            <h3 class="fw-bold"> Categories </h2>
                        </div>
                        <div class="nav flex-column nav-pills me-3 owrners-tabs-button owrners-categories-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($category->category_types as $type)
                            <button class="nav-link col-12 @if ($loop->first) active @endif" id="v-pills-{{ $type->id }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $type->id }}" type="button" role="tab" aria-controls="v-pills-{{ $type->id }}" aria-selected="true">{{ $type->name }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9 px-md-5 px-sm-0">
                        <div class="col-md-12 mb-4">
                            <h2 class="fw-bold"> {{ $category->category }} </h2>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach ($category->category_types as $type)
                            <div class="tab-pane fade  @if ($loop->first) show active @endif" id="v-pills-{{ $type->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $type->id }}-tab">
                                <div class="row">
                                    @foreach ($type->sub_categories as $sub)
                                    <div class="col-lg-6 col-md-12 col-12 mb-5">
                                        <div class="project-category-item-urapp">
                                            <a href="{{ route('subcategory.projects', $sub->slug) }}">
                                                <div class="d-flex h-100">

                                                    <div class="col-12 align-content-center h-100 gap-4 px-4 py-3 position-relative">
                                                        <div class="col-md-7 col-sm-12">
                                                            <div class="project-category-title">
                                                                <h3 class="fw-bold py-2">{{ $sub->sub_category }}</h3>
                                                            </div>
                                                            <div class="project-category-description">
                                                                {{ $sub->short_description }}
                                                            </div>
                                                        </div>

                                                        @php $sub_cat_img = get_attachment_image_by_id($sub->image,null,true); @endphp
                                                        <div class="col-5 p-0 category-background-img" >
                                                            <div class="h-100 w-100 sub-cat-image" @if (!empty($sub_cat_img)) style="background: url('{{  $sub_cat_img['img_url'] }}')" @endif >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Project preview area end -->
</main>
@endsection

@section('script')
@include('frontend.pages.category-projects.category-project-filter-js')
<x-select2.select2-js />
@endsection