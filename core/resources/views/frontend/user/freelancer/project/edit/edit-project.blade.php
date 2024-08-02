@extends('frontend.layout.master')
@section('site_title',__('Edit Gig'))
@section('style')
    <x-summernote.summernote-css />
    <x-select2.select2-css/>
    <style>
        .disabled-link {
            background-color: #ccc !important;
            pointer-events: none;
            cursor: default;
        }
        .project-extra {
            border-radius: 25px;
            border: 1px solid var(--body-color);
            padding: 20px;
            background-color: var(--section-bg-1);
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <main>
        <x-breadcrumb.user-profile-breadcrumb :title="__('Edit Gig')" :innerTitle="__('Edit Gig')"/>
        <!-- Account Setup area Starts -->
        <div class="account-area section-bg-2 pat-100 pab-100">
            <div class="container">
                <div class="setup-wrapper create-project-wrap">
                    <div class="setup-wrapper-flex">
                        @include('frontend.user.freelancer.project.create.project-sidebar')
                        <div class="create-project-wrapper">
                            <x-validation.error />
                            <form action="{{ route('freelancer.project.edit',$project_details->id )}}" id="submit_edit_project_form" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="basic_title" id="set_basic_title">
                                <input type="hidden" name="standard_title" id="set_standard_title">
                                <input type="hidden" name="premium_title" id="set_premium_title">

                                @include('frontend.user.freelancer.project.edit.project-introduction')
                                @include('frontend.user.freelancer.project.edit.project-image')
                                @include('frontend.user.freelancer.project.edit.project-package-charge')
                                @include('frontend.user.freelancer.project.edit.project-extras')
                                @include('frontend.user.freelancer.project.edit.project-footer')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Account Setup area end -->
    </main>
@endsection

@section('script')
    @include('frontend.user.freelancer.project.edit.edit-project-js')
    <x-summernote.summernote-js-function />

    
    <script type="text/html" id="project-extra-template">
        <div class="col-lg-12 col-xxl-6 col-md-12 col-12 project-extra-parent">
            <div class="project-extra">
                <div class="row align-items-center">
                    <div class="col-6 col-lg-4">
                        <div class="single-input mb-0">
                            <label for="extras_title" class="label-title"></label>
                            <input type="text" name="extras_title[]" id="extras_title" value="" step="" placeholder="Name" class="form--control">
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="single-input mb-0">
                            <label class="label-title" for="is_basic_standard_premium"></label>
                            <select class="form--control" name="is_basic_standard_premium[]" id="">
                                <option value="Basic">Basic</option>
                                <option value="Standard">Standard</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-12 col-lg-4 d-flex align-items-center">
                        <div class="col-8">
                            <div class="single-input mb-0">
                                <label for="extras_price" class="label-title"></label>
                                <input type="number" name="extras_price[]" id="extras_price" value="" step="" placeholder="Price" class="form--control">
                            </div>
                        </div>
                        <div class="col-4 justify-content-end d-flex">
                            <button class="btn btn-outline-danger rounded-circle delete-project-extra">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                    </div>
                    <hr class="mt-3">
                    <div class="col-12">
                        <div class="single-input mt-1">
                            <label class="label-title" for="extras_description">Description</label>
                            <textarea class="form--control" id="extras_description" name="extras_description[]"> </textarea>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <script>
        initializeSummernote($('#project_description'), {
            onKeyup: function(e) {
                setTimeout(function(){
                    let description_min_length = 50;
                    let project_description_length = $('#project_description').val().length;
                    if(project_description_length < description_min_length){
                        $('#project_description_char_length_check').html('<p class="text text-danger">{{ __('Length is short, minimum ') }}'+ description_min_length +' {{ __('required') }}.</p>');
                    }else{
                        $('#project_description_char_length_check').html('<p class="text text-success">{{ __('Length is valid') }}</p>');
                    }
                },200);
            }
        })
    </script>
    <x-select2.select2-js />
@endsection
