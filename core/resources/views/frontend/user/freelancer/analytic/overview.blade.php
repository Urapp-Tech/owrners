@extends('frontend.layout.master')
@section('site_title',__('Analytics Overview'))
@section('style')
<style>
    .analytic-card {
        justify-content: center;
        align-items: center;
        display: flex !important;
        min-height: 140px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--main-color-one);
        padding: 10px;
        margin-bottom: 10px;
    }

    .analytic-card-body {
        text-align: center;
    }

    .analytic-card-body h6 {
        font-size: 16px;
    }

    .analytic-card-body h5 {
        font-size: 20px;
        font-weight: 600;
        margin-top: 10px;
    }
</style>
@endsection
@section('content')
<main>
    <x-breadcrumb.user-profile-breadcrumb :title="__('Analytics Overview')" :innerTitle="__('Analytics Overview')" />
    <!-- Profile Settings area Starts -->
    <div class="responsive-overlay"></div>
    <div class="profile-settings-area pat-100 pab-100 section-bg-2">
        <div class="container">
            <div class="row g-4">
                @include('frontend.user.layout.partials.sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="profile-settings-wrapper section-bg-1 p-3 rounded-30">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="p-4"> Analytics </h3>
                            </div>
                        </div>
                        <div>
                            <div class="myOrder-wrapper-tabs">
                                <div class="tabs">
                                    <button class="order_sort btn-profile btn-bg-1" data-val="overview">
                                        {{ __('Overview') }} <span> </span>
                                    </button>
                                    <button class="order_sort" data-val="business">
                                        {{ __('Repeat Business') }} </span>
                                    </button>
                                    <button class="order_sort" data-val="performance">
                                        {{ __('Gig Performance') }} </span>
                                    </button>
                                    <button class="order_sort" data-val="breakdown">
                                        {{ __('Order Breakdown') }} </span>
                                    </button>
                                </div>
                                <div class="myOrder-tab-content">
                                    {{-- Overview --}}
                                    <div class="tab-content-item active" data-target="overview">
                                        <div id="search-result">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="analytic-card">
                                                            <div class="analytic-card-body">
                                                                <h6>Earnings</h6>
                                                                <h5>
                                                                    {{ float_amount_with_currency_symbol($total_earning ?? 00) }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="analytic-card">
                                                            <div class="analytic-card-body">
                                                                <h6>Avg. selling price</h6>
                                                                <h5>
                                                                    {{ float_amount_with_currency_symbol($avg_selling_price ?? 00) }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="analytic-card">
                                                            <div class="analytic-card-body">
                                                                <h6>Orders Completed</h6>
                                                                <h5>
                                                                    {{ $completed_orders ?? 0 }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="analytic-card">
                                                            <div class="analytic-card-body">
                                                                <h6>Earned in {{now()->format('F')}}</h6>
                                                                <h5>
                                                                    {{ float_amount_with_currency_symbol($current_month_orders ?? 00) }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
        
        
                                                </div>
                                            </div>
                                            {{-- Chart --}}
                                            <div class="col-12 mt-4">
                                                <canvas id="overview-analytics"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Business --}}
                                    <div class="tab-content-item" data-target="business">
                                        <div class="search-result">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="border-primary border radius-10 p-3">
                                                            <div class="col-12 p-3">
                                                                <h6>
                                                                    <small>
                                                                        Repeat buyers
                                                                    </small>
                                                                </h6>
                                                                <h5 class="mt-3 fw-bold">
                                                                    {{ $repeat_buyers_count?? 0 }}
                                                                </h5>
                                                            </div>
                                                            <hr>
                                                            <div class="col-12 p-3">
                                                                <h6>
                                                                    <small>
                                                                        Repeat buyers percentage %
                                                                    </small>
                                                                </h6>
                                                                <h5 class="mt-3 fw-bold">
                                                                    {{ $repeat_buyers_percentage?? 0 }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="border-primary border radius-10 p-3">
                                                            <div class="col-12 p-3">
                                                                <h6>
                                                                    <small>
                                                                        Earning from repeat buyers 
                                                                    </small> 
                                                                </h6>
                                                                <h5 class="mt-3 fw-bold">
                                                                    {{ float_amount_with_currency_symbol( $earning_from_repeat_buyers?? 0 ) }}
                                                                </h5>
                                                            </div>
                                                            <hr>

                                                            <div class="col-12 p-3">
                                                                <h6 ><small> Earning from repeat buyers percentage %</small></h6>
                                                                <h5 class="mt-3 fw-bold">
                                                                    {{ $earning_from_repeat_buyers_percentage?? 0 }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Performance --}}
                                    <div class="tab-content-item" data-target="performance"></div>
                                    {{-- Breakdown --}}
                                    <div class="tab-content-item" data-target="breakdown"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<x-sweet-alert.sweet-alert2-js />
<!-- Chart Js -->
<script src="{{ asset('assets/frontend/js/chart.js') }}"></script>
<script>
    const earning_by_last_year_month_data = @json($earning_by_last_year_month_data);
    const earningsByMonthData = @json($earnings_by_month_data);
    $(document).ready(function () {
        

            $(document).on('click', '.order_sort', function () {
                var val = $(this).data('val');
                $(this).parents('.myOrder-wrapper-tabs').find('.myOrder-tab-content').find('.tab-content-item').removeClass('active');
                $(this).parents('.myOrder-wrapper-tabs').find('.myOrder-tab-content').find('.tab-content-item[data-target="'+ val +'"]').addClass('active');

                $(this).siblings().removeClass('btn-profile btn-bg-1');
                $(this).addClass('btn-profile btn-bg-1');
            })

            const ctx = document.getElementById('overview-analytics').getContext('2d');
            // Create gradient for Dataset 1
            const gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
            gradient1.addColorStop(0, 'rgba(85, 201, 210, 0.4)');
            gradient1.addColorStop(1, 'rgba(85, 201, 210, 0)');

            // Create gradient for Dataset 2
            const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
            gradient2.addColorStop(0, 'rgba(100, 87, 255, 0.4)');
            gradient2.addColorStop(1, 'rgba(100, 87, 255, 0)');

            const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [
                    {
                        label: 'Last Year',
                        data: earning_by_last_year_month_data,
                        borderColor: 'rgba(85, 201, 210, 1)',
                        backgroundColor: gradient1,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'This Year',
                        data: earningsByMonthData,
                        borderColor: 'rgba(100, 87, 255, 1)',
                        backgroundColor: gradient2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Month'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Amount',
                            border: 0,
                        },
                       
                    }
                }
            }
        });
    })

    // todo toastr warning
    function toastr_warning_js(msg){
        Command: toastr["warning"](msg, "Warning !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
    //toastr success
    function toastr_success_js(msg){
        Command: toastr["success"](msg, "Success !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
    //toastr delete
    function toastr_delete_js(msg){
        Command: toastr["error"](msg, "Delete !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>
@endsection