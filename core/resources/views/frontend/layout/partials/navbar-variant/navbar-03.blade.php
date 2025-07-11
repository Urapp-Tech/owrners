<header class="header-style-01">
    <!-- Menu area Starts -->
    <nav class="navbar navbar-area navbar-expand-lg" @if(get_static_option('sticky_menu') == 'enable') id="navigation" @endif>
        <div class="container bg-white nav-container">
            <div class="logo-wrapper">
                <a href="{{ route('freelancer.dashboard') }}" class="logo">
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
            <div class="collapse navbar-collapse justify-content-left ps-md-4 p-0" id="xilancer_menu">

                <div class="navbar-03-menus">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('freelancer.dashboard') }}"> 
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 10.75H5C2.58 10.75 1.25 9.42 1.25 7V5C1.25 2.58 2.58 1.25 5 1.25H7C9.42 1.25 10.75 2.58 10.75 5V7C10.75 9.42 9.42 10.75 7 10.75ZM5 2.75C3.42 2.75 2.75 3.42 2.75 5V7C2.75 8.58 3.42 9.25 5 9.25H7C8.58 9.25 9.25 8.58 9.25 7V5C9.25 3.42 8.58 2.75 7 2.75H5Z" fill="#667085"/>
                                    <path d="M19 10.75H17C14.58 10.75 13.25 9.42 13.25 7V5C13.25 2.58 14.58 1.25 17 1.25H19C21.42 1.25 22.75 2.58 22.75 5V7C22.75 9.42 21.42 10.75 19 10.75ZM17 2.75C15.42 2.75 14.75 3.42 14.75 5V7C14.75 8.58 15.42 9.25 17 9.25H19C20.58 9.25 21.25 8.58 21.25 7V5C21.25 3.42 20.58 2.75 19 2.75H17Z" fill="#667085"/>
                                    <path d="M19 22.75H17C14.58 22.75 13.25 21.42 13.25 19V17C13.25 14.58 14.58 13.25 17 13.25H19C21.42 13.25 22.75 14.58 22.75 17V19C22.75 21.42 21.42 22.75 19 22.75ZM17 14.75C15.42 14.75 14.75 15.42 14.75 17V19C14.75 20.58 15.42 21.25 17 21.25H19C20.58 21.25 21.25 20.58 21.25 19V17C21.25 15.42 20.58 14.75 19 14.75H17Z" fill="#667085"/>
                                    <path d="M7 22.75H5C2.58 22.75 1.25 21.42 1.25 19V17C1.25 14.58 2.58 13.25 5 13.25H7C9.42 13.25 10.75 14.58 10.75 17V19C10.75 21.42 9.42 22.75 7 22.75ZM5 14.75C3.42 14.75 2.75 15.42 2.75 17V19C2.75 20.58 3.42 21.25 5 21.25H7C8.58 21.25 9.25 20.58 9.25 19V17C9.25 15.42 8.58 14.75 7 14.75H5Z" fill="#667085"/>
                                </svg>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                       
                        <li class="nav-item dropdown freelancer-navbar-dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Business
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="w-100"><a class="dropdown-item" href="{{ route('freelancer.order.all') }}">Orders</a></li>
                            <li class="w-100"><a class="dropdown-item" href="{{ route('freelancer.projects.all') }}">Gigs</a></li>
                            <li class="w-100"><hr class="dropdown-divider"></li>
                            <li class="w-100"><a class="dropdown-item" href="{{ route('jobs.all') }}">Jobs</a></li>
                            <li class="w-100"><a class="dropdown-item" href="{{ route('freelancer.proposal') }}">My Proposals</a></li>
                            <li class="w-100"><hr class="dropdown-divider"></li>
                            <li class="w-100"><a class="dropdown-item" href="{{ route('freelancer.wallet.history') }}">Wallet</a></li>
                            <li class="w-100"><a class="dropdown-item" href="{{ route('freelancer.wallet.withdraw.history') }}">Widthdraw History</a></li>
                          </ul>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('freelancer.analytics.overview') }}" >Analytic</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('freelancer.ticket') }}" >Support</a>
                        </li>
                      </ul>
                </div>
                
            </div>

            <x-frontend.user-menu />

        </div>
    </nav>
    <!-- Menu area end -->
</header>
