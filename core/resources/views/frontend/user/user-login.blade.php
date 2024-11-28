@extends('frontend.layout.auth')
@section('site_title', __('User Login'))
@section('content')
    <!-- login Area Starts -->
    <section class="login-area ">
        <div class="container">
            <div class="row gy-5 align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="login-right">
                        <div class="login-right-item">
                            <div class="login-right-shapes">
                                <div class="login-right-thumb-2">
                                    @if(empty(get_static_option('login_page_sidebar_image')))
                                    <img src="{{ asset('assets/static/single-page/login_page.png') }}" class="object-fit-contain" alt="loginImg">
                                    @else
                                        {!! render_image_markup_by_attachment_id(get_static_option('login_page_sidebar_image')) !!}
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="login-right-contents text-white">
                                <h4 class="login-right-contents-title"> {{ get_static_option('login_page_sidebar_title') ?? __('Login and start discover') }} </h4>
                                <p class="login-right-contents-para">{{ get_static_option('login_page_sidebar_description') ?? __('Once login you will see the magic of xilancer marketplace.') }}</p>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="login-wrapper">
                        <div class="login-wrapper-contents">
                            <h3 class="login-wrapper-contents-title">{{ get_static_option('login_page_title') ?? __('Log In ') }}</h3>
                            <x-validation.error/>
                            <div class="error-message"></div>
                            <form class="login-wrapper-contents-form custom-form" method="post" action="{{ route('user.login') }}">
                                @csrf
                                <div class="single-input mt-3">
                                    <input class="form--control" type="text" name="username" id="username" placeholder="{{ __('Email Or User Name') }}">
                                </div>
                                <div class="single-input mt-3">
                                    <div class="single-input-inner">
                                        <input class="form--control" type="password" name="password" id="password" placeholder="{{ __('Type Password') }}">
                                        <div class="icon toggle-password">
                                            <div class="show-icon"> <i class="fas fa-eye-slash"></i> </div>
                                            <span class="hide-icon"> <i class="fas fa-eye"></i> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-checkbox mt-3">
                                    <div class="checkbox-inline">
                                        <input class="check-input" name="remember"  type="checkbox" id="check15">
                                        <label class="checkbox-label fw-light-bold" for="check15"> {{ __('Keep me logged in') }} </label>
                                    </div>
                                    <div class="forgot-password">
                                        <a href="{{ route('user.forgot.password') }}" class="forgot-btn color-one fw-bold">{{ __('Forgot Password') }} </a>
                                    </div>
                                </div>
                                <button id="signin_form" class="submit-btn w-100 mt-4" type="submit"> {{ get_static_option('login_page_button_title') ?? __('Sign In Now') }} </button>
                            </form>
                            
                            @if(get_static_option('login_page_social_login_enable_disable') == 'on')
                                <div class="login-bottom-contents mt-3">
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
                            <span class="account color-light fw-bold mt-3 text-center w-100">{{ __("Don't have an Owrners account?") }} <a class="color-one" href="{{ route('user.register') }}"> {{ __('Register') }}</a> </span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- login Area end -->
@endsection


{{--todo register script--}}
@section('script')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(document).on('click','#signin_form',function (e){
                    e.preventDefault();
                    let el = $(this);
                    let erContainer = $(".error-message");
                    erContainer.html('');
                    el.text('{{__('Please Wait..')}}');
                    $.ajax({
                        url: "{{route('user.login')}}",
                        type: "POST",
                        data: {
                            username : $('#username').val(),
                            password : $('#password').val(),
                            remember : $('#remember').val(),
                        },
                        error:function(data){
                            var errors = data.responseJSON;
                            erContainer.html('<div class="alert alert-danger"></div>');
                            $.each(errors.errors, function(index,value){
                                erContainer.find('.alert.alert-danger').append('<p>'+value+'</p>');
                            });
                            el.text('{{__('Login')}}');
                        },
                        success:function (data){
                            console.log(data);
                            $('.alert.alert-danger').remove();
                            if (data.status == 'client-login'){
                                el.text('{{__('Redirecting')}}..');
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                let redirectPath = "{{route('client.dashboard')}}";
                                @if(!empty(request()->get('return')))
                                    redirectPath = "{{url('/'.request()->get('return'))}}";
                                @endif
                                    window.location = redirectPath;
                            }else if (data.status == 'freelancer-login'){
                                el.text('{{__('Redirecting')}}..');
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                let redirectPath = "{{route('freelancer.dashboard')}}";

                                @if(!empty(request()->get('return')))
                                    redirectPath = "{{url('/'.request()->get('return'))}}";
                                @endif

                                    window.location = redirectPath;
                            }
                            else{
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                el.text('{{__('Login')}}');
                            }
                        }
                    });
                });
            });
        }(jQuery));
    </script>
@endsection



