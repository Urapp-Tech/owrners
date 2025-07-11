@extends('frontend.layout.master')
@section('site_title',__('All Report'))
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
    </style>
@endsection

@section('content')
    <main>
        {{-- <x-breadcrumb.user-profile-breadcrumb :title="__('Wallet History')" :innerTitle="__('Wallet History')"/> --}}
        <!-- Profile Settings area Starts -->
        <div class="responsive-overlay"></div>
        <div class="profile-settings-area pat-25 pab-100 section-bg-2">
            <div class="container">
                <div class="row g-4">
                    {{-- @include('frontend.user.layout.partials.sidebar') --}}
                    <div class="col-xl-12 col-lg-12">
                        <div class="profile-settings-wrapper">
                            <div class="single-profile-settings">
                                <div class="single-profile-settings-header">
                                    <div class="single-profile-settings-header-flex">
                                        <x-form.form-title :title="__('All Reports')" :class="'single-profile-settings-header-title'" />
                                    </div>
                                </div>
                                <div class="single-profile-settings-inner profile-border-top">
                                    <div class="custom_table style-06 search_result">
                                        @include('frontend.user.client.report.search-result')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Settings area end -->
    </main>
@endsection
