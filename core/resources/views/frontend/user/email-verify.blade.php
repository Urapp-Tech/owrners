@extends('frontend.layout.auth')
@section('site_title', __('Email Verify'))
@section('style')
    <style>
        .verify-form input {
            height: 50px;
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

        .verify-form .verify-account {
            border-radius: 5px;
            font-size: 16px;
        }

        body {
            background-image: url('{{'assets/static/img/landescape.png'}}');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        body::before {
            content: '';
            background: linear-gradient(#fff,#fff,#ffffff, #ffffffab, #ffffff59);
            position: fixed;
            top: 0;
            height: 100vh;
            bottom: 0;
            left: 0;
            right: 0;
            display: block;
            z-index: -1;
        }
        .signup-title-main {
            color: var(--main-color-one)
        }

        .signup-title-main, .signup-title {
            font-size: 96px;
            font-weight: 700
        }

        .verify-account-wrapper {
            background: rgb(230 230 250 / 50%);
            box-shadow: 10px 20px 30px;
        }
    </style>
@endsection
@section('content')
    <div class="signup-area pat-100 pab-100">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-12 mx-auto text-center">
                <h3 class="signup-title"> {{ __('Welcome, Client!') }} </h3>
                <h3 class="signup-title-main"> {{ __('Let’s help build your business.') }} </h3>
            </div>
            <div class="signup-wrapper verify-account-wrapper border-0">
                <div class="signup-contents">
                    <x-validation.error />
                    <h6>
                        {{ __('Please check email inbox/spam for verification code') }}
                    </h6>
                    <form class="verify-form" method="post" action="{{ route('email.verify') }}">
                        @csrf
                        <div class="single-input mt-4">
                            <input class="form--control" type="text" name="email_verify_token"
                                placeholder="{{ __('Enter verification code') }}">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">

                            <button class="submit-btn mt-4 verify-account" type="submit">{{ __('Verify Account') }}</button>
                            <div class="resend-verify-code-wrap mt-3">
                                <a class="text-center"
                                    href="{{ route('resend.verify.code') }}"><strong>{{ __('Resend Code') }}</strong></a>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

            </div>
        </div>
    </div>
@endsection
