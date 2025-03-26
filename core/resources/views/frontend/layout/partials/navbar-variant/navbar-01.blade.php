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
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#xilancer_menu">
                    {{-- <span class="navbar-toggler-icon"></span> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="24px" width="24px" version="1.1" id="Capa_1" viewBox="0 0 488.4 488.4" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M0,203.25c0,112.1,91.2,203.2,203.2,203.2c51.6,0,98.8-19.4,134.7-51.2l129.5,129.5c2.4,2.4,5.5,3.6,8.7,3.6    s6.3-1.2,8.7-3.6c4.8-4.8,4.8-12.5,0-17.3l-129.6-129.5c31.8-35.9,51.2-83,51.2-134.7c0-112.1-91.2-203.2-203.2-203.2    S0,91.15,0,203.25z M381.9,203.25c0,98.5-80.2,178.7-178.7,178.7s-178.7-80.2-178.7-178.7s80.2-178.7,178.7-178.7    S381.9,104.65,381.9,203.25z"/>
                            </g>
                        </g>
                        </svg>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-center" id="xilancer_menu">
                {{-- <ul class="navbar-nav">
                    {!! render_frontend_menu($primary_menu) !!}
                </ul> --}}
                <div class="header-global-search-input d-flex align-items-center header-global-search-input_urapp ">
                    <div class="header-global-search-input-inner">
                        <input type="text" id="search_popular_searches" class="form-control"
                               placeholder="{{ __('Search for the service you are looking for!') }}" value="{{$search_query?? ''}}" autocomplete="off">
                               <input type="hidden" id="Select_project_or_job_for_search" value="project">
                    </div>
                    <div class="display_search_result display_search_result_urapp w-100" style="display: none"></div>
                </div>
            </div>

            <x-frontend.user-menu />
        </div>
    </nav>
    @if(request()->routeIs('homepage'))
        <x-frontend.category.category />
    @endif
    <!-- Menu area end -->
</header>
