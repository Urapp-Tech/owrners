<?php
    $current_url = url()->current();
    $root_url = url('/');
    $contains = Str::of($current_url)->contains($root_url.'/jobs');
    if($contains == $root_url.'/jobs') {
        //if project disable show job categories as default
        if(get_static_option('project_enable_disable') != 'disable'){
            $jobs_categories = \Modules\Service\Entities\Category::with('category_types.sub_categories')->where('status', '1')->get();
            // $jobs_categories = \Modules\Service\Entities\Category::with('category_types.sub_categories')->where('status', '1')->whereHas('jobs')->get();
        }
        //if project disable show job categories as default end
    }
    else{
        $all_categories = \Modules\Service\Entities\Category::with('category_types.sub_categories')->where('status','1')->get();
        // $all_categories = \Modules\Service\Entities\Category::with('category_types.sub_categories')->where('status','1')->whereHas('projects')->get();
   }
?>

    @if(!empty($jobs_categories))
        <div class="categorySub-area categorySub-padding border-top bg-white">
            <div class="container custom-container-one">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="categorySub">
                            <div class="categorySub-list nav-horizontal-scroll has-arrows" id="categoryWrap-list">
                                <div class="categorySub-arrow" id="left-arrow"></div>
                                <ul class="categorySub-list-slide" id="categoryslide-list">
                                    @foreach($jobs_categories as $category)
                                        <li class="categorySub-list-slide-list">
                                            <a href="{{ route('category.jobs',$category->slug) }}" class="categorySub-list-slide-link">{{ $category->category }}<span class="mobileIcon"></span></a>
                                            <ul class="sub-panel container" >
                                                @foreach($category->category_types as $category_type)
                                                    <ul class="sub-panel-bucket">
                                                        <li class="sub-panel-bucket-title"> {{ $category_type->name }} </li>
                                                        @foreach($category_type->sub_categories as $sub_category)
                                                            <li><a href="{{ route('subcategory.jobs',$sub_category->slug) }}">{{ $sub_category->sub_category }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </ul>
                                            <div class="position-relative">
                                                <span></span>
                                                <span class="join-border"></span>
                                                @if($loop->first)
                                                    <span class="category-border-left"></span>
                                                @else
                                                    <span class="category-curve-left"></span>
                                                @endif
                                                @if(!$loop->last)
                                                    <span class="category-curve-right"></span> 
                                                @else
                                                    <span class="category-border-right"></span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="categorySub-arrow right-arrow" id="right-arrow"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(get_static_option('project_enable_disable') == 'disable')
        {{--if project disable show job categories as default--}}
        @php
            $jobs_categories = \Modules\Service\Entities\Category::with('sub_categories')->where('status', '1')->get();
        @endphp
        @if(!empty($jobs_categories))
            <div class="categorySub-area categorySub-padding border-top bg-white">
                <div class="container custom-container-one">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="categorySub">
                                <div class="categorySub-list nav-horizontal-scroll has-arrows" id="categoryWrap-list">
                                    <div class="categorySub-arrow" id="left-arrow"></div>
                                    <ul class="categorySub-list-slide" id="categoryslide-list">
                                        @foreach($jobs_categories as $category)
                                            <li class="categorySub-list-slide-list">
                                                <a href="{{ route('category.jobs',$category->slug) }}" class="categorySub-list-slide-link">{{ $category->category }}<span class="mobileIcon"></span></a>
                                                <ul class="sub-panel container" >
                                                    @foreach($category->category_types as $category_type)
                                                        <ul class="sub-panel-bucket">
                                                            <li class="sub-panel-bucket-title"> {{ $category_type->name }} </li>
                                                            @foreach($category_type->sub_categories as $sub_category)
                                                                <li><a href="{{ route('subcategory.jobs',$sub_category->slug) }}">{{ $sub_category->sub_category }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endforeach
                                                </ul>
                                                <div class="position-relative">
                                                    <span></span>
                                                    <span class="join-border"></span>
                                                    @if($loop->first)
                                                        <span class="category-border-left"></span>
                                                    @else
                                                        <span class="category-curve-left"></span>
                                                    @endif
                                                    @if(!$loop->last)
                                                        <span class="category-curve-right"></span> 
                                                    @else
                                                        <span class="category-border-right"></span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="categorySub-arrow right-arrow" id="right-arrow"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{--if project disable show job categories as default end --}}
    @else
        @if(!empty($all_categories))
            <div class="categorySub-area categorySub-padding bg-white">
                <div class="container custom-container-one">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="categorySub">
                                <div class="categorySub-list nav-horizontal-scroll has-arrows" id="categoryWrap-list">
                                    <div class="categorySub-arrow" id="left-arrow"></div>
                                    <ul class="categorySub-list-slide" id="categoryslide-list">
                                        @foreach($all_categories as $category)
                                            <li class="categorySub-list-slide-list">
                                                <a href="{{ route('category.projects',$category->slug) }}" class="categorySub-list-slide-link">{{ $category->category }}<span class="mobileIcon"></span></a>
                                                <ul class="sub-panel container" >
                                                    @foreach($category->category_types as $category_type)
                                                        <ul class="sub-panel-bucket">
                                                            <li class="sub-panel-bucket-title"> {{ $category_type->name }} </li>
                                                            @foreach($category_type->sub_categories as $sub_category)
                                                                <li><a href="{{ route('subcategory.projects',$sub_category->slug) }}">{{ $sub_category->sub_category }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endforeach
                                                </ul>
                                                <div class="position-relative">
                                                    <span></span>
                                                    <span class="join-border"></span>
                                                    @if($loop->first)
                                                        <span class="category-border-left"></span>
                                                    @else
                                                        <span class="category-curve-left"></span>
                                                    @endif
                                                    @if(!$loop->last)
                                                        <span class="category-curve-right"></span> 
                                                    @else
                                                        <span class="category-border-right"></span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="categorySub-arrow right-arrow" id="right-arrow"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif



