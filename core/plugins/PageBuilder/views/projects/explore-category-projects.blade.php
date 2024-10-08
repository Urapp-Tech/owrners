@if(get_static_option('project_enable_disable') != 'disable')
    <!-- Project area starts -->
    <section class="project-area pat-50 pab-50" data-padding-top="{{$padding_top ?? ''}}" data-padding-bottom="{{$padding_bottom ?? ''}}" style="background-color:{{$section_bg ?? ''}}">
        <div class="container">

            <div class="section-title text-left append-flex">
                <h2 class="subtitle"> {{ $title ?? '' }}</h2>
                <div class="append-project"></div>
            </div>
            <div class="section-title text-left">
                <div class="title">
                    <span>{{ $category->category ?? '' }}</span>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="global-slick-init project-slider nav-style-one slider-inner-margin" data-rtl="{{get_user_lang_direction() == 'rtl' ? 'true' : 'false'}}" data-appendArrows=".append-project" data-arrows="true" data-infinite="true" data-dots="false" data-slidesToShow="4" data-swipeToSlide="true" data-autoplaySpeed="2500" data-prevArrow='<div class="prev-icon"><i class="fa-solid fa-arrow-left"></i></div>'
                         data-nextArrow='<div class="next-icon"><i class="fa-solid fa-arrow-right"></i></div>' data-responsive='[{"breakpoint": 1400,"settings": {"slidesToShow": 4}},{"breakpoint": 1200,"settings": {"slidesToShow": 2}},{"breakpoint": 992,"settings": {"slidesToShow": 2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576, "settings": {"slidesToShow": 1} }]'>
                        @if($items <= 1)
                            @foreach($explore_projects as $project)
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="project-item wow fadeInUp" data-wow-delay=".1s">
                                            <div class="project-category-item radius-10">
                                                <div class="single-project project-catalogue">
                                                    <div class="single-project-thumb">
                                                        <a href="{{ route('project.details', ['username' => $project->project_creator?->username, 'slug' => $project->slug]) }}">
                                                            <img src="{{ asset('assets/uploads/project/'.$project->image) ?? '' }}" alt="{{ $project->title ?? '' }}">
                                                            {{-- <div class="single-project-thumb-price-container">
                                                                From <br>
                                                                <span class="single-project-thumb-price">
                                    
                                                                    @if($project->basic_discount_charge)
                                                                        {{ float_amount_with_currency_symbol($project->basic_discount_charge) }}
                                                                        <s>{{ float_amount_with_currency_symbol($project->basic_regular_charge) }}</s>
                                                                    @else
                                                                        {{ float_amount_with_currency_symbol($project->basic_regular_charge) }}
                                                                    @endif
                                                                </span>
                                                            </div> --}}
                                                        </a>
                                                        {{-- <div class="single-project-thumb-bookmark-container">
                                                            <x-frontend.bookmark :identity="$project->id" :type="'project'" />
                                                        </div> --}}
                                                    </div>
                                                    <div class="single-project-content">
                                                        <div class="single-project-content-top align-items-center flex-between">
                                                            @if(moduleExists('PromoteFreelancer'))
                                                                @if($project->pro_expire_date >= $current_date  && $project->is_pro === 'yes')
                                                                    @if($is_pro == 1)
                                                                        {{--set is_pro value in session and get from project details controller for click count--}}
                                                                        @php Session::put('is_pro',$is_pro) @endphp
                                                                        <div class="single-project-content-review pro-profile-badge">
                                                                            <div class="pro-icon-background">
                                                                                <i class="fas fa-check"></i>
                                                                            </div>
                                                                            <small>{{ __('Pro') }}</small>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <div class="align-items-center d-flex">
                                                                @php
                                                                    $img =$project->project_creator->image;
                                                                    if(file_exists('assets/uploads/profile/'.$img)) {
                                                                        $img = asset('assets/uploads/profile/'.$img);
                                                                    }
                                                                    else {
                                                                        $img = asset('assets/uploads/no-image.png');;
                                                                    }
                                                                @endphp
                                                                <a href="{{ route('freelancer.profile.details', $project->project_creator->username) }}" class="d-flex align-items-center">
                                                                    <img src="{{  $img  }}"
                                                                         alt="{{ $project->project_creator->first_name }}" class="gig-user-profile">
                                                                    <span class="project-category-item-bottom-name gig-user-profile-name">
                                                                        {{ $project->project_creator->first_name }} {{ $project->project_creator->last_name }}
                                                                    </span>
                                                                </a>
                                                                <span class="project-category-item-bottom-location">
                                                                    @if($project->project_creator->location)
                                                                        {{ $project->project_creator->location }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <h5 class="single-project-content-title">
                                                            <a href="{{ route('project.details', ['username' => $project->project_creator?->username, 'slug' => $project->slug]) }}"> {{ $project->title }} </a>
                                                        </h5>
                                                    </div>
                                                   
                                                    <div class="project-category-item-bottom mt-2 w-100">
                                                        <div class="project-category-item-bottom-flex flex-between align-items-center">
                                                            <div class="project-category-right-flex flex-btn">
                                                                {!! project_rating($project->id) !!}
                                                            </div>
                                                            <span class="single-project-thumb-price">
                                    
                                                                @if($project->basic_discount_charge)
                                                                    {{ float_amount_with_currency_symbol($project->basic_discount_charge) }}
                                                                    <s>{{ float_amount_with_currency_symbol($project->basic_regular_charge) }}</s>
                                                                @else
                                                                    {{ float_amount_with_currency_symbol($project->basic_regular_charge) }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach($explore_projects as $project)
                                <div class="project-item wow fadeInUp" data-wow-delay=".1s">
                                    <div class="project-category-item radius-10">
                                        <div class="single-project project-catalogue">
                                            <div class="single-project-thumb">
                                                <a href="{{ route('project.details', ['username' => $project->project_creator?->username, 'slug' => $project->slug]) }}">
                                                    <img src="{{ asset('assets/uploads/project/'.$project->image) ?? '' }}" alt="{{ $project->title ?? '' }}">
                                                    {{-- <div class="single-project-thumb-price-container">
                                                        From <br>
                                                        <span class="single-project-thumb-price">
                            
                                                            @if($project->basic_discount_charge)
                                                                {{ float_amount_with_currency_symbol($project->basic_discount_charge) }}
                                                                <s>{{ float_amount_with_currency_symbol($project->basic_regular_charge) }}</s>
                                                            @else
                                                                {{ float_amount_with_currency_symbol($project->basic_regular_charge) }}
                                                            @endif
                                                        </span>
                                                    </div> --}}
                                                </a>
                                                {{-- <div class="single-project-thumb-bookmark-container">
                                                    <x-frontend.bookmark :identity="$project->id" :type="'project'" />
                                                </div> --}}
                                            </div>
                                            <div class="single-project-content">
                                                <div class="single-project-content-top align-items-center flex-between">
                                                    @if(moduleExists('PromoteFreelancer'))
                                                        @if($project->pro_expire_date >= $current_date  && $project->is_pro === 'yes')
                                                            @if($is_pro == 1)
                                                                {{--set is_pro value in session and get from project details controller for click count--}}
                                                                @php Session::put('is_pro',$is_pro) @endphp
                                                                <div class="single-project-content-review pro-profile-badge">
                                                                    <div class="pro-icon-background">
                                                                        <i class="fas fa-check"></i>
                                                                    </div>
                                                                    <small>{{ __('Pro') }}</small>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="align-items-center d-flex">
                                                        @php
                                                            $img =$project->project_creator->image;
                                                            if(file_exists('assets/uploads/profile/'.$img)) {
                                                                $img = asset('assets/uploads/profile/'.$img);
                                                            }
                                                            else {
                                                                $img = asset('assets/uploads/no-image.png');;
                                                            }
                                                        @endphp
                                                        <a href="{{ route('freelancer.profile.details', $project->project_creator->username) }}" class="d-flex align-items-center">
                                                            <img src="{{  $img  }}"
                                                                 alt="{{ $project->project_creator->first_name }}" class="gig-user-profile">
                                                            <span class="project-category-item-bottom-name gig-user-profile-name">
                                                                {{ $project->project_creator->first_name }} {{ $project->project_creator->last_name }}
                                                            </span>
                                                        </a>
                                                        <span class="project-category-item-bottom-location">
                                                            @if($project->project_creator->location)
                                                                {{ $project->project_creator->location }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <h5 class="single-project-content-title">
                                                    <a href="{{ route('project.details', ['username' => $project->project_creator?->username, 'slug' => $project->slug]) }}"> {{ $project->title }} </a>
                                                </h5>
                                            </div>
                                           
                                            <div class="project-category-item-bottom mt-2 w-100">
                                                <div class="project-category-item-bottom-flex flex-between align-items-center">
                                                    <div class="project-category-right-flex flex-btn">
                                                        {!! project_rating($project->id) !!}
                                                    </div>
                                                    <span class="single-project-thumb-price">
                            
                                                        @if($project->basic_discount_charge)
                                                            {{ float_amount_with_currency_symbol($project->basic_discount_charge) }}
                                                            <s>{{ float_amount_with_currency_symbol($project->basic_regular_charge) }}</s>
                                                        @else
                                                            {{ float_amount_with_currency_symbol($project->basic_regular_charge) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Project area end -->
@endif