@extends('frontend.layout.master')
@section('site_title',__('Wallet History'))
@section('style')
    <style>

        .single-profile-settings-flex {
            justify-content: space-between;
        }
        .single-profile-settings-contents .single-profile-settings-contents-upload-btn {
            padding: 0;
        }
        .single-profile-settings .single-profile-settings-thumb {
            max-width: unset;
        }
        .balance-wallet {
            color: var(--paragraph-color);
        }
        .balance-wallet strong {
            color: var(--heading-color);
        }

        .wallet-summary-container {
            padding: 20px;
            border: 1px solid var(--main-color-one);
            border-radius: 10px;
            height: 100%;
        }
        .wallet-summary-subtitle {
            margin-bottom: 10px;
        }

        .wallet-summary-price {
            font-size: 30px;
            margin-top: 20px;
            margin-bottom: 20px;
            font-weight: 600 ;
            color: rgba(16, 16, 24, 1);
        }
        .wallet-summary-container .wallet-summary-desc {
            font-size: 14px !important;
            color: rgb(16, 16, 24, 1, 0.6) !important;
        }

        .btn-deposite {
            color: var(--main-color-one) !important;
        }

        .wallet-summary-title {
            padding-bottom: 15px;
        }
    </style>
@endsection

@section('content')
    <main>
        <x-breadcrumb.user-profile-breadcrumb :title="__('Wallet History')" :innerTitle="__('Wallet History')"/>
        <!-- Profile Settings area Starts -->
        <div class="responsive-overlay"></div>
        <div class="profile-settings-area pat-100 pab-100 section-bg-2">
            <div class="container">
                <div class="row g-4">
                    @include('frontend.user.layout.partials.sidebar')
                    <div class="col-xl-9 col-lg-8">
                        <div class="profile-settings-wrapper">

                            <div class="" id="display_client_profile_photo">
                                <div class="row">
                                    <div class="col-xxl-4">
                                        <h5 class="wallet-summary-title">Available Funds</h5>
                                        <div class="wallet-summary-container">
                                            <h6 class="wallet-summary-subtitle"> Balance available for use</h6>
                                            <h4 class="balance-wallet wallet-summary-price mb-0">
                                                <strong>{{ float_amount_with_currency_symbol($total_wallet_balance ?? 00) }}</strong>
                                            </h4>
                                            <p class="wallet-summary-desc mt-2">{{ __('Earning+Deposit') }}</p>
                                            <div class="single-profile-settings-contents">
                                                <div class="single-profile-settings-contents-upload">
                                                    <div class="">
                                                        <button class="my-2 text-primary bg-transparent btn btn-deposite ps-0" data-bs-toggle="modal" data-bs-target="#paymentGatewayModal">{{ __('Deposit to Wallet') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                @if($total_wallet_balance >= get_static_option('minimum_withdraw_amount'))
                                                <div class="single-profile-settings-contents">
                                                    <div class="single-profile-settings-contents-upload">
                                                        <div class="">
                                                            @if(moduleExists('SecurityManage'))
                                                                @if(Auth::guard('web')->user()->freeze_withdraw == 'freeze')
                                                                    <button type="button" class=" btn-gradient" disabled>
                                                                        <span>
                                                                            {{ __('Withdraw Request') }}
                                                                        </span>
                                                                    </button>
                                                                @else
                                                                    <button class=" btn-gradient" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                                                        <span>
                                                                            {{ __('Withdraw Request') }}
                                                                        </span>
                                                                    </button>
                                                                @endif
                                                            @else
                                                                <button class=" btn-gradient" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                                                    <span>
                                                                        {{ __('Withdraw Request') }}
                                                                    </span>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                               
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xxl-4">
                                        <h5 class="wallet-summary-title">Future Payments</h5>
                                        <div class="wallet-summary-container">
                                            <h6 class="wallet-summary-subtitle"> Payments being cleared</h6>
                                            <h4 class="balance-wallet wallet-summary-price">   <strong> {{ float_amount_with_currency_symbol( $cleared_withdraw) ?? 00 }}   </strong></h4>
                                            <hr class="my-3">
                                            <h6 class="wallet-summary-subtitle"> Payments for active orders</h6>
                                            <h4 class="balance-wallet wallet-summary-price mb-0">   <strong> {{ float_amount_with_currency_symbol( $active_orders) ?? 00 }}   </strong> </h4>

                                        </div>
                                    </div>
                                    <div class="col-xxl-4">
                                        <h5 class="wallet-summary-title">Earnings & Expenses</h5>
                                        <div class="wallet-summary-container">
                                            <h6 class="wallet-summary-subtitle">Earnings this year</h6>
                                            <h4 class="balance-wallet wallet-summary-price">  <strong> {{ float_amount_with_currency_symbol( $year_earnings) ?? 00 }}  </strong></h4>
                                            <hr class="my-3">
                                            <h6 class="wallet-summary-subtitle">Expenses this year</h6>
                                            <h4 class="balance-wallet wallet-summary-price mb-0">  <strong>{{ float_amount_with_currency_symbol( $year_expenses) ?? 00 }}   </strong> </h4>

                                        </div>
                                    </div>
                                </div>
                                <div class="single-profile-settings-flex">

                                    
                                 

                                </div>
                            </div>

                            <div class="single-profile-settings" id="display_client_profile_info">
                                <div class="single-profile-settings-header">
                                    <x-validation.error />
                                    <div class="single-profile-settings-header-flex">
                                        <x-form.form-title :title="__('Wallet History')" :class="'single-profile-settings-header-title'" />
                                        <x-search.search-in-table :id="'string_search'" :placeholder="__('Enter date to search')" />
                                    </div>
                                </div>
                                <div class="single-profile-settings-inner profile-border-top">
                                    <div class="custom_table style-06 search_result">
                                          @include('wallet::freelancer.wallet.search-result')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Settings area end -->
        @include('wallet::freelancer.wallet.withdraw-modal')
        <x-frontend.payment-gateway.gateway-markup :title="__('You can deposit to your wallet from the available payment gateway')"/>
    </main>
@endsection

@section('script')
    @include('wallet::freelancer.wallet.wallet-js')
    <x-frontend.payment-gateway.gateway-select-js />
@endsection
