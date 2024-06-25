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
           
          

        </div>
    </nav>
    <!-- Menu area end -->
</header>
