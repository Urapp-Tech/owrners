@if(get_static_option('project_enable_disable') != 'disable')
<!-- Category area starts -->
<section class="category-area pat-50 pab-50" data-padding-top="{{$padding_top ?? ''}}" data-padding-bottom="{{$padding_bottom ?? ''}}" style="background-color:{{$section_bg ?? ''}}">
    <div class="container">
        <div class="section-title-category-two ">
            <h2 class="title"> {{ $title ?? __('Browse Projects By Categories') }} </h2>
        </div>
        <div class="row gy-4 mt-4">
            <div class="col-lg-12">
                <div class="global-slick-init nav-style-one slider-inner-margin" data-rtl="{{get_user_lang_direction() == 'rtl' ? 'true' : 'false'}}" data-appendArrows=".append-projectCategory" data-slidesToShow="4" data-infinite="true" data-arrows="true" data-dots="false" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500" data-prevArrow='<div class="prev-icon"><i class="fas fa-arrow-left"></i></div>'
                     data-nextArrow='<div class="next-icon"><i class="fas fa-arrow-right"></i></div>' data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 4}},{"breakpoint": 1200,"settings": {"slidesToShow": 4}},{"breakpoint": 992,"settings": {"slidesToShow": 3}},{"breakpoint": 768,"settings": {"slidesToShow": 2}},{"breakpoint": 480, "settings": {"slidesToShow": 1} }]'>
                    @if($items <= 1)
                        @foreach($project_categories as $category)
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="category-slider-item-three">
                                        @php $cat_img = get_attachment_image_by_id($category->image,null,true); @endphp
                                        <div class="category-slider-item-three-image" @if (!empty($cat_img)) style="background: url('{{  $cat_img['img_url'] }}')" @endif ></div>
                                        <a href="{{ route('category.projects',$category->slug) }}">
                                            <div class="d-flex h-100">

                                                <div class="col-12 h-100 gap-4 px-4 py-3  category-slider-item-three-container">
                                                    <div class="project-category-title">
                                                        <h3 class="fw-bold py-2">{{ $category->category }}</h3>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            {{-- <div class="single-category center-text radius-20">
                                                <div class="single-category-icon">
                                                    {!! render_image_markup_by_attachment_id($category->image) !!}
                                                </div>
                                                <div class="single-category-contents">
                                                    <h5 class="single-category-contents-title"> {{ $category->category ?? '' }} </h5>
                                                    <span class="single-category-contents-subtitle"> {{ $category->projects_count ?? '' }} {{ __('Projects') }} </span>
                                                </div>
                                            </div> --}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach($project_categories as $category)
                            <div class="category-slider-item-three">
                                @php $cat_img = get_attachment_image_by_id($category->image,null,true); @endphp
                                <div class=" category-slider-item-three-image" @if (!empty($cat_img)) style="background: url('{{  $cat_img['img_url'] }}')" @endif ></div>
                                <a href="{{ route('category.projects',$category->slug) }}">

                                    <div class="d-flex h-100">

                                        <div class="col-12 h-100 gap-4 px-4 py-3 category-slider-item-three-container">
                                            <div class="project-category-title">
                                                <h3 class="fw-bold py-2">{{ $category->category }}</h3>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    {{-- <div class="single-category center-text radius-20">
                                        <div class="single-category-icon">
                                            {!! render_image_markup_by_attachment_id($category->image) !!}
                                        </div>
                                        <div class="single-category-contents">
                                            <h5 class="single-category-contents-title"> {{ $category->category ?? '' }} </h5>
                                            <span class="single-category-contents-subtitle"> {{ $category->projects_count ?? '' }} {{ __('Projects') }} </span>
                                        </div>
                                    </div> --}}
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        {{-- @if($project_categories->count() > 0)
        <div class="row mt-5 appendSliderWrapper">
            <div class="testimonial-arrows center-text">
                <div class="append-projectCategory"> <span> {{ $slider_button_text ?? __('Swipe') }} </span> </div>
            </div>
        </div>
        @endif --}}
    </div>
</section>
<!-- Category area end -->
@endif