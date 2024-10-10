<script>
    (function($){
        "use strict";
        $(document).ready(function(){

            $('.order_sort[data-val=active]').trigger("click");


            //order sort
            $(document).on('click','.order_sort',function(e){
                e.preventDefault();
                let order_type = $(this).data('val');
                // let sort_by = $('#sort_by_value').val();
                let search = $('#search-order-input').val();
                $(this).addClass('btn-profile btn-bg-1');
                $(this).siblings().removeClass('btn-profile btn-bg-1');
                $('#set_order_type_value').val(order_type);

                $.ajax({
                    url:"{{ route('freelancer.dashboard.order')}}",
                    data:{order_type:order_type, search: search},
                    success:function(res){
                        $('.search_result').html(res);
                    }
                });

            });

            //paginate
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                let order_type = $('#set_order_type_value').val();
                $.ajax({
                    url:"{{ route('freelancer.dashboard.order').'?page='}}" + page,
                    data:{order_type:order_type},
                    success:function(res){
                        $('.search_result').html(res);
                    }
                });
            });

            @if($user && auth()->guard('web')->user() && $user->id == auth()->guard('web')->user()->id)


            //choose skill
            const myTagInput = new TagsInputs({
                selector: 'skill_input',
                duplicate: false,
                max: 30,
            });

            @php
                $array_skill = explode(",",$skills);
                $array_length =  count($array_skill);
            @endphp

            @for($i = 0; $i<=($array_length-1); $i ++ )
            myTagInput.addData(["{{$array_skill[$i]}}"]);
            @endfor

            $(document).on('click','.choose_skill',function (){
                let skill = $(this).text();
                myTagInput.addData([skill]);
            });

            //update skill
            $('.edit_skill_wrapper').hide();
            $(document).on('click','.display_edit_skill_wrapper',function(){
                $('.edit_skill_wrapper').show();
                $('.freelancer_skill_list').hide();
            });
            $(document).on('click','.update_freelancer_skill',function(){
                let skill = $('#skill_input').val();
                $.ajax({
                    url: "{{ route('freelancer.account.skill.add') }}",
                    type: 'post',
                    data: {skill: skill},
                    success: function(res){
                        if(res.status == 'ok'){
                            toastr_success_js("{{ __('Skill Successfully Updated') }}");
                            $('.edit_skill_wrapper').hide();
                            $('.freelancer_skill_list').show();
                            $('.freelancer_skill_list').load(location.href + ' .freelancer_skill_list');
                        }
                    }
                });
            });

            @endif

            // todo add education
            $(document).on('click','.add_education',function(){
                let institution = $('#institution').val();
                let degree = $('#degree').val();
                let subject = $('#subject').val();
                let start_date = $('#start_date_edu').val();
                let end_date = $('#end_date_edu').val();
                if(institution == '' || degree == '' || subject == '' || start_date == '' || end_date == ''){
                    toastr_warning_js("{{ __('Please fill all fields !') }}");
                    return false;
                }else{
                    $.ajax({
                        url: "{{ route('freelancer.account.education.add') }}",
                        type: 'post',
                        data: {
                            institution: institution,
                            degree:degree,
                            subject:subject,
                            start_date:start_date,
                            end_date:end_date,
                        },
                        success: function(res){
                            if(res.status == 'ok'){
                                $('.popup-fixed, .popup-overlay').removeClass('popup-active');
                                $('#display_user_education_data').load(location.href + " #display_user_education_data");
                                $(addEducationForm)[0].reset();
                                toastr_success_js("{{ __('Education Successfully Added') }}");
                            }
                        }
                    });
                }
            });

            // edit education
            $(document).on('click','.edit_single_education',function(){
                let id = $(this).data('id');
                let institution = $(this).data('institution');
                let subject = $(this).data('subject');
                let degree = $(this).data('degree');
                let start_date = $(this).data('start_date');
                let end_date = $(this).data('end_date');

                $('#edit_id').val(id);
                $('#edit_institution').val(institution);
                $('#edit_subject').val(subject);
                $('#edit_degree').val(degree);
                $('#edit_start_date_edu').val(start_date);
                $('#edit_start_date_edu').parent().find('.date-picker').val(start_date);
                $('#edit_end_date_edu').val(end_date);
                $('#edit_end_date_edu').parent().find('.date-picker').val(end_date);
            });

            // update education
            $(document).on('click','.update_single_education',function(){
                let id = $('#edit_id').val();
                let institution = $('#edit_institution').val();
                let subject = $('#edit_subject').val();
                let degree = $('#edit_degree').val();
                let start_date = $('#edit_start_date_edu').val();
                let end_date = $('#edit_end_date_edu').val();
                if(institution == '' || subject == '' || degree == '' || start_date == '' || end_date == ''){
                    toastr_warning_js('Please fill all fields !');
                    return false;
                }else{
                    $.ajax({
                        url: "{{ route('freelancer.account.education.update') }}",
                        type: 'post',
                        data: {
                            id: id,
                            institution: institution,
                            subject:subject,
                            degree:degree,
                            start_date:start_date,
                            end_date:end_date,
                        },
                        success: function(res){
                            if(res.status == 'ok'){
                                toastr_success_js("{{ __('Education Successfully Updated') }}");
                                $('.popup-fixed, .popup-overlay').removeClass('popup-active');
                                $('#display_user_education_data').load(location.href + " #display_user_education_data");
                                $(addExperienceForm)[0].reset();
                            }
                        }
                    });
                }
            });

            //delete education
            $(document).on('click','.delete_education',function(e){
                e.preventDefault();
                let education_id = $(this).data('id');
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('To delete this education !') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes, delete it!') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"{{ route('freelancer.education.delete') }}",
                            method:'post',
                            data:{id:education_id},
                            success:function(res){
                                if(res.status == 'success'){
                                    $('#display_user_education_data').load(location.href + ' #display_user_education_data');
                                    toastr_delete_js("{{ __('Education Successfully Deleted') }}")
                                }
                            }
                        })
                    }
                })
            })

            // edit experience
            $(document).on('click','.edit_single_experience',function(){
                let id = $(this).data('id');
                let title = $(this).data('title');
                let organization = $(this).data('organization');
                let address = $(this).data('address');
                let short_description = $(this).data('short_description');
                let start_date = $(this).data('start_date');
                let end_date = $(this).data('end_date');

                $('#edit_id').val(id);
                $('#edit_experience_title').val(title);
                $('#edit_organization').val(organization);
                $('#edit_address').val(address);
                $('#edit_short_description').val(short_description);
                $('#edit_start_date').val(start_date);
                $('#edit_start_date').parent().find('.date-picker').val(start_date);
                $('#edit_end_date').parent().find('.date-picker').val(end_date);
                $('#edit_end_date').val(end_date);
            });

            // todo add experience
            $(document).on('click','.add_experience',function(){
                let experience_title = $('#experience_title').val();
                let organization = $('#organization').val();
                let address = $('#address').val();
                let short_description = $('#short_description').val();
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();

                if(experience_title == '' || organization == '' || address == '' || short_description == '' || start_date == ''){
                    toastr_warning_js("{{ __('Please fill all fields !') }}");
                    return false;
                }
                if(end_date != '' && start_date >end_date){
                    toastr_warning_js("{{ __('Start date must not greater than end date !') }}");
                    return false;
                }else{
                    $.ajax({
                        url: "{{ route('freelancer.account.experience.add') }}",
                        type: 'post',
                        data: {
                            experience_title: experience_title,
                            organization:organization,
                            address:address,
                            short_description:short_description,
                            country_id:1,
                            state_id:1,
                            start_date:start_date,
                            end_date:end_date,
                        },
                        success: function(res){
                            if(res.status == 'ok'){
                                $('.popup-fixed, .popup-overlay').removeClass('popup-active');
                                $('#display_user_experience_data').load(location.href + " #display_user_experience_data");
                                $(addExperienceForm)[0].reset();
                                toastr_success_js("{{ __('Experience Successfully Added') }}");
                            }
                        }
                    });
                }
            });

            $(document).on('keyup', '#search-order-input', function () {
                let search = $(this).val();
                $('.order_sort.btn-profile.btn-bg-1').trigger("click");
            })

             // update experience
             $(document).on('click','.update_single_experience',function(){
                let id = $('#edit_id').val();
                let experience_title = $('#edit_experience_title').val();
                let organization = $('#edit_organization').val();
                let address = $('#edit_address').val();
                let short_description = $('#edit_short_description').val();
                let start_date = $('#edit_start_date').val();
                let end_date = $('#edit_end_date').val();
                if(experience_title == '' || organization == '' || address == '' || short_description == '' || start_date == ''){
                    toastr_warning_js('Please fill all fields !');
                    return false;
                }
                if(end_date != '' && start_date >end_date){
                    toastr_warning_js("{{ __('Start date must not greater than end date !') }}");
                    return false;
                }else{
                    $.ajax({
                        url: "{{ route('freelancer.account.experience.update') }}",
                        type: 'post',
                        data: {
                            id: id,
                            experience_title: experience_title,
                            organization:organization,
                            address:address,
                            short_description:short_description,
                            country_id:1,
                            state_id:1,
                            start_date:start_date,
                            end_date:end_date,
                        },
                        success: function(res){
                            if(res.status == 'ok'){
                                $('.popup-fixed, .popup-overlay').removeClass('popup-active');
                                $('#display_user_experience_data').load(location.href + " #display_user_experience_data");
                                $(addExperienceForm)[0].reset();
                                toastr_success_js("{{ __('Experience Successfully Updated') }}");
                            }
                        }
                    });
                }
            });

            
            //delete experience
            $(document).on('click','.delete_experience',function(e){
                e.preventDefault();
                let education_id = $(this).data('id');
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('To delete this experience !') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes, delete it!') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"{{ route('freelancer.experience.delete') }}",
                            method:'post',
                            data:{id:education_id},
                            success:function(res){
                                if(res.status == 'success'){
                                    $('#display_user_experience_data').load(location.href + ' #display_user_experience_data');
                                    toastr_delete_js("{{ __('Experience Successfully Deleted') }}")
                                }
                            }
                        })
                    }
                })
            })


        });
    }(jQuery));

    // todo toastr warning
    function toastr_warning_js(msg){
        Command: toastr["warning"](msg)
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
        Command: toastr["error"](msg)
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


    function setSortBy(type) {
        $('#sort_by_value').val(type);
        $('.order_sort.btn-profile.btn-bg-1').trigger("click");

        if(type== 'priority'){
            $('#sorting-heading').text("Priority Orders");
        }
        else if(type== 'latest'){
            $('#sorting-heading').text("Latest Orders");
        }
        else if(type== 'budget'){
            $('#sorting-heading').text(" Highest Budget Order");
        }
    }

</script>