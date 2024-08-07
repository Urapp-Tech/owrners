@php
    $navbar_variant = !is_null(get_navbar_style()) ? get_navbar_style() : '02';

    $current_url = url()->current();
    $root_url = url('/');
    $contains = Str::of($current_url)->contains($root_url.'/jobs');
@endphp

@if (request()->routeIs('freelancer.*') && auth()->guard('web')?->user()?->user_type == 2 || ($contains == $root_url.'/jobs')  )
    @include('frontend.layout.partials.navbar-variant.navbar-03')

@else
    @include('frontend.layout.partials.navbar-variant.navbar-'. $navbar_variant)
@endif

