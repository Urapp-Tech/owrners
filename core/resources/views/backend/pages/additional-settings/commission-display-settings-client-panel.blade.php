@extends('backend.layout.master')
@section('title', __('Display Commission Settings'))
@section('style')
    <x-media.css/>
@endsection
@section('content')
    <div class="dashboard__body">
        <div class="row">
            <div class="col-lg-6">
                <div class="customMarkup__single">
                    <div class="customMarkup__single__item">
                        <div class="customMarkup__single__item__flex">
                            <h4 class="customMarkup__single__title">{{ __('Display Commission Settings') }}</h4>
                        </div>
                        <x-validation.error />
                        <div class="customMarkup__single__inner mt-4">
                            <x-notice.general-notice :class="'mt-5'" :description="__('Notice: If you want to disable display commission amount, pending balance, earned balanced from client panel inside order details keep this disable.')" />
                            <form action="{{route('admin.commission.display.settings')}}" method="post">
                                @csrf
                                <div class="single-input my-5">
                                    <label class="label-title">{{ __('Enable/Disable Display Commission') }}</label>
                                    <select name="commission_disable_client_panel" class="form-control">
                                        <option value="">{{ __('Enable-Disable') }}</option>
                                        <option value="enable" @if(get_static_option('commission_disable_client_panel') == 'enable') selected @endif>{{ __('Enable') }}</option>
                                        <option value="disable" @if(get_static_option('commission_disable_client_panel') == 'disable') selected @endif>{{ __('Disabled') }}</option>
                                    </select>
                                </div>
                                <x-btn.submit :title="__('Update')" :class="'btn-gradient mt-4 '" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-media.markup/>
@endsection
