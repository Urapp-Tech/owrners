@extends('backend.layout.master')
@section('title', __('All Category Types'))
@section('style')
    <x-select2.select2-css />
    <x-media.css/>
@endsection
@section('content')
    <div class="dashboard__body">
        <div class="row">
            <div class="col-lg-12">
                <x-notice.general-notice :description="__('Notice: A category type can be deleted only if it has no dependencies. It can be removed if it is not associated with any jobs, projects, or skills.')" />
                <div class="customMarkup__single">
                    <div class="customMarkup__single__item">
                        <div class="customMarkup__single__item__flex">
                            <h4 class="customMarkup__single__title">{{ __('All Category Types') }}</h4>
                            @can('category-type-add')
                            <x-btn.add-modal :title="__('Add Category Type')" />
                            @endcan
                        </div>
                        <div class="search_delete_wrapper">
                            @can('category-type-bulk-delete')
                            <x-bulk-action.bulk-action />
                            @endcan
                            <x-search.search-in-table :id="'string_search'" />
                        </div>
                        <div class="customMarkup__single__inner mt-4">
                            <!-- Table Start -->
                            <div class="custom_table style-06 search_result">
                                @include('service::category_type.search-result')
                            </div>
                            <!-- Table End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('service::category_type.add-modal')
    @include('service::category_type.edit-modal')
    <x-media.markup/>
@endsection

@section('script')
    <x-media.js/>
    <x-sweet-alert.sweet-alert2-js />
    <x-select2.select2-js />
    <x-bulk-action.bulk-delete-js :url="route('admin.subcategory.delete.bulk.action')"/>
    @include('service::category_type.subcategory-js')
@endsection
