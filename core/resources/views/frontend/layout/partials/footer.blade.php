@php
    $footer_variant = !is_null(get_footer_style()) ? get_footer_style() : '02';
    $footer_variant = '02';
@endphp
@include('frontend.layout.partials.footer-variant.footer-'.$footer_variant)

@if(get_static_option('bottom_to_top') != 'disable')
    <!-- back to top area start -->
    <div class="back-to-top">
        <span class="back-top"> <i class="fas fa-angle-up"></i> </span>
    </div>
    <!-- back to top area end -->
@endif

@if(get_static_option('mouse_pointer') != 'disable')
    <!-- Mouse Cursor start -->
    <div class="mouse-move mouse-outer"></div>
    <div class="mouse-move mouse-inner"></div>
    <!-- Mouse Cursor Ends -->
@endif

<!-- jquery -->
<script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
<!-- jquery Migrate -->
<script src="{{ asset('assets/common/js/jquery-migrate-3.4.0.min.js') }}"></script>
<!-- bootstrap -->
<script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
@if(get_static_option('home_page_animation') != 'disable')
<!-- Wow Js -->
<script src="{{ asset('assets/frontend/js/wow.js') }}"></script>
@endif
<!-- Slick Js -->
<script src="{{ asset('assets/frontend/js/slick.js') }}"></script>
<!-- All Plugin Js -->
<script src="{{ asset('assets/frontend/js/all_plugin.js') }}"></script>
<!-- Magnific popup Js -->
<script src="{{ asset('assets/frontend/js/jquery.magnific-popup.js') }}"></script>
<!-- main js -->
<script src="{{ asset('assets/frontend/js/main.js') }}"></script>
<!-- Toastr js -->
@if(get_static_option('home_page_animation') != 'disable')
    <!-- Wow Js -->
    <script>new WOW().init();</script>
@endif

<script src="{{ asset('assets/common/js/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
<!-- global ajax setup -->
<script> $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'} }) </script>

@if(moduleExists('HourlyJob'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endif

<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            $(document).on('mouseup', function (e) {
                if ($(e.target).closest('.navbar-right-notification').find('.navbar-right-notification-wrapper').length === 0) {
                    $('.navbar-right-notification-wrapper').removeClass('active');
                }
            });
            $(document).on('click', '.navbar-right-notification-icon', function () {
                $('.navbar-right-notification-wrapper').toggleClass('active');
                @php  $user_type =  Auth::guard('web')->check() && Auth::guard('web')->user()->user_type == 2 ? 'freelancer' : 'client'  @endphp
                $.ajax({
                    url:"{{ route($user_type.'.'.'notification.read') }}",
                    method:'POST',
                    success: function(res){
                        if(res.status == 'success'){
                            let status = res.status
                        }
                    }
                });
            });

            $(document).on('click', '.subscription_by_email', function(e){
                e.preventDefault();
                let email = $('#newsletter_subscribe_from_addon input[name="email"]').val();
                let erContainer = $("#newsletter_subscribe_from_addon .error-message");
                erContainer.html('');
                $.ajax({
                    url:"{{ route('newsletter.subscription')}}",
                    data:{email:email},
                    method:'POST',
                    error:function(res){
                        let errors = res.responseJSON;
                        erContainer.html('<div class="alert alert-danger text-start"></div>');
                        $.each(errors.errors, function(index,value){
                            erContainer.find('.alert.alert-danger').append('<p>'+value+'</p>');
                        });
                    },
                    success: function(res){
                        if(res.status=='success'){
                            toastr_success_js("{{ __('Thanks to Subscription Us.') }}")
                            $('input[name="email"]').val('')
                        }
                        if(res.status == 'failed'){
                            erContainer.html('<div class="alert alert-danger">'+res.msg+'</div>');
                        }
                    }

                });
            });
            $(document).on('click', '.subscription_by_email_newsletter', function(e){
                e.preventDefault();
                let email = $('#newsletter_subscribe_from_footer input[name="email"]').val();
                let erContainer = $("#newsletter_subscribe_from_footer .error-message");
                erContainer.html('');
                $.ajax({
                    url:"{{ route('newsletter.subscription')}}",
                    data:{email:email},
                    method:'POST',
                    error:function(res){
                        let errors = res.responseJSON;
                        erContainer.html('<div class="alert alert-danger text-start"></div>');
                        $.each(errors.errors, function(index,value){
                            erContainer.find('.alert.alert-danger').append('<p>'+value+'</p>');
                        });
                    },
                    success: function(res){
                        if(res.status=='success'){
                            toastr_success_js("{{ __('Thanks to Subscription Us.') }}")
                            $('input[name="email"]').val('')
                        }
                        if(res.status == 'failed'){
                            erContainer.html('<div class="alert alert-danger">'+res.msg+'</div>');
                        }
                    }

                });
            });

            //faq question
            $(document).on('click', '.ask_you_question', function(e){
                e.preventDefault();
                let question = $('input[name="question"]').val();
                let erContainer = $("#ask_your_question .error-message");
                erContainer.html('');
                $.ajax({
                    url:"{{ route('faq.question')}}",
                    data:{question:question},
                    method:'POST',
                    error:function(res){
                        let errors = res.responseJSON;
                        erContainer.html('<div class="alert alert-danger text-start"></div>');
                        $.each(errors.errors, function(index,value){
                            erContainer.find('.alert.alert-danger').append('<p>'+value+'</p>');
                        });
                    },
                    success: function(res){
                        if(res.status=='success'){
                            toastr_success_js("{{ __('Thanks to Question Us.') }}")
                            $('input[name="question"]').val('')
                            $("#questionModal").modal('hide');
                        }
                        if(res.status == 'failed'){
                            erContainer.html('<div class="alert alert-danger">'+res.msg+'</div>');
                        }
                    }

                });
            });

            //bookmarks
            $(document).on('click','.click_to_bookmark',function(){
                let identity = $(this).data('identity');
                let route = $(this).data('route');
                let type = $(this).data('type');
                let login = $(this).data('login') ?? '';
                if(login == 'login-please'){
                    toastr_warning_js("{{ __('Please login to bookmark.') }}")
                    return false
                }
                $.ajax({
                    url: route,
                    type: 'post',
                    data: {identity:identity, type:type},
                    success: function(res){
                        if(res.status == 'success'){
                            toastr_success_js("{{ __('Successfully bookmarked.') }}")
                            $(".bookmark_area").load(location.href + ' .bookmark_area');
                        }else{
                            toastr_warning_js("{{ __('Something went wrong.') }}");
                        }
                    }
                });
            });

            //bookmarks remove
            $(document).on('click','.remove_from_bookmark',function(){
                let identity = $(this).data('identity');
                let route = $(this).data('route');
                $.ajax({
                    url: route,
                    type: 'post',
                    data: {identity:identity},
                    success: function(res){
                        $('#current_password_match').show();
                        if(res.status == 'success'){
                            toastr_success_js("{{ __('Successfully remove from bookmarked.') }}")
                            $(".bookmark_area").load(location.href + ' .bookmark_area');
                        }else{
                            toastr_warning_js("{{ __('Something went wrong.') }}");
                        }
                    }
                });
            });


            //job search from home page
            $(document).on('keyup', '#search_your_desired_job',function(){
                let job_search_string = $('#search_your_desired_job').val();
                let search_type = $('#Select_project_or_job_for_search').val();
                $('.display_search_result').hide()

                if(job_search_string.length >= 1){
                    $('.display_search_result').show()
                    $('#header_search_load_spinner').html('<i class="fas fa-spinner fa-pulse"></i>');
                    $.ajax({
                        url:"{{route('home.job.project.search')}}",
                        method:"GET",
                        data:{job_search_string:job_search_string, search_type},
                        success:function(res){
                            $('.display_search_result').html(res);
                            $('#header_search_load_spinner').html('<i class="fas fa-search"></i>');
                        }
                    })
                }else{
                    $('.display_search_result').html('');
                }

            })

            //job search from home page
            $(document).on('keyup', '#search_popular_searches',function(){
                let job_search_string = $('#search_popular_searches').val();
                $('.display_search_result').hide()

                if(job_search_string.length >= 1){
                    $('.display_search_result').show()
                    $('#header_search_load_spinner').html('<i class="fas fa-spinner fa-pulse"></i>');
                    $.ajax({
                        url:"{{route('home.project.keyword.search')}}",
                        method:"GET",
                        data:{search_string:job_search_string},
                        success:function(res){
                            $('.display_search_result').html(res);
                            $('#header_search_load_spinner').html('<i class="fas fa-search"></i>');
                        }
                    })
                }else{
                    $('.display_search_result').html('');
                }

            })

            $('.video_play').magnificPopup({
                type:'iframe',
            });


            //fixed menu js
            if ($('#navigation').length) {
                window.onscroll = function () { myFunction() };

                let navbar = document.getElementById("navigation");
                let sticky = navbar.offsetTop;

                function myFunction() {
                    if (window.pageYOffset >= sticky) {
                        navbar.classList.add("sticky")
                    }
                    if (window.pageYOffset == sticky) {
                        navbar.classList.remove("sticky");
                    }

                }
            }

        });
    }(jQuery));
</script>


<script>

    function slickSliderConfiguration() {
        let global = document.querySelectorAll('.global-slick-init');

        global.forEach(function (element, index){
            let parentBoxWidth = element.clientWidth;
            let childCount = element.querySelectorAll('.category-slider-item, .testimonial-item')?.length ?? 0;
            let childItemWidth = element.querySelector('.category-slider-item, .testimonial-item')?.clientWidth ?? 0;

            if(childCount !== 0 && childItemWidth !== 0){
                if((childCount * childItemWidth) < parentBoxWidth){
                    // now hide the div swipe
                    let targetSwipeDiv = element.parentElement.parentElement.parentElement.querySelector('.testimonial-arrows');
                    targetSwipeDiv.classList.add('d-none');
                    targetSwipeDiv.parentElement.classList.remove('mt-5')
                }
            }
        })
    }
    window.addEventListener('load', slickSliderConfiguration,false);
    window.addEventListener('resize', slickSliderConfiguration,false);
</script>

<script>
    //toastr warning
    function toastr_warning_js(msg){
        Command: toastr["warning"](msg)
        // Command: toastr["warning"](msg, "Warning !")
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
        Command: toastr["success"](msg)
        // Command: toastr["success"](msg, "Success !")
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

    //toastr success notification
    function toastr_notification_success_js(msg){
        Command: toastr["success"](msg)
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

    //toastr error
    function toastr_error_js(msg){
        Command: toastr["error"](msg)
        // Command: toastr["error"](msg, "Error !")
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
<!--page script-->
@yield('script')
@if(!empty( get_static_option('site_third_party_tracking_code')))
    {!! get_static_option('site_third_party_tracking_code') !!}
@endif
{!! renderBodyEndHooks() !!}

{{-- Message notification handler --}}
@auth
    @if (!request()->routeIs('freelancer.live.*') && !request()->routeIs('client.live.*') )

        <x-chat::livechat-js />

    @endif
        <script>
            let page = 1;
            let lastPage = 1;
            let liveChatInstance;
            liveChatInstance = new LiveChat();

            function fetchClientsChat () {
                $.ajax({
                    url: "{{ route('client.chat.contacts') }}",
                    method: 'GET',
                    success: function (response) {
                        if (response.status ==='success') {
                            if($('#clients-chat-dropdown').length  > 0) {
                                $('#clients-chat-dropdown').html(response.view);
                            }
                        }
                    }
                })
            }

            function fetchFreelancerChat () {
                $.ajax({
                    url: "{{ route('freelancer.chat.contacts') }}",
                    method: 'GET',
                    success: function (response) {
                        if (response.status ==='success') {
                            if($('#clients-chat-dropdown').length  > 0) {
                                $('#clients-chat-dropdown').html(response.view);
                            }
                        }
                    }
                })
            }

             function loadMoreNotifications(toast = false) {
                    // Simulate fetching data (replace with actual API call)
                    if (page > lastPage) {
                        return ;
                    }
                    let url = "{{ route('notification.render') }}";
                      $.ajax({
                        url: url,
                        data: {
                            page: page
                        },
                        method: 'GET',
                        success: function (response) {
                            if (response.status === 'success') {
                                lastPage = response.lastPage ;
                                $('#notifications-container').append(response.view);
                                if(response.notifications_unreed_count == 0 ) {

                                    $('.navbar-right-notification .navbar-right-notification-icon').html(`
                                     <i class="fa-regular fa-bell"></i>
                                    `);
                                }
                                else {
                                    $('.navbar-right-notification .navbar-right-notification-icon').html(`
                                        <i class="fa-regular fa-bell"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">${response.notifications_unreed_count.length}</span>
                                    `);
                                }
                                if(toast) {
                                    toastr_notification_success_js("{{ __('New Notification Received.') }}")
                                }
                            }
                        }
                    })  

                    page += 1;  // Increment the page number for the next request
                }

            $(document).ready(function() {
                liveChatInstance.createChatNotificationChannel("{{ auth()->guard('web')->user()->id }}");

                liveChatInstance.bindChatNotificationEvent(`livechat-notification-${'{{ auth()->guard('web')->user()->id }}'}`, function(data) {

                    if (data && data.unseen_count) {
                        $('.reload_unseen_message_count').html(` <i class="fa-regular fa-comment-dots"></i> <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">${data.unseen_count}</span>`);
                    }

                    // if (document.getElementById("chat-alert-sound") != undefined){
                    //     var alert_sound = document.getElementById("chat-alert-sound");
                    //     alert_sound.play();
                    // }

                    @if (auth()->guard('web')->user()->user_type == 1 )
                        fetchClientsChat();
                    @else 
                        fetchFreelancerChat();
                    @endif

                    toastr_notification_success_js("{{ __('New Message Received.') }}")
                })

                liveChatInstance.createNotificationChannel("{{ auth()->guard('web')->user()->id }}");

                liveChatInstance.bindNotificationEvent(`app-notification-${'{{ auth()->guard('web')->user()->id }}'}`, function(data) {
 
                    page= 1;
                    $('#notifications-container').empty();
                    loadMoreNotifications(true);

                })

                const $notificationList = $('.navbar-right-notification-wrapper');
                
                $($notificationList).on('scroll',  function() {
                    const scrollTop = $notificationList.scrollTop();
                    const scrollHeight = $notificationList.prop('scrollHeight');
                    const clientHeight = $notificationList.innerHeight();

                    // Check if the user has scrolled near the end of the notification list
                    if (scrollTop + clientHeight >= scrollHeight - 50) {
                    console.log("Fetching more notifications...");
                     loadMoreNotifications();
                    }
                });


            })
        </script>
@endauth



</body>

</html>
