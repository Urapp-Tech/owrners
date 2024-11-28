@extends('backend.layout.master')
@section('title', __('Gig Ranking Manager Settings'))
@section('style')
    <x-media.css/>
@endsection

@section('content')
    <div class="dashboard__body">
        <div class="row">
            <div class="col-lg-12">
                <div class="customMarkup__single">
                    <div class="customMarkup__single__item">
                        <div class="customMarkup__single__item__flex">
                            <h4 class="customMarkup__single__title">{{ __('Gig Ranking Manager Settings') }}</h4>
                        </div>
                        <x-validation.error />
                        <div class="customMarkup__single__inner mt-4">
                            <x-notice.general-notice :class="'mt-5'" :description="__('Notice: Only one algorithm can be active at a time. Select the one you want to use for gig ranking, and deactivate the others if needed.')" />

                            <!-- Table for Listing Algorithms -->
                            <div class="custom_table style-06 search_result">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Algorithm Name') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($algorithms as $algorithm)
                                            <tr>
                                                <td>{{ $algorithm->name }}</td>
                                                <td>{{ $algorithm->description }}</td>
                                                <td>
                                                    <x-status.active-inactive :status="$algorithm->is_active ?1 : 0" />
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.gig-ranking.toggle-status', $algorithm->id) }}" 
                                                       class="btn btn-sm btn-primary">
                                                       {{ $algorithm->is_active ? __('Deactivate') : __('Activate') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End of Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-media.markup/>
@endsection
