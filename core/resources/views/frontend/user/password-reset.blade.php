@extends('frontend.layout.auth')
@section('site_title',__('Password Reset'))
@section('style')
    <style>
        .verify-form input{
            height:50px;
            padding-left: 5px;
        }
        button.close {
            width: 30px;
            height: 30px;
            border: none;
            background: #000;
            color: #fff;
            border-radius: 3px;
            float: right;
            font-size: 20px;
        }
        .verify-form .verify-account{
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
@endsection
@section('content')
    <!-- login Area Starts -->
    <section class="login-area pat-100 pab-100">
        <div class="container custom-container-one">
            <div class="row gy-5 align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="login-right py-0">
                        <div class="global-slick-init login-slider nav-style-one dot-style-one white-dot slider-inner-margin" data-appendArrows=".append-jobs" data-dots="true" data-infinite="true" data-slidesToShow="1" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500" data-prevArrow='<div class="prev-icon"><i class="fa-solid fa-arrow-left"></i></div>' data-nextArrow='<div class="next-icon"><i class="fa-solid fa-arrow-right"></i></div>'>
                            <div class="login-right-item">
                                <div class="login-right-shapes">
                                    <div class="login-right-thumb">
                                        @if(empty(get_static_option('register_page_sidebar_image')))
                                            <img src="{{ asset('assets/static/single-page/fr_1.png') }}" alt="loginImg">
                                        @else
                                            {!! render_image_markup_by_attachment_id(get_static_option('register_page_sidebar_image')) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="login-right-contents text-white">
                                    <h4 class="login-right-contents-title signup-role-selection-title"> Enter New Password</h4>
                                </div>
                                @if(get_static_option('login_page_social_login_enable_disable') == 'on')
                                    <div class="login-bottom-contents">
                                        <div class="or-contents mb-3">
                                            <span class="or-contents-para"> {{ __('Or') }} </span>
                                        </div>
                                        <div class="login-others">
                                            <div class="login-others-single">
                                                <a href="{{ route('login.google.redirect') }}" class="login-others-single-btn w-100">
                                                    <i class="fa-brands fa-google"></i>
                                                    <span class="login-para"> {{ __('Sign In With Google') }} </span>
                                                </a>
                                            </div>
                                            <div class="login-others-single">
                                                <a href="{{ route('login.facebook.redirect') }}" class="login-others-single-btn w-100">
                                                    <i class="fa-brands fa-facebook"></i>
                                                    <span class="login-para"> {{ __('Sign In With Facebook') }} </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
    
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="container custom-container-one">
                        <div class="login-wrapper">
                            <div class="login-wrapper-contents margin-inline login-padding">
                                <h6 class="fw-light"> {{ __('Create a new password to login again') }} </h6>
                                <x-validation.error />
                                <form class="login-wrapper-form custom-form" method="post" action="{{ route('user.forgot.password.reset') }}">
                                    @csrf
                                    <div class="single-input mt-4">
                                        <label class="label-title mb-3"> {{ __('New Password') }} </label>
                                        <input class="form--control" name="password" type="text" placeholder="{{ __('Enter new password') }}">
                                    </div>
                                    <div class="single-input mt-4">
                                        <label class="label-title mb-3"> {{ __('Confirm New Password') }} </label>
                                        <input class="form--control" name="confirm_password" type="text" placeholder="{{ __('Confirm new password') }}">
                                    </div>
                                    <button class="submit-btn w-100 mt-4" type="submit"> {{ __('Submit Now') }} </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login Area end -->
@endsection
