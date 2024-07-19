@php
    $navbar_variant = !is_null(get_navbar_style()) ? get_navbar_style() : '02';
@endphp

@if (request()->routeIs('freelancer.*') && auth()->guard('web')?->user()?->user_type == 2)
    @include('frontend.layout.partials.navbar-variant.navbar-03')

@else
    @include('frontend.layout.partials.navbar-variant.navbar-'. $navbar_variant)
@endif

