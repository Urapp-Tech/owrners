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
    <div class="profile-settings-area pat-25 pab-100 section-bg-2">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-12 col-lg-12">
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
                                    <div class="tab-content-item" data-target="performance">
                                        <div class="form-group">
                                            <h6 for="project_id" class="fw-bold py-3"> Choose your project</h6>
                                            <div class="row">
                                                <div class="col-xl-6">
    
                                                    <select name="project_id" id="project_id" class="form-control outline-selection">
                                                        <option value=""> Select Gig</option>
                                                        @foreach ($projects as $project)
                                                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-3">
                                                    <select name="date" id="date" class="form-control outline-selection">
                                                        
                                                        <option value="30">Last 30 days</option>
                                                        <option value="60">Last 60 days</option>
                                                        <option value="365">This year</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border border-primary p-4 radius-10 mt-4">
                                            <div class="py-3 mb-4">
                                                <h6 class="fw-bold">Gig performance</h6>
                                                <small class="heading-color fw-light">See how your buyers go from views to orders and how you compare with sellers in your category</small>
                                            </div>
    
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <small class="heading-color fw-light">Click through rate</small>
                                                        <h5 id="click_percentage">0.0%</h5>
                                                        
                                                        <div class="mt-4">
                                                            <small class="heading-color fw-light">Clicks</small>
                                                            <h5 id="click_count">0.0</h5>

                                                        </div>
                                                        
                                                        <div class="mt-4">
                                                            <small class="heading-color fw-light">Orders</small>
                                                            <h5 id="order_count">0.0</h5>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-8">
                                                        <canvas id="performance-chart"></canvas>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
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

        // Perfomance Chart
        
        var p_ctx = document.getElementById('performance-chart').getContext('2d');
        var performanceChart = new Chart(p_ctx, {
            type: 'bar',
            data: {
                labels: ['Clicks', 'Orders'],
                datasets: [
                    {
                        label: '',
                        data: [0, 0],
                        backgroundColor: [
                            'rgba(0, 210, 162, 0.5)',
                            'rgba(100, 87, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(0, 210, 162, 1)',
                            'rgba(100, 87, 255, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 10
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: false // Hide the legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        function updateChart(clickCount, orders) {
            performanceChart.data.datasets[0].data = [clickCount, orders];
            performanceChart.update();
        }
        // Gig Seleection

        $(document).on('change','#project_id, #date', function () {
            var project_id = $("#project_id").val();
            var date = $('#date').val();
            $.ajax({
                url: "{{ route('freelancer.analytics.performance') }}",
                type: "GET",
                data: {project_id: project_id, date: date},
                success: function (response) {
                    $('#click_percentage').text(response.click_percentage + '%');
                    $('#click_count').text(response.click_count );
                    let orders = response.orders;
                    $('#order_count').text(orders);

                     // Update the chart
                    updateChart(response.click_count, orders);
                }
            });
        })

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