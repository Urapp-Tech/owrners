@extends('backend.layout.master')
@section('title', __('Order Manual Payment Email To User'))
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
                            <h4 class="customMarkup__single__title">{{ __('Order Manual Payment Email To User') }}</h4>
                        </div>
                        <div class="search_delete_wrapper">
                            <h4><a class="btn-profile btn-bg-1" href="{{ route('admin.email.template.all') }}">{{ __('All Templates') }}</a></h4>
                            <x-search.search-in-table :id="'string_search'" />
                        </div>
                        <div class="customMarkup__single__inner mt-4">
                            <x-validation.error />
                            <form action="{{route('admin.order.manual.payment.complete.email')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <x-form.text
                                    :title="__('Email Subject')"
                                    :type="__('text')"
                                    :name="'order_manual_payment_complete_subject'"
                                    :id="'order_manual_payment_complete_subject'"
                                    :value="get_static_option('order_manual_payment_complete_subject') ?? __('Order Manual Payment Complete')"
                                />
                                <x-form.summernote
                                    :title="__('Email Message')"
                                    :name="'order_manual_payment_complete_message'"
                                    :id="'order_manual_payment_complete_message'"
                                    :value="get_static_option('order_manual_payment_complete_message') ?? '' "
                                />
                                <small class="form-text text-muted text-danger margin-top-20"><code>@name</code> {{__('will be replaced by dynamically with  name.')}}</small><br>
                                <small class="form-text text-muted text-danger margin-top-20"><code>@order_id</code> {{__('will be replaced by dynamically with order id.')}}</small><br>
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
