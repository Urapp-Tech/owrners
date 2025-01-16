<!-- Profile Settings Popup Starts -->
<div class="popup-overlay"></div>
<form id="edit_profile_form" method="post">
    @csrf
    <div class="popup-fixed profile-popup">
        <div class="popup-contents">
            <span class="popup-contents-close popup-close"> <i class="fas fa-times"></i> </span>
            <h2 class="popup-contents-title"> {{ __('Personal Information') }} </h2>
            <x-notice.general-notice :description="__('Notice: Except state and city all fields are required. Your identity verify documents info must be similar your personal info.')" />

            <div class="popup-contents-form custom-form profile-border-top">

                <div class="error_msg_container"></div>

                <div class="single-flex-input">
                    <x-form.text :title="__('First Name')" :type="__('text')" :name="'first_name'" :id="'first_name'" :placeholder="__('Type First Name')" :value="Auth::guard('web')->user()->first_name ?? '' "/>
                    <x-form.text :title="__('Last Name')" :type="__('text')" :name="'last_name'" :id="'last_name'" :placeholder="__('Type Last Name')" :value="Auth::guard('web')->user()->last_name ?? '' "/>
                </div>
                <div class="single-flex-input">
                    <x-form.email :title="__('Your Email')" :type="__('email')" :name="'email'" :id="'email'" :placeholder="__('Type Email')" :value="Auth::guard('web')->user()->email ?? '' "/>
                </div>
                <div class="single-flex-input">
                    <x-form.country-dropdown :title="__('Select Your Country')" :id="'country_id'"/>
                </div>
                <div class="single-flex-input">
                    <div class="single-input">
                        <label class="label-title">{{ __('Select Your State') }}</label>
                        <select name="{{ $name ?? '' }}" id="state_id" class="form-control get_country_state state_select2">
                            <option value="">{{ __('Select State') }}</option>
                            @if(Auth::guard('web')->user()->country_id > 0)
                                @php
                                    $all_states = \Modules\CountryManage\Entities\State::where('country_id',Auth::guard('web')->user()->country_id )->where('status',1)->select(['id','state','country_id','status'])->get();
                                @endphp
                                @foreach($all_states as $state)
                                    <option value="{{ $state->id }}" @if(Auth::guard('web')->check() && $state->id == Auth::guard('web')->user()->state_id) selected @endif>{{ $state->state }}</option>
                                @endforeach
                            @endif

                        </select>
                        <span class="state_info"></span>
                    </div>
                    

                    <div class="single-input">
                        <label class="label-title">{{ __('Select Your City') }}</label>
                        <select name="{{ $name ?? '' }}" id="city_id" class="form-control get_state_city city_select2">
                            <option value="">{{ __('Select City') }}</option>
                            @if(Auth::guard('web')->user()->state_id > 0)
                                @php
                                    $all_cities = \Modules\CountryManage\Entities\City::where('state_id',Auth::guard('web')->user()->state_id )->where('status',1)->select(['id','city','country_id','state_id','status'])->get();
                                @endphp
                                @foreach($all_cities as $city)
                                    <option value="{{ $city->id }}" @if($city->id == Auth::guard('web')->user()->city_id) selected @endif>{{ $city->city }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="city_info"></span>
                    </div>
                </div>
            </div>
            <div class="popup-contents-btn flex-btn profile-border-top justify-content-end">
                <x-btn.close :title="__('Cancel')" :class="'btn-profile btn-outline-gray btn-hover-danger color-one popup-close'" />
                <x-btn.submit :title="__('Update Profile')" :class="'btn-profile btn-bg-1'" />
            </div>
        </div>
    </div>
</form>
</div>
<!-- Profile Settings Popup Ends -->
