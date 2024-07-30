@extends('frontend.layout.master')
@section('site_title',__('All Gigs'))
@section('style')
    <style>
        .project_photo_preview {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
@endsection
@section('content')
    <main>
        <x-breadcrumb.user-profile-breadcrumb :title="__('All Gigs')" :innerTitle="__('All Gigs')"/>
        <!-- Profile Settings area Starts -->
        <div class="responsive-overlay"></div>
        <div class="profile-settings-area pat-25 pab-100 section-bg-2">
            <div class="container">
                <div class="row g-4">
                    {{-- @include('frontend.user.layout.partials.sidebar') --}}
                    <div class="col-xl-12 col-lg-12">
                        <div class="profile-settings-wrapper section-bg-1 p-3 rounded-30">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="p-4"> Gig </h3>
                                </div>
                                <div class="justify-content-end align-content-center">
                                    <a href="{{ route('freelancer.project.create') }}" class="btn-outline-owrners">
                                        <i class="fas fa-plus mx-2"></i>
                                        Create a Gig
                                    </a>
                                </div>
                            </div>
                            <div>
                                <div class="myOrder-wrapper-tabs">
                                    <div class="tabs">
                                        <button class="order_sort btn-profile btn-bg-1" data-val="all">
                                            {{ __('All') }} <span>  </span>
                                        </button>
                                        <button class="order_sort" data-val="pending">
                                            {{ __('Pending Approval') }}  </span>
                                        </button>
                                        <button class="order_sort" data-val="declined">
                                            {{ __('Declined') }}  </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="myOrder-tab-content">
                                <div class="tab-content-item active">
                                    <div id="search-result">

                                        <div class="custom_table style-06 table-rounded-rows px-4">
                                            <table>
                                                <thead>
                                                    <tr>
                                                         <th>Gig Name</th>
                                                         <th>Orders</th>
                                                         <th>Gig Category</th>
                                                         <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($projects as $project)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <div class="project_photo_preview_container">
                                                                        @if($project->image)
                                                                            <img src="{{ asset('assets/uploads/project/'.$project->image) }}" alt="{{ __('Gig Image') }}" class="project_photo_preview">
                                                                        @endif
                                                                    </div>
                                                                    <div class="align-content-center px-3">
                                                                        {{ $project->title }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $project->orders_count }}</td>
                                                            <td>{{ $project->project_category->category }}</td>
                                                            <td>
                                                                <div class="d-flex mx-3">
                                                                    <a href="{{ route('freelancer.project.edit', $project->id) }}">
                                                                        <i class="fas fa-pen"></i>
                                                                    </a>
                                                                    @if($project?->orders_count == 0)
                                                                        <a href="javascript:void(0)" class=" delete_project mx-2" data-project-id="{{ $project->id }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
            
                                        </div>
                                        <x-pagination.laravel-paginate :allData="$projects" />
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
<x-sweet-alert.sweet-alert2-js/>

<script>
    $(document).ready(function () {
        //delete project
        $(document).on('click','.delete_project',function(e){
                e.preventDefault();
                var button = this;
                let project_id = $(this).data('project-id');
                $('.change-portfolio-popup, .popup-overlay').removeClass('popup-active');
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('To delete this project !') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes, delete it!') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"{{ route('freelancer.project.delete') }}",
                            method:'post',
                            data:{project_id:project_id},
                            success:function(res){
                                if(res.status == 'success'){
                                    $(button).parents('tr').remove();
                                    $('.project_wrapper_area').load(location.href + ' .project_wrapper_area');
                                    toastr_delete_js("{{ __('Gig Successfully Deleted') }}")
                                }
                            }
                        })
                    }
                })
            })

            $(document).on('click', '.order_sort', function () {
                $(this).siblings().removeClass('btn-profile');
                $(this).siblings().removeClass('btn-bg-1');
                $(this).addClass('btn-profile btn-bg-1');
                var type = $(this).data('val');
                $.ajax({
                    url: "{{ route('freelancer.projects.filter')}}",
                    data: {type: type},
                    success: function (res) {
                        $('#search-result').html(res);
                    }
                })
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
