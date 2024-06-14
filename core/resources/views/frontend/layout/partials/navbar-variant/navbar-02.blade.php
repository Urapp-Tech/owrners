<header class="header-style-01">
    <!-- Menu area Starts -->
    <nav class="navbar navbar-area navbar-expand-lg" @if(get_static_option('sticky_menu') == 'enable') id="navigation" @endif>
        <div class="container bg-white nav-container">
            <div class="logo-wrapper">
                <a href="{{ route('homepage') }}" class="logo">
                    @if(!empty(get_static_option('site_logo')))
                        {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                    @else
                        <img src="{{ asset('assets/static/img/logo/logo.png') }}" alt="site-logo">
                    @endif
                </a>
            </div>
            <div class="responsive-mobile-menu d-lg-none">
                <a href="javascript:void(0)" class="click-nav-right-icon">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#xilancer_menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-center" id="xilancer_menu">
                {{-- <ul class="navbar-nav">
                    {!! render_frontend_menu($primary_menu) !!}
                </ul> --}}
                <div class="header-global-search-input d-flex align-items-center header-global-search-input_urapp ">
                    <div class="header-global-search-input-inner">
                        <input type="text" id="search_your_desired_job" class="form-control"
                               placeholder="{{ __('Search') }}" autocomplete="off">
                               <input type="hidden" id="Select_project_or_job_for_search" value="project">
                    </div>
                </div>
                <div class="display_search_result display_search_result_urapp" style="display: none"></div>
            </div>

            <x-frontend.user-menu />

        </div>
    </nav>
    @if(request()->routeIs('homepage'))
        <x-frontend.category.category />
    @endif
    <!-- Menu area end -->
</header>
