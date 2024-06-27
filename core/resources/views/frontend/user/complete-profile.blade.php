@extends('frontend.layout.auth')
@section('site_title', __('Complete Profile'))
@section('content')


<section class="login-area  user_info_area">
    <div class="container">
        <div class="row gy-5 align-items-center justify-content-between">
            <div class="col-lg-6">
                <div class="login-right py-0">
                    <div class="global-slick-init login-slider nav-style-one dot-style-one white-dot slider-inner-margin" data-appendArrows=".append-jobs" data-dots="true" data-infinite="true" data-slidesToShow="1" data-swipeToSlide="true" data-autoplay="true" data-autoplaySpeed="2500" data-prevArrow='<div class="prev-icon"><i class="fa-solid fa-arrow-left"></i></div>' data-nextArrow='<div class="next-icon"><i class="fa-solid fa-arrow-right"></i></div>'>
                    <div class="login-right-item">
                        <div class="login-right-shapes">
                            <div class="login-right-thumb">
                                {{-- @if(empty(get_static_option('register_page_sidebar_image')))
                                    <img src="{{ asset('assets/static/single-page/fr_1.png') }}" alt="loginImg">
                                @else
                                    {!! render_image_markup_by_attachment_id(get_static_option('register_page_sidebar_image')) !!}
                                @endif --}}
                                <img src="{{ asset('assets/static/img/freelancer/complete-profile.png') }}" alt="loginImg">
                            </div>
                        </div>
                        <div class="login-right-contents text-white">
                            {{-- <h4 class="login-right-contents-title signup-role-selection-title"> {{ get_static_option('register_page_sidebar_title') ?? __('Register and start discover') }} </h4> --}}
                            {{-- <p class="login-right-contents-para">{{ get_static_option('register_page_sidebar_description') ?? __('Once register you will see the magic of owrners marketplace.') }}</p> --}}
                            <h4 class="login-right-contents-title signup-role-selection-title"> Complete your Profile </h4>
                            <p class="login-right-contents-para">Tell us more about you so more talents can reach you.</p>
                            
                            <div class="row">
                                <div class="btn-wrapper mt-4 col-3">
                                    <span onclick="window.location.href = '{{ route('freelancer.profile') }}'" class="header-login-btn py-0 d-block align-content-center text-center" style="min-height: 50px">{{ __('Skip') }}</span>
                                </div>
                                <div class="btn-wrapper mt-4 col-4">
                                    <span class="btn-profile btn-bg-1 w-100 continue_to_info submit-btn d-block py-0 align-content-center sign_up_now_button">{{ get_static_option('register_page_continue_button_title') ?? __('Continue') }}</span>
                                </div>
                            </div>
                            <div class="text-muted mt-3 fw-light-bold">
                                <span class="text-sm page-number"> 01</span> /
                                <span class="text-sm total-pages"> 01</span>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="login-wrapper">
                    <div class="login-wrapper-contents">

                        <div class="error-message"></div>

                        <form class="login-wrapper-form custom-form pb-5" method="post" action="{{ route('user.register') }}">
                            @csrf

                            <div id="complete-prfile-image-picker" role="button">
                                <img src="{{ asset('assets/static/img/freelancer/no-profile-image.png') }}" class="complete-profile-upload-image" id="complete-profile-preview" alt="no-image">
                            </div>
                            <input type="file" name="profile_image" id="profile-image" class="d-none">
                            
                            <h6 class="mt-5 mb-4 complete-profile-searchbar-title"> Search skills you would need </h6>

                            <div class="form-group position-relative">
                                <input type="text" class="form-control complete-profile-searchbar-input" placeholder="Search skills you would need">
                                <div class="complete-profile-searchbar-icon">
                                    <img src="{{ asset('assets/static/icons/search-magnifying.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="skills-container" id="search-results">
                                

                            </div>

                            {{-- Selected Skills --}}
                            <div class="profile-complete-selection-container">
                                <h6 class="mt-5 mb-4 complete-profile-searchbar-title"> selected skills</h6>
                                <div class="skills-container" id="selected-skill-container">

                                </div>
                            </div>

                            {{-- Skills Sugesstions --}}
                            <div class="profile-complete-suggestions-container" id="">
                                <h6 class="mt-5 mb-4 complete-profile-searchbar-title"> Suggested</h6>
                                <div class="skills-container" id="suggested-skill-container">

                                </div>
                            </div>


                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- login Area end -->
@endsection


{{-- todo register script --}}
@section('script')
<script type="text/html" id="skill-badge-add-template">

    <div class="skill-badge skill-badge-secondary" data-id="@@id">
        <span>@@name</span>
        <span class="fas fa-add ms-3 add-skill-badge-icon"></span>
    </div>

</script>

<script type="text/html" id="skill-badge-muted-add-template">

    <div class="skill-badge skill-badge-muted" data-id="@@id">
        <span>@@name</span>
        <span class="fas fa-add ms-3 add-skill-badge-icon"></span>
    </div>

</script>

<script type="text/html" id="skill-badge-template">

    <div class="skill-badge skill-badge-main" data-id="@@id">
        <span>@@name</span>
        <span class="fas fa-times ms-3 remove-skill-badge-icon"></span>
    </div>

</script>
<script>
    (function($) {
            "use strict";
            $(document).ready(function() {
                // todo continue
                // $('.user_info_area').hide();
                var selected_skills = [];

                $('.skills-container').on('click', '.add-skill-badge-icon', function(e) {
                    e.preventDefault();
                    let id = $(this).closest('.skill-badge').data('id');
                    let name = $(this).closest('.skill-badge').find('span').text();
                    let already_selected = selected_skills.findIndex(x => x.id == id) > -1;
                    if (!already_selected ) {
                        selected_skills.push({
                            id: id,
                            name: name
                        });
                    }
                    renderSelectedSkill();
                    getSuggestedSkill();
                    $(this).closest('.skill-badge').remove();
                    $('.complete-profile-searchbar-input').trigger('keyup');
                });

                $('.skills-container').on('click', '.remove-skill-badge-icon', function(e) {
                    e.preventDefault();
                    let id = $(this).closest('.skill-badge').data('id');
                    let name = $(this).closest('.skill-badge').find('span').text();
                    let already_selected = selected_skills.findIndex(x => x.id == id);
                    if (already_selected > -1 ) {
                        selected_skills.splice(already_selected, 1);
                    }
                    $('.complete-profile-searchbar-input').trigger('keyup');
                    renderSelectedSkill();
                });

                function renderSelectedSkill() {
                    $('#selected-skill-container').html('');
                    $(selected_skills).each(function(i, e) {
                        let html = $('#skill-badge-template').html().replaceAll('@@name', e.name).replaceAll('@@id',e.id);
                        $('#selected-skill-container').append(html);
                    })
                }

                function getSuggestedSkill () {
                    $.ajax({
                        url: "{{ route('au.skill.suggested') }}",
                        type: 'post',
                        data: {
                            skill_ids: selected_skills.map(x => x.id),
                        },
                        success: function(res) {
                            let response = res;
                            if (response.status== 'success' && response.suggested) {
                                let html = "";
                                $(response.suggested).each(function (i,e) {
                                    let already_selected = selected_skills.findIndex(x => x.id == e.id) > -1;
                                    if (!already_selected) {
                                        html += $('#skill-badge-muted-add-template').html().replaceAll('@@name', e.skill).replaceAll('@@id',e.id);
                                    }
                                })
                                $('#suggested-skill-container').html(html);
                            }
                        }
                    });
                }

                $(document).on('click','#complete-prfile-image-picker', function() {
                    $('#profile-image').click();
                })

                $(document).on('change','#profile-image', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#complete-profile-preview').attr('src', e.target.result).show();
                        }
                        reader.readAsDataURL(file);
                    }
                })

                $(document).on('keyup', '.complete-profile-searchbar-input', function() {
                    let s =  $(this).val();
                    if (s.trim().length == 0) {
                        return;
                    }
                    $.ajax({
                        url: "{{ route('au.skill.all') }}",
                        type: 'post',
                        data: {
                            skill: $(this).val(),
                        },
                        success: function(res) {
                            let response = res;
                            if (response.status== 'success' && response.skills) {
                                let html = "";
                                $(response.skills).each(function (i,e) {
                                    let already_selected = selected_skills.findIndex(x => x.id == e.id) > -1;
                                    if (!already_selected) {
                                        html += $('#skill-badge-add-template').html().replaceAll('@@name', e.skill).replaceAll('@@id',e.id);
                                    }
                                })
                                $('#search-results').html(html);
                            }
                        }
                    });
                });


                //confirm signup
                $(document).on('click', '.sign_up_now_button', function(e) {
                    e.preventDefault()
                    $('#user_register_load_spinner').html('<i class="fas fa-spinner fa-pulse"></i>')

                    var formData = new FormData();
                    formData.append('image', document.querySelector('#profile-image').files[0]);
                    formData.append('skills', selected_skills.map((x, i) => x.name).join(' ,') );

                    let erContainer = $(".error-message");
                    erContainer.html('');

                     $.ajax({
                            url: "{{ route('user.complete-profile') }}",
                            type: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                             error:function(res){
                                 let errors = res.responseJSON;
                                 erContainer.html('<div class="alert alert-danger"></div>');
                                 $.each(errors.errors, function(index,value){
                                     erContainer.find('.alert.alert-danger').append('<p>'+value+'</p>');
                                 });
                                 $('#user_register_load_spinner').html('')
                             },
                             success: function(res) {
                                if(res.status == 'ok') {
                                    window.location.href = "{{ route('freelancer.profile') }}";
                                }
                             }
                     });
                })

            });
        }(jQuery));
</script>
@endsection