@include('frontend.layout.partials.header')
@include('frontend.layout.partials.preloader')
@include('frontend.layout.partials.auth-partials.navbar-01')


@yield('content')
@include('frontend.layout.partials.auth-partials.footer')
