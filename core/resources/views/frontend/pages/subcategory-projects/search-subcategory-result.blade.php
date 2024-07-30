<div class="row g-4">
    @php $current_date = \Carbon\Carbon::now()->toDateTimeString() @endphp
    @if($projects->count() > 0)
        @foreach($projects as $project)
        <div class=" col-md-4 col-lg-3">
            <div class="project-category-item radius-10">
                <div class="single-project project-catalogue">
                    <div class="single-project-thumb">
                        <a href="{{ route('project.details', ['username' => $project->project_creator?->username, 'slug' => $project->slug]) }}">
                            <img src="{{ asset('assets/uploads/project/'.$project->image) ?? '' }}" alt="{{ $project->title ?? '' }}">
                        </a>
                        <div class="single-project-thumb-price-container">
                            From <br>
                            <span class="single-project-thumb-price">

                                @if($project->basic_discount_charge)
                                    {{ float_amount_with_currency_symbol($project->basic_discount_charge) }}
                                    <s>{{ float_amount_with_currency_symbol($project->basic_regular_charge) }}</s>
                                @else
                                    {{ float_amount_with_currency_symbol($project->basic_regular_charge) }}
                                @endif
                            </span>
                        </div>
                        <div class="single-project-thumb-bookmark-container">
                            <x-frontend.bookmark :identity="$project->id" :type="'project'" />
                        </div>
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
                            <div>
                                @php
                                    $img =$project->project_creator->image;
                                    if(file_exists('assets/uploads/profile/'.$img)) {
                                        $img = asset('assets/uploads/profile/'.$img);
                                    }
                                    else {
                                        $img = asset('assets/uploads/no-image.png');;
                                    }
                                @endphp
                                <a href="{{ route('freelancer.profile.details', $project->project_creator->username) }}">
                                    <img src="{{  $img  }}"
                                         alt="{{ $project->project_creator->first_name }}" class="gig-user-profile">
                                </a>
                                <span class="project-category-item-bottom-name gig-user-profile-name">
                                    {{ $project->project_creator->first_name }} {{ $project->project_creator->last_name }}
                                </span>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @else
        <div class="col-12">
            <div class="notFoundParent project-category-item radius-10 text-center">
                <div class="notFound-wrapper">
                    <div class="notFoundThumb">
                        <img src="{{ asset('assets/static/img/no-jobs-projects/no-project.svg') }}" alt="">
                    </div>
                    <div class="notFound-contents mt-3">
                        <h4 class="notFoundTitle">{{ __('No Gigs') }}</h4>
                        <p class="notFoundPara mt-3">{{ __("Sorry, We couldn't find any projects in this category try checking on other categories") }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<x-pagination.laravel-paginate :allData="$projects"/>
