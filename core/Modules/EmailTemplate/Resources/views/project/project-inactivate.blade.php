@extends('backend.layout.master')
@section('title', __('Gig Inactivate Email'))
@section('style')
    <x-summernote.summernote-css />
@endsection
@section('content')
    <div class="dashboard__body">
        <div class="row">
            <div class="col-lg-12">
                <div class="customMarkup__single">
                    <div class="customMarkup__single__item">
                        <div class="customMarkup__single__item__flex">
                            <h4 class="customMarkup__single__title">{{ __('Gig Inactivate Email') }}</h4>
                        </div>
                        <div class="search_delete_wrapper">
                            <h4><a class="btn-profile btn-bg-1" href="{{ route('admin.email.template.all') }}">{{ __('All Templates') }}</a></h4>
                            <x-search.search-in-table :id="'string_search'" />
                        </div>
                        <div class="customMarkup__single__inner mt-4">
                            <x-validation.error />
                            <form action="{{route('admin.user.project.inactivate')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <x-form.text
                                    :title="__('Email Subject')"
                                    :type="__('text')"
                                    :name="'project_inactivate_email_subject'"
                                    :id="'project_inactivate_email_subject'"
                                    :value="get_static_option('project_inactivate_email_subject') ?? __('Gig Inactivate Email')"
                                />
                                <x-form.summernote
                                    :title="__('Email Message')"
                                    :name="'project_inactivate_email_message'"
                                    :id="'project_inactivate_email_message'"
                                    :value="get_static_option('project_inactivate_email_message') ?? '' "
                                />
                                <small class="form-text text-muted text-danger margin-top-20"><code>@name</code> {{__('will be replaced by dynamically with user first name.')}}</small><br>
                                <small class="form-text text-muted text-danger margin-top-20"><code>@project_id</code> {{__('will be replaced by dynamically with project id.')}}</small><br>
                                <x-btn.submit :title="__('Save')" :class="'btn-gradient update_info'" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <x-summernote.summernote-js />
@endsection
